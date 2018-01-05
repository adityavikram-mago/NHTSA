<?php

namespace App\Http\Controllers;

use App\Http\Responses\VehicleResponse;
use App\Repositories\VehicleRepository;
use \Illuminate\Http\Request;


class VehiclesController extends Controller {

    protected $vehicle;
    protected $response;

    public function __construct(VehicleRepository $vehicle, VehicleResponse $response) {
        $this->vehicle = $vehicle;
        $this->response = $response;
    }

    /**
     * Filter vehicles by Model Year, Manufacturer and Model with or without withRating param.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter($modelYear = null, $manufacturer = null, $model = null, Request $request) {
        // build params
        $params = [
            'modelYear'    => $modelYear,
            'manufacturer' => $manufacturer,
            'model'        => $model,
        ];
        $params = array_merge($params, $request->all());

        if (isset($params['withRating']) && $params['withRating'] == 'true') {
            $params['fillExtraAttributes'] = true;
            $vehicles = $this->vehicle->findAllByAttributes($params);
            return $this->response->responseWithRating($vehicles);
        } else {
            $vehicles = $this->vehicle->findAllByAttributes($params);
            return $this->response->response($vehicles);
        }
    }
}

