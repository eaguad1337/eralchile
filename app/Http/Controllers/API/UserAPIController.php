<?php namespace App\Http\Controllers\API;

use EAguad\Model\User;
use Illuminate\Http\Request;

class UserAPIController {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $usersQuery = User::query();

        $queryString = $request->get('q');

        if ($queryString) {
            $usersQuery
                ->orWhere('name', 'like', '%' . $queryString . '%')
                ->orWhere('email', 'like', '%' . $queryString . '%')
                ;
        }

        $users = $usersQuery
            ->limit(15)
            ->get();

        return response()->json(['data' => $users]);
    }
}
