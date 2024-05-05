<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function karim() {
        return response()->json(['msg' => 'we should return data']);
    }

    public function test(){
        return response()->json([
            'msg' => 'some error occured',
        ], 422);
    }
}
