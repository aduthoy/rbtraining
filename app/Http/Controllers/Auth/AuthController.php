<?php

namespace App\Http\Controllers\Auth;


use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /*
    |------------------------------------------------------------------------------------------
    | Registration & Login Controller
    |------------------------------------------------------------------------------------------
    |
    | This controller hadles the resiration of new users, as well as the
    | authentication of existing users. By default, ths controller uses
    | a single trait to add these behaviors. Why don't you explore it?
    |
     */
    //use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * AuthController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function authenticate(Request $request) {
        $credentials = $request->only('email','password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'las credenciales del usuario son incorrectas'],401);
            }
        } catch (JWTException $ex) {
            return response()->json(['Error' => 'Algo salio mal'],500);
        }

        return response()->json(compact('token'),200);
    }

    /**
     * create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     *
     *
     * @param Request $request
     * @return Response
     */
    public function getUserInfoByEMail(Request $request)
    {
        $userInfo = User::where('email','=',$request->email)->get();
        if ($userInfo ) {
            return response($userInfo,200);
        }
        return response()->json(['Error' => 'Usuario no localizado'],404);
    }

    public function updateUserById(Request $request, $id)
    {
        $userInfo = User::find($id);
        if ($userInfo) {
            $userInfo->remember_token = $request->token;
            if ($userInfo->save()) {
                return response($id,200);
            }
            return response()->json(['Error' => 'Ocurrio un error no ducmentado al actualizar al usuario'],500);
        }
        return response()->json(['Error' => 'Usuario no existe'],404);
    }
}