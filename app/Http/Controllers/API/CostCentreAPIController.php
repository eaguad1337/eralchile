<?php namespace App\Http\Controllers\API;

use EAguad\Model\CostCentre;
use EAguad\Model\User;
use Illuminate\Http\Request;

class CostCentreAPIController
{

    /**
     * @param Request $request
     * @param CostCentre $costCentre
     * @return void
     */
    public function addReviewer(Request $request, CostCentre $costCentre)
    {
        $user = User::whereEmail($request->get('email'))->firstOrFail();

        if ($costCentre->hasReviewer($user)) {
            return response()->json(['success' => false, 'message' => 'El usuario ya está agregado.']);
        }

        $costCentre->reviewers()
            ->syncWithoutDetaching([$user->id]);

        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * @param Request $request
     * @param CostCentre $costCentre
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeReviewer(Request $request, CostCentre $costCentre, User $user)
    {
        if (!$costCentre->hasReviewer($user)) {
            return response()->json(['success' => false, 'message' => 'El usuario no pertenece al centro de costo.']);
        }

        $costCentre->reviewers()
            ->detach($user->id);

        return response()->json(['success' => true]);
    }
}
