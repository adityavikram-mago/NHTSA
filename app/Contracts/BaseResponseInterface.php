<?php

namespace App\Contracts;

interface BaseResponseInterface {
    /*
     * @param array $source
     * @param Illuminate\Database\Eloquent\Collection or Illuminate\Support\Collection $collection
     * @return json format
     */
    public function response($collection);
}
