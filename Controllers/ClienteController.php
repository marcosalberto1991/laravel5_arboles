<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Cliente;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function index()
        {
            $data = Cliente::all();
            return view('Cliente.index')->with('data',$data);
        }

        /*
         * Add student data
         */
        public function add(Request $request)
        {
            $data = new Cliente;
            $data -> nombre = $request -> Nombre;
            $data -> apellido = $request -> Apellido;
            $data -> Direccion = $request -> Direccion;
            
            
            $data -> save();
            return back()
                    ->with('success','Se añadio el Cliente.');
        }

        /*
         * View data
         */
        public function view(Request $request)
        {
            if($request->ajax()){
                $id = $request->id;
                $info = Cliente::find($id);
                //echo json_decode($info);
                return response()->json($info);
            }
        }

        /*
        *   Update data
        */
        public function update(Request $request)
        {
            $id = $request -> edit_id;
            $data = Cliente::find($id);
            $data -> nombre = $request -> edit_nombre;
            $data -> apellido = $request -> edit_apellido;
            $data -> Direccion = $request -> edit_Direccion;
            

            

            //$data -> email = $request -> edit_email;
            $data -> save();
            return back()
                    ->with('success','Producto Modificado.');
        }

        /*
        *   Delete record
        */
        public function delete(Request $request)
        {
            $id = $request -> id;
            $data = Cliente::find($id);
            $response = $data -> delete();
            if($response)
                echo "Producto ya fue Eliminado.";
            else
                echo "Hubo un poblema a eliminar el productos";
        }
    }
?>
   