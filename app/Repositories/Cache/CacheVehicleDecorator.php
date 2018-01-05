<?php

namespace App\Repositories\Cache;

use App\Repositories\VehicleRepository;

class CacheVehicleDecorator extends BaseCacheDecorator implements VehicleRepository {
    public function __construct(VehicleRepository $vehicle) {
        parent::__construct();
        $this->entityName = 'vehicle';
        $this->repository = $vehicle;
    }
}
