<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response as BaseResponse;


class NhtsaService {

    protected $client;

    public function __construct() {
        $this->client = app(Client::class);
    }

    /**
     * Get all information of vehicle
     *
     * @param $id
     *
     * @return json string
     */
    public function find($id) {
        try {
            $response = $this->client->request(
                'GET',
                'VehicleId/' . $id
            );
        } catch (\Exception $e) {
            return [];
        }

        if (!$this->isValidResponse($response)) {
            return [];
        }
        return json_decode($response->getBody(), true);
    }

    /**
     * Find vehicle by attributes
     *
     * @param array $attributes
     *
     * @return json string
     */
    public function findAllByAttributes(array $attributes) {
        $empty = [
            'Count' => 0,
            'Results' => []
        ];
        try {
            $response = $this->client->request(
                'GET',
                $this->buildRouteParameters($attributes)
            );

        } catch (\Exception $e) {
            return $empty;
        }

        if (!$this->isValidResponse($response)) {
            return $empty;
        }

        return json_decode($response->getBody(), true);
    }



    private function isValidResponse($response) {
        if ($response->getStatusCode() != BaseResponse::HTTP_OK) {
            return false;
        }

        $body = json_decode($response->getBody(), true);
        return isset($body['Results']);
    }

    private function buildRouteParameters(array $attributes) {
        $routeParameters = [];
        if (isset($attributes['modelYear']) && $attributes['modelYear']) {
            $routeParameters[] = 'modelyear';
            $routeParameters[] = $attributes['modelYear'];
        }
        if (isset($attributes['manufacturer']) && $attributes['manufacturer']) {
            $routeParameters[] = 'make';
            $routeParameters[] = $attributes['manufacturer'];
        }
        if (isset($attributes['model']) && $attributes['model']) {
            $routeParameters[] = 'model';
            $routeParameters[] = $attributes['model'];
        }
        return implode('/', $routeParameters);
    }
}

