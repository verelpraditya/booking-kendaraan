<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_booking = $request->input('show_booking');

        // Mengambil data dengan id driver
        if ($id) {
            $driver = Driver::with('bookingDetails')->find($id);

            if ($driver) {
                return ResponseFormatter::success(
                    $driver,
                    'Data Driver Berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Driver tidak ditemukan',
                    404
                );
            }
        }

        // Mengambil data dengan nama driver
        if ($name) {
            $driver = Driver::with('bookingDetails');
            $driver->where('name', 'Like', '%' . $name . '%');

            return ResponseFormatter::success(
                $driver->first(),
                'Data Driver Berhasil ditemukan'
            );
        }

        $driver = Driver::query();

        if ($show_booking) {
            $driver->with('bookingDetails');
        }

        return ResponseFormatter::success(
            $driver->paginate($limit),
            "Data Driver berhasil diambil"
        );
    }
}
