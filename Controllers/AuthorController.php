<?php

namespace App\Http\Controllers;
//namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Http\Request;
use App\Author;
use App\Student;
use Exception;

//use Illuminate\Http\Request;
use Rimorsoft\Http\Requests\AuthorRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AuthorForm;
use App\Http\Controllers\Controller;
//use App\Http\Controllers\Controller;

//use App\Author;

class AuthorController extends Controller
{
    
    public function index(){

        //$users = DB::select('select * from author');
        //$authors = DB::select('select * from author ');
        //$authors = Author::all();
//        $results = DB::select('select * from users where id = :id', ['id' => 1]);

        $authors = DB::select('select * from  author ');

        return view('Author.index', ['data' => $authors]);
        //return view('Author.index')->with('data',$data);




    }
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }

        /*
    public function create( Request $request)
    {
    	$this->validate($request,[
    		'name'=>required
    		])

    	$author=new Author();
    	$author->name=$request->input('name');


    	try{
    		$author->save();

    	}catch(Exception $e){
    		log::errror($e->getMessage());




    	return response()->json([
    		'author'=> $author
    		]);
    	}
    }
        */
    public function store(Request $request)
    {
       // validation
      $this->validate($request,[
      'name'=> 'required',
      'email' => 'required',
      'password' => 'required',

    ]);
      // create new data
    $author = new author;
    $author->name    = $request->name;
    $author->email     = $request->email;
    $author->password = $request->password;
    $author->save();
    //return view('post/',compact('post'));
    //return redirect()->route('post.index')->with('alert-success','Data Hasbeen Saved!');
    //return redirect()->route('Author');
    //return view('Author.index', compact('Author'));
    $authors = Author::all();
    return view('Author.index', ['data' => $authors]);

    //return view("author");


    }
    public function edit($id)
    {
        $author = Author::find($id);
        
        return view('Author.edit', compact('author'));
    //$user = Author::find($id);
    //if (is_null ($user))
    //{
    //App::abort(404);
    //}

    //return View::make('admin/users/form')->with('user', $user);
//}

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = \Rimorsoft\Product::find($id);
        $product->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }

    public function update(Request $request)
        {
            $id = $request -> edit_id;
            $data = Author::find($id);
            $data -> name = $request -> edit_first_name;
            $data -> password = $request -> edit_last_name;
            $data -> email = $request -> edit_email;
            $data -> save();
            return back()
                    ->with('success','Record Updated successfully.');
        }

        /*
        *   Delete record
        */
        public function delete(Request $request)
        {
            $id = $request -> id;
            $data = Author::find($id);
            $response = $data -> delete();
            if($response)
                echo "Record Deleted successfully.";
            else
                echo "There was a problem. Please try again later.";
        }
}


