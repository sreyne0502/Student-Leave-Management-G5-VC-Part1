<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return leave::all();

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
        $leave = $request->validate([
            'type' => 'required|String',
            'start_date' => 'required|Date',
            'end_date' => 'required|Date',
            'duration' => 'required|numeric',
            'cause' => 'String',
            'status' => 'String',
            'admin_id' => 'required|Integer',
            'student_id' => 'required|Integer',
        ]);
        leave::create($leave);
        return response()->json(['sms'=>$leave]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $leave= leave::findOrFail($id);
        $leave->status = $request->status;
        $leave->save();
        return response()->json(["sms"=>"Update is successful"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
