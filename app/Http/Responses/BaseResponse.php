<?php

namespace App\Http\Responses;

use App\Contracts\BaseResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class BaseResponse implements BaseResponseInterface{

    public function response($collection) {
        return response()->json([
            'Count'   => $collection->count(),
            'Results' => $collection,
        ], Response::HTTP_OK);
    }
}
