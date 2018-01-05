<?php

namespace App\Repositories\Eloquent;

use App\Entities\Vehicle;
use App\Repositories\VehicleRepository;
use App\Services\NhtsaService;
use Illuminate\Database\Eloquent\Collection;

class EloquentVehicleRepository extends EloquentBaseRepository implements VehicleRepository {

    protected $nhtsaService;

    public function __construct($model) {
        parent::__construct($model);
        $this->nhtsaService = new NhtsaService();
    }

    public function find($id) {
        $data = $this->nhtsaService->find($id);
        if (isset($data['Results']) && !empty($data['Results'])) {
            $vehicle = new Vehicle();
            $vehicle->fill($data['Results'][0]);
            return $vehicle;
        }
        return false;
    }

    public function findAllByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc') {
        $collection = new Collection();
        $vehicles = $this->nhtsaService->findAllByAttributes($attributes);

        foreach ($vehicles['Results'] as $item) {
            $vehicle = new Vehicle();
            $vehicle->fill($item);

            if (isset($attributes['fillExtraAttributes'])) {
                $vehicle = $this->find($vehicle->VehicleId);
            }

            if ($vehicle) {
                $collection->add($vehicle);
            }
        }
        return $collection;
    }
}
