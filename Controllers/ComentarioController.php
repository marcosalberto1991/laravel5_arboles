<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Comentario;
use View;


class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
    * @var array
    */
    protected $rules =
    [
        'nombre' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
        'mensajec' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i',
        //'punto' => 'required|min:100000|max:99999999',
        'punto' => 'required|numeric|integer|min:000000|max:99999999',

        'respuestas' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i',
        //'' => 'required|min:100000|max:99999999'
        'idcomentario' => 'required|numeric|integer|min:000000|max:99999999',


    ];

   


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comentario = Comentario::all();

        return view('comentario.index', ['listmysql' => $comentario]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $comentario = new Comentario();
            $comentario->nombre = $request->nombre;
            $comentario->mensajec = $request->mensajec;
            $comentario->punto = $request->punto;
            $comentario->respuestas = $request->respuestas;
            $comentario->idcomentario = $request->idcomentario;
            $comentario->save();
            return response()->json($comentario);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comentario = Comentario::findOrFail($id);

        return view('comentario.show', ['comentario' => $comentario]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $comentario = Comentario::findOrFail($id);
            $comentario->nombre = $request->nombre;
            $comentario->mensajec = $request->mensajec;
            $comentario->punto = $request->punto;
            $comentario->respuestas = $request->respuestas;
            $comentario->idcomentario = $request->idcomentario;
            $comentario->save();
            return response()->json($comentario);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return response()->json($comentario);
    }


    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');

        $comentario = Comentario::findOrFail($id);
        $comentario->is_published = !$comentario->is_published;
        $comentario->save();

        return response()->json($comentario);
    }
}