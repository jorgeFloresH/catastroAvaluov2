<?php
/*
*@author Cesar Antonio Rocha Cruz
*/
namespace App\Modules\Catastrocbba\Controllers\Api;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Catastrocbba\Models\User;

class AuthController extends Controller {

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return Response::json(array( 'error' => "Cuenta invalida"), 401);
            }else{
                $user = Auth::User();
                $usuario = User::where('id','=',$user->id)->first();
                if($usuario->estado=="VA"){
                    return Response::json(array( 'error' => "Cuenta aun no validada",'token'=>''), 200);
                }else{
                    if($usuario->estado=="EL"){
                        return Response::json(array( 'error' => "Cuenta eliminada"), 401);
                    }else {
                        if($usuario->estado=="AC"){
                            return response()->json(compact('token'));
                        }else{
                            return Response::json(array( 'error' => "Cuenta invalida."), 401);
                        }
                    }
                }
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return Response::json(array( 'error' => "No se pudo crear el token"), 500);
        }

        // all good so return the token
        
    }


    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        JWTAuth::invalidate($request->input('token'));
    }
}