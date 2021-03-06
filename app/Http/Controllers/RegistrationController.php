<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\StudentDetail;
use App\Drive;
use App\Form;
use App\FormItems;
use App\Registeration;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userdata = StudentDetail::where('admission_number', $user->admission_number)->firstOrFail();
        //dd($userdata);
        $drives=Drive::all();
        return view('student.drives', compact('user', 'userdata','drives'));
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
        //
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

    public function register(Request $request,$id){
        $user = Auth::user();
        $userdata = StudentDetail::where('admission_number', $user->admission_number)->firstOrFail();
        //dd($userdata);
        $form=Form::where('drive_id',$id)->get('form_item_id');
        
        $code=[];
        $data=[];
        $js=[];
        foreach($form as $f){
            array_push($code,FormItems::find($f)[0]->code);
            array_push($data,FormItems::find($f)[0]->key);
            array_push($js,FormItems::find($f)[0]->js);        
        }
        $formdata=StudentDetail::where('admission_number', $user->admission_number)->get($data);
        // dd($formdata);
        return view('student.driveregister', compact('user', 'userdata','code','formdata','js'));
    }

    public function savereg(Request $request, $id){
        $data=$request->all();
        $user = Auth::user();
        unset($data['_token']);
        
        Registeration::create([
            'drive_id' =>$id,
            'student_id' =>$user->id,
            'data' => serialize($data)
        ]);

        return redirect('/student/drive');
    }
}
