<?php namespace App\Http\Controllers\API;

use EAguad\Model\Provider;
use Illuminate\Http\Request;

class ProviderAPIController {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Provider::query();

        $queryString = $request->get('q');

        if ($queryString) {
            $query
                ->orWhere('cardcode', 'like', '%' . $queryString . '%')
                ->orWhere('cardname', 'like', '%' . $queryString . '%')
                ->orWhere('city', 'like', '%' . $queryString . '%')
                ->orWhere('country', 'like', '%' . $queryString . '%')
                ->orWhere('zipcode', 'like', '%' . $queryString . '%')
                ;
        }

        $data = $query
            ->limit(15)
            ->get();

        return response()->json(['data' => $data]);
    }
}
