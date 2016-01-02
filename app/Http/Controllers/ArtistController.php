<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Artist;
use App\Model\Roles;
use App\Model\Album;

/**
 * Class ArtistController
 * @package App\Http\Controllers
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 */
class ArtistController extends Controller
{
    public function index()
    {
        return view('artist/index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function artistList()
    {
        $artists = Artist::with('roles')->orderBy('name')->get();
        return response()->json($artists);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        try {
            $this->validate($request, Artist::$rules);
            $input = $request->all();
            $artist = new Artist($input);
            $roles = Roles::whereIn('id', $input['roles'])->get();
            $artist->save();
            $artist->roles()->saveMany($roles);
            return response()->json(['status' => 'success']);
        } catch(ValidationException $e) {
            return response()->json(['status' => 'validation_error', 'messages' => $e->validator->errors()]);
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $artists = Artist::find($id);
        if (!$artists) {
            return response()->json(['status' => 'error', 'message' => 'artista no encontrado']);
        }
        try {
            $this->validate($request, Artist::$rules);
            $input = $request->all();
            $artists->name = $input['name'];
            $roles = Roles::whereIn('id', $input['roles'])->get();
            $artists->save();
            $artists->roles()->saveMany($roles);
            return response()->json(['status' => 'success']);
        } catch(ValidationException $e) {
            return response()->json(['status' => 'validation_error', 'messages' => $e->validator->errors()]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'server_error', 'message' => $e->getMessage()]);
        }
    }

    /**
     *
     * show detail for a album
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $artist = Artist::with('Album', 'Roles')->find($id);
        return response()->json($artist);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        $artist = Artist::with('Album', 'Roles')->find($id);

        if ($artist->delete()) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['error' => 'error', 'message' => 'no se pudo eliminar el artista']);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function roleDelete($id, $role) {
        $artist = Artist::with('Album', 'Roles')->find($id);
        $artist->roles()->detach($role);
        $artist->save();
        return response()->json(['status' => 'success']);
    }
} 