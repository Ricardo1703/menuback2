<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($request->password != $request->password_confirmation){
            return response()->json([
                "msg" => "El password no coincide con la confirmación"
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = "propietario";
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            "status" => 1,
            "msg" => "Registro exitoso"
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if( isset($user->id)){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "status" => 1,
                    "msg" => "Usuario logueado",
                    "name" => $user->name,
                    "idUser" => $user->id,
                    "access_token" => $token
                ]);
            }else{
                return response()->json([
                    "status" => 0,
                    "msg" => "El password es incorrecto"
                ], 404);
            }
        }else{
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no registrado"
            ], 404);
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 1,
            "msg" => "Cierre de sesión"
        ]);
    }

    public function update(Request $request, $id){
  
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'whats' => $request->whats
        ]);

        return response()->json([
            "status" => 1,
            "msg" => "Se actualizó tu información"
        ]);

    }

    public function mostrarUser($id){
        $user = User::findOrFail($id);

        return response()->json([
            "status" => 1,
            "name" => $user->name,
            "email" => $user->email,
            "whats" => $user->whats
        ]);

    }

    public function editPass(Request $request, $id){
        $request->validate([
            'password' => 'required'
        ]);

        if($request->password != $request->password_confirmation){
            return response()->json([
                "status" => 0,
                "msg" => "El password no coincide con la confirmación"
            ]);
        }
  
        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "status" => 1,
            "msg" => "Se actualizó tu password" 
        ]);

    }
    public function fotoPerfil(Request $request, $id){
        $user = User::findOrFail($id);

         $imagen = $request->file('imagen');
         $nombreImagen = time().'.'.$imagen->extension();
         $imagen->move('storage/perfiles/', $nombreImagen);
         unlink('storage/perfiles/'.$user->imagen);
      
        $user->imagen = $nombreImagen;
        $user->save();

        return response()->json([
            "status" => 1,
            "msg" => "Se actualizó tu foto de perfil ".$user->id
        ]);
    }

    public function verFoto(Request $request, $id){
        $user = User::findOrFail($id);

        return response()->json([
            "status" => 1,
            "msg" => "Usuario logueado",
            "imagen" => $user->imagen
        ]);

    }

    public function obtenerUser($id){
        $user = User::findOrFail($id);
        return response()->json([
            "status" => 1,
            "msg" => "ok",
            "name" => $user->name,
            "imagen" => $user->imagen,
            "whats" => $user->whats
        ]);
    }
    
}
