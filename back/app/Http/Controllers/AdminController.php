<?php

namespace App\Http\Controllers;

use App\Models\Admin;
Use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Admin::all();
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
        $admin = new Admin();
        $admin -> first_name = $request->first_name;
        $admin -> last_name = $request->last_name;
        $admin -> email = $request->email;
        $admin -> password = Hash::make($request->password);
        $admin -> age = $request->age;
        $admin -> profile_image = $request->profile_image;
        $admin->save();
        $token=$admin->createToken('admin-token')->plainTextToken;
        return response()->json(['token'=>$token]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Admin::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->password = Hash::make($request->password);
        $admin->save();
    }
     // Reset Password 
     public function resetPassword(Request $request, $id)
     {
         $admin =  Admin::findOrFail($id);
         if (Hash::check($request->password, $admin['password'])) {
             $admin->password = bcrypt($request->new_password);
             $admin->save();
             return response()->json(['sms' => 'Password updated!'], 201);
         }
         return response()->json(['sms' => 'Password incorrect!'], 404);
     }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request, $id)
    {
        $Upateadmin = Admin::findOrFail($id);
        $Upateadmin -> first_name = $request->first_name;
        $Upateadmin -> last_name = $request->last_name;
        $Upateadmin -> email = $request->email;
        $Upateadmin -> age = $request->age;
        $Upateadmin->save();
        return response()->json(['sms'=>"Update is successfull"]);
    }

    // Uplaod Image Admin
    public function uploadProfileAdmin(Request $request , $id)
    {
        $path = public_path('images');
        if ( ! file_exists($path) ) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('profile_image');
        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $fileName);

         $admin = Admin::findOrFail($id);
         $admin -> profile_image = asset('images/' . $fileName);
         $admin ->save();
         return response()->json(['sms'=> $admin ]);
    }

    // Login Admin
    public function login(Request $request) {
        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['sms' => "Invalid Email"]);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['sms' => "Invalid Password"]);
        }
        $token = $user->createToken('token_admin')->plainTextToken;
        return response()->json(['sms'=>'Successfully','token'=>$token]);
    }

    
    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json(['sms'=>'Logout is Successful']);
    }
    
}
