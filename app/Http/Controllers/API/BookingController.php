<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\bookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        // Mengambil dengan id Booking Detail
        if ($id) {
            $booking = bookingDetail::with(['vehicle', 'driver'])->find($id);

            if ($booking) {
                return ResponseFormatter::success(
                    $booking,
                    'Data Berhasil Diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data tidak ditemukan',
                    404
                );
            }
        }

        $booking = bookingDetail::with(['vehicle', 'driver'])->where('users_id', Auth::user()->id);

        if ($status) {
            $booking->where('status', $status);
        }

        return ResponseFormatter::success(
            $booking->paginate($limit),
            'Data List berhasil Diambil'
        );
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'tanggal' => 'required',
            'waktu' => 'required',
            'status' => 'required|in:PENDING,CANCELLED, APPROVED, PROCCESS, SUCCESS'
        ]);

        $booking = bookingDetail::create([
            'users_id' => Auth::user()->id,
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => $request->driver_id,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'status' => $request->status,

        ]);

        return ResponseFormatter::success($booking, 'Booking Berhasil');
    }
}
