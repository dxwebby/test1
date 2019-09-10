<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// Validator
use Validator;

use App\Todo;
use Auth;
class TodoVueController extends Controller
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
        return response()->json([
            'todos' => $todos,
        ]);        
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
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255'
        ]);

        // Fails
        if($validator->fails()){
            return response()->json([
                'success' => false
            ]);
        }

        // Success
        $todo = Todo::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'todo' => $todo
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
