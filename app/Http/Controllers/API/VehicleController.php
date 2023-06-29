<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_booking = $request->input('show_booking');

        if ($id) {
            $vehicle = Vehicle::with(['bookingDetails'])->find($id);

            if ($vehicle) {
                return ResponseFormatter::success(
                    $vehicle,
                    'Data kendaraan berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data kendaraan Tidak Ada',
                    404
                );
            }
        }

        if ($name) {
            $vehicle = Vehicle::with(['bookingDetails']);
            $vehicle->where('name', 'Like', '%' . $name . '%');;

            return ResponseFormatter::success(
                $vehicle->paginate($limit),
                'Data kendaraan berhasil diambil'
            );
        }

        $vehicle = Vehicle::query();

        if ($show_booking) {
            $vehicle->with('bookingDetails');
        }

        return ResponseFormatter::success(
            $vehicle->paginate($limit),
            "Data Vehicle berhasil diambil"
        );
    }
}
