<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user','room')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function terima($id)
    {
        $reservation = Reservation::find($id);
        $reservation->update(['status' => 'diterima']);
        return back()->with('success', 'Reservasi berhasil diterima.');
    }

    public function tolak($id)
    {
        $reservation = Reservation::find($id);
        $reservation->update(['status' => 'ditolak']);
        return back()->with('success', 'Reservasi berhasil ditolak.');
    }

}
