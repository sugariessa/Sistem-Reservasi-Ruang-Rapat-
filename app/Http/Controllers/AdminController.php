<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRooms = Room::count();
        $totalReservations = Reservation::count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingReservations = Reservation::where('status', 'menunggu')->count();
        
        $recentReservations = Reservation::with(['room', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $schedule = \App\Models\Schedule::first();

        return view('admin.dashboard.index', compact(
            'totalRooms', 
            'totalReservations', 
            'totalUsers', 
            'pendingReservations',
            'recentReservations',
            'schedule'
        ));
    }

    public function rooms(Request $request)
    {
        $query = Room::withCount('reservations');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        
        if ($request->filled('kapasitas')) {
            switch ($request->kapasitas) {
                case '1-10':
                    $query->whereBetween('kapasitas', [1, 10]);
                    break;
                case '11-20':
                    $query->whereBetween('kapasitas', [11, 20]);
                    break;
                case '21-50':
                    $query->whereBetween('kapasitas', [21, 50]);
                    break;
                case '50+':
                    $query->where('kapasitas', '>', 50);
                    break;
            }
        }
        
        $rooms = $query->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function reservations(Request $request)
    {
        $query = Reservation::with(['room', 'user']);
        
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }
        
        if ($request->filled('user')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }
        
        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);
        $rooms = Room::all();
        
        return view('admin.reservations.index', compact('reservations', 'rooms'));
    }

    public function schedule()
    {
        $rooms = Room::with(['reservations' => function($query) {
            $query->whereDate('date', '>=', Carbon::today())
                  ->where('status', 'diterima')
                  ->orderBy('date')
                  ->orderBy('start_time');
        }])->get();

        return view('admin.schedule', compact('rooms'));
    }

    public function users(Request $request) 
    {
        $query = User::withCount('reservations');
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->filled('joined_date')) {
            $query->whereDate('created_at', $request->joined_date);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'hari_kerja' => 'required|array'
        ]);

        \App\Models\Schedule::updateOrCreate(
            ['id' => 1],
            [
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'hari_kerja' => $request->hari_kerja
            ]
        );

        return redirect()->route('admin.dashboard')->with('success', 'Jam kerja berhasil diatur');
    }
}