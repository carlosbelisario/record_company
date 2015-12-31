<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Artist;
use App\Model\Album;

/**
 *
 * Class AlbumController
 * @package App\Http\Controllers
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 */
class AlbumController extends Controller
{
    /**
     * return the list of albums
     * @return \Illuminate\Http\JsonResponse
     */
    public function albumList()
    {
        $albums = Album::orderBy('title')->get();
        return response()->json($albums);
    }

    /**
     * create a new album
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        try {
            $input = $request->all();
            $album = new Album($input);
            $artists = Artist::whereIn('id', $input['author'])->get();
            $album->save();
            $album->artist()->saveMany($artists);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'server_error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * update a existing album
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $album = Album::find($id);
        if (!$album) {
            return response()->json(['status' => 'error', 'message' => 'album no encontrado']);
        }
        $input = $request->all();
        $album->title = $input['title'];
        $album->published = $input['published'];
        $artists = Artist::whereIn('id', $input['author'])->get();
        $album->save();
        $album->artist()->saveMany($artists);

        return response()->json(['status' => 'success']);
    }

    /**
     *
     * show detail for a album
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $album = Album::with('Artist', 'Artist.Roles')->find($id);
        //$album->load('Artist')->load('');

        return response()->json($album);
    }
} 