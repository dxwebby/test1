<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;

// Redirect
use Illuminate\Support\Facades\Redirect;

// Validator
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{

    /**
     * Auth
     */
    public function __construct(){
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                
        $todos = Todo::where('user_id',  '=', auth()->user()->id)->orderBy('id', 'asc')->get();
        return view('home', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        // Validation

       /*  request()->validate([
            'title' => 'required|min:3|max:255',            
        ]); */
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',                     
        ]);

        // Method A
        /**
         * Since data have already been validated only if there are external data from the form itself
         */
        // #Todo::create($validated);

        // Method B
        // #Todo::create(request(['user_id', 'title']));
        Todo::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title
        ]);

        return redirect('/todo');        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return view('show', compact('todo'));     
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
        /////////////////////////////////     
        // Ajax
        $validator = Validator::make($request->all(), [
            'new_title' => 'required|min:3|max:255'
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "data" => $validator->invalid()
            ]);
        }
        
        $todo = Todo::findOrfail($id);
        $todo->title = $request->new_title;
        $todo->save();

        return response()->json([
            "success" => true,
            "new_title" => ucwords($request->new_title)
        ]);
        
     
        /////////////////////////////////
        // Non-Ajax
        $validated = $request->validate([
            'new_title' => 'required|min:3|max:255'
        ]);
        $todo = Todo::findOrfail($id);
        $todo->title = $request->new_title;
        $todo->save();
        
        // With Flash Message
        return redirect()->back()->with('flash-message','You have successfully changed the title!');          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {      
        
        // Ajax
        $todo = Todo::where('id', $id);
        if($todo->exists()){
            $todo->delete();
            return response()->json([
                'success' => true
            ]);
        }
        
        return response()->json([
            'success' => false
        ]);

        // Non-Ajax
        $todo = Todo::findOrfail($id);        
        $todo->delete();        
        return redirect('/todo')->with('flash-message', ucwords($todo->title) . ' has been successfully deleted');
    }
}
