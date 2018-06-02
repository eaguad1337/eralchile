<?php namespace App\Http\Controllers\API;

use EAguad\Model\User;

class UserAPIController {

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['data' => User::get()]);
    }
}
