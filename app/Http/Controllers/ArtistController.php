<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Model\Artist;

/**
 * Class ArtistController
 * @package App\Http\Controllers
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 */
class ArtistController extends Controller
{

    public function artistList()
    {
        $artists = Artist::orderBy('name')->get();
        return response()->json($artists);
    }

} 