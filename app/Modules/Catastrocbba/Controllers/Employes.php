<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Employe;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Employes extends Controller
{
    public function index($id = null) {
        if ($id == null) {
            return Employe::orderBy('id', 'asc')->get();
        } else {
            return $this->show($id);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $employe = new Employe;

        $employe->name = $request->input('name');
        $employe->email = $request->input('email');
        $employe->contact_number = $request->input('contact_number');
        $employe->position = $request->input('position');
        $employe->save();

        return 'Employe record successfully created with id ' . $employe->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return Employe::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $employe = Employe::find($id);
        

        $employe->name = $request->input('name');
        $employe->email = $request->input('email');
        $employe->contact_number = $request->input('contact_number');
        $employe->position = $request->input('position');
        $employe->save();

        return "Sucess updating user #" . $employe->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request) {
        $employe = Employe::find($request->input('id'));

        $employe->delete();

        return "Employe record successfully deleted #" . $request->input('id');
    }

}
