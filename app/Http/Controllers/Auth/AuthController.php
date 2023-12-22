<?php

namespace App\Http\Controllers\Auth;

use App\Rol;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    protected $redirectPath = '/admin/dashboard';

    public function redirectPath()
    {
        if(Auth::user()->rol->name == 'admin' || Auth::user()->rol->name == 'moderador')
            return '/admin/dashboard';
        else
            return '/user/dashboard';
    }

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->rol = Rol::firstOrCreate(['name'=>'propietario']);
        $user->save();
        return $user;
    }

    public function getTemporal(Request $request){
        $code = $request->input('c');
        if(!$code){
            return redirect('auth/login')->withInput();
        }
        else{
            $user = User::where('temporary', $code)->first();
            if(!$user){
                return redirect('auth/login')->withInput()->with('message', trans('messages.app.code.invalid'));
            }
            else{
                Auth::login($user);
                return redirect('user/dashboard');
            }
        }
    }
}
