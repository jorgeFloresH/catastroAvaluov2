<?php
/*
*@author Cesar Antonio Rocha Cruz
*/
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HelenaController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showWellcome()
    {
        return view('helena.wellcome', ['mensaje' => "HOLA HELENA"]);
    }

}
