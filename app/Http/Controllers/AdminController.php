<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Deadline;
use DB;

class AdminController extends Controller
{
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $deadlines = Deadline::orderBy('created_at','desc')->paginate(10);
        return view('deadlines.index')->with('deadlines', $deadlines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        if($user->isAdmin == true)
            return view('deadlines.create');
        else{
            return view('errors.permission');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if($user->isAdmin == true){
            $this->validate($request, [
                'date' => 'required',
                'name' => 'required',
            ]);

        
            // Create Deadline
            $deadline = new Deadline;
            $deadline->name = $request->input('name');
            $deadline->date = $request->input('date');
            $deadline->save();

            return redirect('/deadlines')->with('success', 'Deadline Added');        
        }
        else{
            return view('errors.permission');
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
        $deadlines = Deadline::find($id);
        return view('deadlines.show')->with('deadlines', $deadlines);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = auth()->user();
        if($user->isAdmin == true){
            $deadline = Deadline::find($id);
        
            if (!isset($deadline)){
                return redirect('/deadlines')->with('error', 'No Deadline Found');
            }
            return view('deadlines.edit')->with('deadline', $deadline);
        }
        else{
            return view('errors.permission');
        }
       
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


        $user = auth()->user();
        if($user->isAdmin == true){
            $this->validate($request, [
                'date' => 'required',
                'name' => 'required'
            ]);
            $deadline = Deadline::find($id);
             // Handle File Upload
           
    
            // Update Post
            $deadline->name = $request->input('name');
            $deadline->date = $request->input('date');
            
            $deadline->save();
    
            return redirect('/deadlines')->with('success', 'Deadline Updated');
        }
        else{
            return view('errors.permission');
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
        $deadline = Deadline::find($id);
        
        if (!isset($deadline)){
            return redirect('/deadlines')->with('error', 'No Deadline Found');
        }
        $deadline->delete();
        return redirect('/deadlines')->with('success', 'Deadline Removed');
    }
}
