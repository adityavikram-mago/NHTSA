<?php

namespace App\Http\Responses;

class VehicleResponse extends BaseResponse {


    public function response($vehicles) {
        $results = $vehicles->map(function($vehicle) {
            return [
                'Description' => $vehicle->VehicleDescription,
                'VehicleId'   => $vehicle->VehicleId,
            ];
        });
        return parent::response($results);
    }

    /*
     * json response with 'CrashRating'
     */
    public function responseWithRating($vehicles) {
        $results = $vehicles->map(function($vehicle) {
            return [
                'CrashRating' => $vehicle->CrashRating,
                'Description' => $vehicle->VehicleDescription,
                'VehicleId'   => $vehicle->VehicleId,
            ];
        });
        return parent::response($results);
    }
}
