<?php namespace App\Http\Controllers;

use App\User;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Excel;
use App\Pais;
use App\TipoUsuario;
use App\Educacion;
use App\TipoEducacion;
use App\Publicaciones;
use App\TipoPublicaciones;
use App\Proyectos;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\JsonResponse;


class UsuariosController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
   public function __construct()
	{
		$this->middleware('auth');
	}


   public function form_nuevo_usuario()
	{
        

        $tiposusuario=TipoUsuario::all();
		return view('formularios.form_nuevo_usuario')->with("tiposusuario",$tiposusuario);
	}


	public function listado_usuarios()
    {
        $usuarioactual=\Auth::user();
        $usuarios= User::paginate(25);  
        $paises=Pais::all();
        return view('listados.listado_usuarios')
        ->with("paises", $paises )
        ->with("usuarios", $usuarios )
        ->with("usuario_actual", $usuarioactual );     
	}


	//presenta el formulario para nuevo usuario
	public function agregar_nuevo_usuario(Request $request)
	{

        $data=$request->all();


        $reglas = array('nombres' => 'required',
        	            'apellidos' => 'required',
        	            'pais'=>   'required',
        	            'ciudad' => 'required|Alpha',
        	            'email' => 'required|Email|Unique:users',
        	            'institucion' => 'required|Alpha',
        	            'ocupacion' => 'required|Alpha',
        	            'tipousuario' => 'required|Numeric|min:1|max:2',
        	            );
        $mensajes= array('nombres.required' =>  'Ingresar Nombres es obligatorio',
        	             'apellidos.required' =>  'Ingresar Apellidos es obligatorio',
        	             'pais.required' =>  'el pais es obligatorio',
        	             'ciudad.required' =>  'Ingresar una ciudad es obligatorio',
        	             'ciudad.alpha' =>  'la ciudad no puede contener numeros en su nombre',
        	             'email.required' =>  'Ingresar un email es obligatorio',
        	             'email.email' =>  'el email debe tener un formato valido',
        	             'email.unique' =>  'el email debe ser unico en la base de datos',
        	             'institucion.required' =>  'Ingresar una institucion es obligatorio',
        	             'ocupacion.required' =>  'Ingresar la ocupacion es obligatorio',
        	             'tipousuario.numeric' =>  'Ingresar un tipo de usuario valido ides entre 1 y 2',
        	             );
        

        $validacion = Validator::make($data, $reglas, $mensajes);
        if ($validacion->fails())
        {
			 $errores = $validacion->errors(); 
			 return new JsonResponse($errores, 422); 
	         /*return view("mensajes.msj_rechazado")->with("msj","Existen errores de validación")
			                                      ->with("errors",$errores);*/ 			          
        }



      	$usuario= new User;
		$usuario->nombres  =  $data["nombres"];
		$usuario->apellidos=$data["apellidos"];
		$usuario->pais=$data["pais"];
		$usuario->ciudad=$data["ciudad"];
		$usuario->email=$data["email"];
		$usuario->institucion=$data["institucion"];
		$usuario->ocupacion=$data["ocupacion"];
		$usuario->tipoUsuario=$data["tipousuario"];
		$usuario->password=bcrypt($data["password"]);

		$resul= $usuario->save();

		if($resul){
            
            return view("mensajes.msj_correcto")->with("msj","Usuario Registrado Correctamente");   
		}
		else
		{
             
            return view("mensajes.msj_rechazado")->with("msj","hubo un error vuelva a intentarlo");  

		}
	}

//leccion 7
		public function form_editar_usuario($id)
	{
		//funcion para cargar los datos de cada usuario en la ficha
		$usuario=User::find($id);
		$contador=count($usuario);
		$tiposusuario=TipoUsuario::all();
		
		if($contador>0){          
            return view("formularios.form_editar_usuario")
                   ->with("usuario",$usuario)
                   ->with("tiposusuario",$tiposusuario);   
		}
		else
		{            
            return view("mensajes.msj_rechazado")->with("msj","el usuario con ese id no existe o fue borrado");  
		}
	}




		public function editar_usuario(UsuarioRequest $request)
	{



       $data=$request->all();/*
        $reglas = array('nombres' => 'required',
        	            'apellidos' => 'required',
        	            'pais'=>   'required',
        	            'ciudad' => 'required|Alpha',
        	            'institucion' => 'required|Alpha',
        	            'ocupacion' => 'required|Alpha',
        	            'tipousuario' => 'required|Numeric|min:1|max:2',
        	            );
        $mensajes= array('nombres.required' =>  'Ingresar Nombres es obligatorio',
        	             'apellidos.required' =>  'Ingresar Apellidos es obligatorio',
        	             'pais.required' =>  'el pais es un campo obligatorio',
        	             'ciudad.required' =>  'Ingresar una ciudad es obligatorio',
        	             'ciudad.alpha' =>  'la ciudad no puede contener numeros en su nombre',
        	             'email.required' =>  'Ingresar un email es obligatorio',
        	             'email.email' =>  'el email debe tener un formato valido',
        	             'institucion.required' =>  'Ingresar una institucion es obligatorio',
        	             'ocupacion.required' =>  'Ingresar la ocupacion es obligatorio',
        	             'tipousuario.numeric' =>  'Ingresar un tipo de usuario valido ides entre 1 y 2',
        	             );
        

      
        $validacion = Validator::make($data, $reglas, $mensajes);
        if ($validacion->fails())
        {
			 
			 $errores = $validacion->errors();  
	         return view("mensajes.msj_rechazado")->with("msj","Existen errores de validación")
			                                      ->with("errores",$errores); 			          
        }*/

		
		
		$idUsuario=$data["id_usuario"];
		$usuario=User::find($idUsuario);
        $usuario->nombres  =  $data["nombres"];
		$usuario->apellidos=$data["apellidos"];
		$usuario->pais=$data["pais"];
		$usuario->ciudad=$data["ciudad"];
		$usuario->institucion=$data["institucion"];
		$usuario->ocupacion=$data["ocupacion"];
		$usuario->tipoUsuario=$data["tipousuario"];
		$resul= $usuario->save();

		if($resul){            
            return view("mensajes.msj_correcto")->with("msj","Datos actualizados Correctamente");   
		}
		else
		{            
            return view("mensajes.msj_rechazado")->with("msj","hubo un error vuelva a intentarlo");  
		}
	}

//leccion 8
		public function subir_imagen_usuario(Request $request)
	{

	    $id=$request->input('id_usuario_foto');
		$archivo = $request->file('archivo');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {

	        $nombre_original=$archivo->getClientOriginalName();
			$extension=$archivo->getClientOriginalExtension();
			$nuevo_nombre="userimagen-".$id.".".$extension;
		    $r1=Storage::disk('fotografias')->put($nuevo_nombre,  \File::get($archivo) );
		    $rutadelaimagen="storage/fotografias/".$nuevo_nombre;
	    
		    if ($r1){

			    $usuario=User::find($id);
			    $usuario->imagenurl=$rutadelaimagen;
			    $r2=$usuario->save();
		        return view("mensajes.msj_correcto")->with("msj","Imagen agregada correctamente");
		    }
		    else
		    {
		    	return view("mensajes.msj_rechazado")->with("msj","no se cargo la imagen");
		    }

        }	

	}


	public function cambiar_password(Request $request){
        $email=$request->input("email_usuario");
        $usuariactual=\Auth::user();
        
        if($usuariactual->email != $email ){
		
		$reglas = array('email_usuario' => 'required|Email|Unique:users,email');
		$mensajes = array('email_usuario.unique' => 'El email ingresado ya esta en uso en la base de datos');
      $this->validate($request,$reglas, $mensajes);
           
         }

       

		$id=$request->input("id_usuario_password");
		$email=$request->input("email_usuario");
		$password=$request->input("password_usuario");
		$usuario=User::find($id);
	    $usuario->email=$email;
	    $usuario->password=bcrypt($password);
	    $r=$usuario->save();

	    if($r){
           return view("mensajes.msj_correcto")->with("msj","password actualizado");
	    }
	    else
	    {
	    	return view("mensajes.msj_rechazado")->with("msj","Error al actualizar el password");
	    }
	}

	//leccion 09

	public function form_cargar_datos_usuarios(){
       return view("formularios.form_cargar_datos_usuarios");
	}


    public function cargar_datos_usuarios(Request $request)
	{
       $archivo = $request->file('archivo');
       $nombre_original=$archivo->getClientOriginalName();
	   $extension=$archivo->getClientOriginalExtension();
       $r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
       $ruta  =  storage_path('archivos') ."/". $nombre_original;
       
       if($r1){
       	    $ct=0;
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
		        
		        $hoja->each(function($fila) {
			        $usersemails=User::where("email","=",$fila->email)->first();
			        if(count( $usersemails)==0){
				      	$usuario=new User;
				        $usuario->nombres= $fila->nombres;
				        $usuario->apellidos= $fila->apellidos;
				        $usuario->email= $fila->email;
				        $usuario->telefono= $fila->telefono; //este campo llamado telefono se debe agregar en la base de datos c
				        $usuario->pais= $fila->pais;
				        $usuario->ciudad= $fila->ciudad;
				        $usuario->institucion= $fila->institucion;
		                $usuario->ocupacion= $fila->ocupacion;
		                $usuario->password= bcrypt($fila->password);
		                $usuario->save();
	                }
		     
		        });

            });

            return view("mensajes.msj_correcto")->with("msj"," Usuarios Cargados Correctamente");
    	
       }
       else
       {
       	    return view("mensajes.msj_rechazado")->with("msj","Error al subir el archivo");
       }

	}


		//leccion 10

	public function form_educacion_usuario(){
       return view("formularios.form_educacion_usuario");
	}


        //leccion 12
		public function buscar_usuarios($pais,$dato="")
    {
        
        $usuarioactual=\Auth::user();
        $usuarios= User::Busqueda($pais,$dato)->paginate(25);  
        $paises=Pais::all();
        $paissel=$paises->find($pais);
        return view('listados.listado_usuarios')
        ->with("paises", $paises )
        ->with("paissel", $paissel )
        ->with("usuarios", $usuarios )
        ->with("usuario_actual", $usuarioactual );       
	}


     //leccion 16


      	public function info_datos_usuario($id)
	{
		//funcion para cargar los datos de cada usuario en la ficha
		$usuario=User::find($id);
		$contador=count($usuario);
		$tiposusuario=TipoUsuario::all();
        $tiposeducacion=TipoEducacion::all();
        $educacion= $usuario->educacion();
        $tipopublicaciones=TipoPublicaciones::all();
        $publicaciones= $usuario->publicaciones();
        $rutaarchivos= "../storage/archivos/";
        $proyectos= $usuario->proyectos();
        $rutaarchivos2= "../storage/archivos/";
		
		if($contador>0){          
            return view("standard.info_datos_usuario")
                   ->with("usuario",$usuario)
                   ->with("tiposusuario",$tiposusuario)
                    ->with("tiposeducacion",$tiposeducacion)
                   ->with("educacion",$educacion)
                    ->with("tipopublicaciones", $tipopublicaciones)
                    ->with("publicaciones",$publicaciones) 
                    ->with("rutaarchivos",$rutaarchivos)
                    ->with("proyectos",$proyectos) 
                    ->with("rutaarchivos2",$rutaarchivos2); 
		}
		else
		{            
            return view("mensajes.msj_rechazado")->with("msj","el usuario con ese id no existe o fue borrado");  
		}
	}



	public function mostrar_errores(){
      
       return view("mensajes.msj_rechazado")->with("msj","Existen errores de validacion");

	}







}