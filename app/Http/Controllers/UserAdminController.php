<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Helper;
use App\Rol;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:admin|moderador');
    }

    public function getIndex()
    {
        $propietario = Rol::where('name', 'propietario')->first();
        $users = User::where('rol_id','!=', 'temporal')->where('rol_id', '!=', $propietario->id)->get();
        return view('admin.users', ['users'=>$users]);
    }

    public function getEdit($id){
        $user = User::findOrFail($id);
        $this->can($user);
        $roles = Rol::where('name', '!=', 'propietario')->get();
        return view('admin.users-edit', ['user'=>$user, 'roles'=>$roles]);
    }

    public function getNew(){
        $user = new User;
        $roles = Rol::where('name', '!=', 'propietario')->get();
        return view('admin.users-edit', ['user'=>$user, 'roles'=>$roles]);
    }

    public function postStore(Request $request){
        if($request->input('pass')!=$request->input('repeat_pass')){
            return back();
        }
        $id = $request->input('id', false);
        if($id){
            $user = User::findOrFail($id);
        }
        else
            $user = new User;
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->gestor = $request->input('gestor', 0);
        $user->rol_id = $request->input('rol');
        $rol = Rol::findOrFail($user->rol_id);
        if(Auth::user()->rol->name == 'moderador' && $rol->name == 'admin')
            abort(403);
        $user->mail_identity = $request->input('mail_identity');
        if($request->file('avatar')){
            $location = $request->file('avatar')->move(public_path('images/avatars'), str_slug($user->name).'.jpg');
            $user->avatar = substr($location, strlen(public_path())+1);
        }
        if($request->input('pass')){
            $user->password = bcrypt($request->input('pass'));
        }

        if($user->gestor){
            if($user->contact_id)
                $contact = Contact::findOrFail($user->contact_id);
            else
                $contact = new Contact;
            $contact->user_id = $request->user()->id;
            $contact->names = $user->name;
            $contact->mail = $user->email;
            $contact->phones = $request->input('phones');
            $contact->save();
            $user->contact_id = $contact->id;
        }
        $user->save();
        return redirect(Helper::getPathFor('admin/users'));
    }

    public function getToggle($id){
        $user = User::findOrFail($id);
        $this->can($user);
        $user->active = abs($user->active-1);
        $user->save();
        return redirect(Helper::getPathFor('admin/users'));
    }

    private function can($user){
        if($user->rol->name == 'admin' && Auth::user()->rol->name != 'admin')
            abort(403);
    }
}
