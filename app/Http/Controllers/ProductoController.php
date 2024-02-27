<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;

class ProductoController extends Controller
{
    public function menu($id){
        try{
            $lista = Producto::where('user_id', $id)->orderBy('name', 'ASC')->get();
            return response()->json($lista, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function menuClientes($id){
        try{
            $lista = Producto::where('user_id', $id)->orderBy('name', 'ASC')->get();
            return response()->json($lista, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function editPlatillo(Request $request, $id){
                

        $producto = Producto::findOrFail($request->input('id'));

       // $user = User::where('id', $id)->get();

        if($producto->user_id != $id){
            return response()->json([
                "status" => 0,
                "msg" => "No se puede actualizar porque pertenece a otro usuario"
            ]);
        }
        if($request->file('imagen')){
            $imagen = $request->file('imagen');
            $nombreImagen = time().'.'.$imagen->extension();
            $imagen->move('storage/platillos', $nombreImagen);

            unlink('storage/platillos/'.$producto->imagen);

            $producto->update([
                'name' => $request->input('name'),
                'descripcion' => $request->input('descripcion'),
                'precio' => $request->input('precio'),
                'imagen' => $nombreImagen
            ]);
        }else{
            $producto->update([
                'name' => $request->input('name'),
                'descripcion' => $request->input('descripcion'),
                'precio' => $request->input('precio'),
            ]);
        }
        
        return response()->json([
            "status" => 1,
            "msg" => "Se actualizó correctamente"
        ]);

    }

    public function agregarPlatillo(Request $request, $id){
        
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'descripcion' => 'required',
            'precio' => 'required'
        ]);

         $imagen = $request->file('imagen');
         $nombreImagen = time().'.'.$imagen->extension();
         $imagen->move('storage/platillos', $nombreImagen);

        Producto::create([
            'user_id' => $id,
            'name' => $request->input('name'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'imagen' => $nombreImagen
        ]);

        return response()->json([
            "status" => 1,
            "msg" => "Se agregó correctamente"
        ]);
    }


}
