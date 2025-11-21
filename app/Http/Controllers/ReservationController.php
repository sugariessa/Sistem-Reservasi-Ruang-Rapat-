<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function dashboard()
    {
        $totalReservations = Reservation::where('user_id', auth()->id())->count();
        $pendingReservations = Reservation::where('user_id', auth()->id())->where('status', 'menunggu')->count();
        $approvedReservations = Reservation::where('user_id', auth()->id())->where('status', 'diterima')->count();
        $cancelledReservations = Reservation::where('user_id', auth()->id())->where('status', 'dibatalkan')->count();
        $recentReservations = Reservation::where('user_id', auth()->id())
            ->with('room')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard.index', compact(
            'totalReservations',
            'pendingReservations', 
            'approvedReservations',
            'cancelledReservations',
            'recentReservations'
        ));
    }

    public function rooms()
    {
        $rooms = Room::paginate(9);
        return view('user.rooms.index', compact('rooms'));
    }

    public function index(Request $request)
    {
        $query = Reservation::where('user_id', auth()->id())->with('room');
        
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }
        
        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);
        $rooms = Room::all();

        return view('user.reservations.index', compact('reservations', 'rooms'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'aktif')->get();
        $schedule = Schedule::first();
        return view('user.reservations.create', compact('rooms', 'schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'keperluan' => 'required|string'
        ]);
        
        // Validasi jam untuk hari ini
        if ($request->date === date('Y-m-d')) {
            $currentTime = date('H:i');
            if ($request->start_time <= $currentTime) {
                return back()->with('error', 'Tidak dapat membuat reservasi untuk jam yang sudah terlewat.');
            }
        }

        $schedule = Schedule::first();
        if ($schedule) {
            $dayName = Carbon::parse($request->date)->locale('id')->dayName;
            $dayMapping = [
                'Minggu' => 'Minggu',
                'Senin' => 'Senin', 
                'Selasa' => 'Selasa',
                'Rabu' => 'Rabu',
                'Kamis' => 'Kamis',
                'Jumat' => 'Jumat',
                'Sabtu' => 'Sabtu'
            ];
            
            if (!in_array($dayMapping[$dayName], $schedule->hari_kerja)) {
                return back()->with('error', 'Reservasi tidak dapat dilakukan pada hari ' . $dayName . '. Silakan pilih hari kerja.');
            }
            
            if ($request->start_time < $schedule->jam_mulai || $request->end_time > $schedule->jam_selesai) {
                return back()->with('error', 'Jam reservasi harus dalam rentang jam kerja (' . $schedule->jam_mulai . ' - ' . $schedule->jam_selesai . ').');
            }
        }

        $conflict = Reservation::where('room_id', $request->room_id)
            ->where('date', $request->date)
            ->whereIn('status', ['menunggu', 'diterima'])
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Jadwal bentrok. Silakan pilih waktu lain.');
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'keperluan' => $request->keperluan,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'menunggu'
        ]);

        return redirect()->route('user.reservations')->with('success', 'Reservasi berhasil diajukan dan menunggu persetujuan admin.');
    }

    public function show($id)
    {
        $reservation = Reservation::where('user_id', auth()->id())
            ->where('id', $id)
            ->with('room')
            ->firstOrFail();

        return view('user.reservations.detail', compact('reservation'));
    }

    public function cancel($id)
    {
        $reservation = Reservation::where('user_id', auth()->id())
            ->where('id', $id)
            ->whereIn('status', ['menunggu', 'diterima'])
            ->firstOrFail();

        $reservationDateTime = Carbon::parse($reservation->date . ' ' . $reservation->start_time);
        $now = Carbon::now();

        if ($reservationDateTime->isPast()) {
            return back()->with('error', 'Tidak dapat membatalkan reservasi yang sudah berlalu.');
        }

        $reservation->update(['status' => 'dibatalkan']);

        return redirect()->route('user.reservations')->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function getSchedule(Request $request)
    {
        $reservations = Reservation::where('room_id', $request->room_id)
            ->where('date', $request->date)
            ->whereIn('status', ['menunggu', 'diterima'])
            ->with('user')
            ->orderBy('start_time')
            ->get();

        return response()->json($reservations);
    }
}
