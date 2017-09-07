<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function index()
        {
            $data = Product::all();
            return view('Producto.index')->with('data',$data);
        }

        /*
         * Add student data
         */
        public function add(Request $request)
        {
            $data = new Product;
            $data -> name = $request -> name;
            $data -> short = $request -> short;
            $data -> body = $request -> body;
            $data -> last_name = $request -> last_name;
            
            $data -> save();
            return back()
                    ->with('success','Se añadio el producto.');
        }

        /*
         * View data
         */
        public function view(Request $request)
        {
            if($request->ajax()){
                $id = $request->id;
                $info = Product::find($id);
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
            $data = Product::find($id);
            $data -> name = $request -> edit_name;
            $data -> short = $request -> edit_short;
            $data -> body = $request -> edit_body;
            $data -> last_name = $request -> edit_last_name;

            

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
            $data = Product::find($id);
            $response = $data -> delete();
            if($response)
                echo "Producto ya fue Eliminado.";
            else
                echo "Hubo un poblema a eliminar el productos";
        }
    }
?>
   