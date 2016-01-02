<?php


namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Model\Roles;


/**
 * Class RolesController
 * @package App\Http\Controllers
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 */
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

    /**
     * add new artist role
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        try {
            $this->validate($request, Roles::$rules);
            $input = $request->all();
            $role = new Roles($input);
            $role->save();
            return response()->json(['status' => 'success']);
        } catch(ValidationException $e) {
            return response()->json(['status' => 'validation_error', 'messages' => $e->validator->errors()]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'server_error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * update a artist role
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $role = Roles::find($id);
        if (!$role) {
            return response()->json(['status' => 'error', 'message' => 'rol no encontrado']);
        }
        try {
            $this->validate($request, Roles::$rules);
            $input = $request->all();
            $role->rol = $input['rol'];
            $role->save();
            return response()->json(['status' => 'success']);
        } catch(ValidationException $e) {
            return response()->json(['status' => 'validation_error', 'messages' => $e->validator->errors()]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'server_error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * delete a artist role
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        $role = Roles::with('Artist')->find($id);
        if (!$role) {
            return response()->json(['error' => 'error', 'message' => 'no se encontro el rol indicado']);
        }
        if ($role->artist()->delete()) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['error' => 'error', 'message' => 'no se pudo eliminar el rol']);
        }
    }

    /**
     * detail of role
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $roles = Roles::with('Artist')->find($id);
        return response()->json($roles);
    }
}