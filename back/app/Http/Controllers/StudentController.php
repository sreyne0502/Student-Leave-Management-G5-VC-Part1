<?php

namespace App\Http\Controllers;


use App\Models\student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Auth\Middleware\Authenticate;

use Mail;
use App\Mail\registerMail;
use App\Mail\rejectMail;
use App\Mail\approveMail;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return student::with('leave')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = new student();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->batch = $request->batch;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->phone = $request->phone;
        $student->profile_image = $request->profile_image;
        $student->admin_id = $request->admin_id;
        $student->save();
        $token = $student->createToken('student-token')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    /**
     * Display the specified resource.
     
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return student::with('leave')->where('id', $id)->get();
    }
    public function getOneStudent($id)
    {
        return student::findOrFail($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $student = student::findOrFail($id);
        $student->password = Hash::make($request->password);
        $student->save();
    }

    public function updateProfile(Request $request, $id)
    {
        $path = public_path('images');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('profile_image');

        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $fileName);
        $student = student::findOrFail($id);
        $student->profile_image = asset('images/' . $fileName);
        $student->save();
        return response()->json(['sms' => $student]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return student::destroy($id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $student = student::where('email', $request->email)->first();
        if (!$student) {
            return response()->json(['sms' => "Invalid Email"]);
        }
        if (!Hash::check($request->password, $student->password)) {
            return response()->json(['sms' => "Invalid Password"]);
        }
        $token = $student->createToken('my-token')->plainTextToken;
        return response()->json(['sms' => '"Successfully"', 'token' => $token]);
    }
    public function signOut()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['sms' => 'Logout is successful']);
    }

    // Reset Password 
    public function resetPassword(Request $request, $id)
    {
        $student =  student::findOrFail($id);
        if (Hash::check($request->password, $student['password'])) {
            $student->password = $request->new_password;
            $student->save();
            return response()->json(['sms' => 'Password updated!'], 201);
        }
        return response()->json(['sms' => 'Password incorrect!'], 404);
    }
    public function editStudentAdmin(Request $request, $id)
    {
        //
        $student = student::findOrFail($id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->save();
        return response()->json(['sms' => 'successful']);
    }

    // Send mail when admin create student
    public function smlsEmail(Request $request)
    {
        $details = [
            'title' => 'Dear Student',
            'body' => 'Here is your account of 
            Student Management Leave System and password is 12345678',
        ];
         
        Mail::to($request->email)->send(new registerMail($details));
           
        return("Email is sent successfully.");
    }

    
    // Send Email when Admin reject
    public function rejectEMail(Request $request ,$id)
    {

        $student = student::findOrFail($id);

        $reject = [
            'title' => 'Dear student ,',
            'body' =>'I am do not allow you ',
        ];

        Mail::to($student)->send(new rejectMail($reject));

        return("Email is sent successfully.");
    }
    public function approvedMail(Request $request , $id)
    {
        $student = student::findOrFail($id);

        $approve = [
            'title' => 'Dear Student ,',
            'body' => 'I am allowed you !',
        ];

        Mail::to($student)->send(new approveMail($approve));
        
        return ("Email is sent successfully !!");
    }
}
