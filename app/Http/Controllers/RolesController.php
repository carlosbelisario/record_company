<?php


namespace App\Http\Controllers;

use App\Model\Roles;


class RolesController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolesList()
    {
        $roles = Roles::orderBy('rol')->get();
        return response()->json($roles);
    }
}