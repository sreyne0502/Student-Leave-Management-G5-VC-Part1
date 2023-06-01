<?php

use App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\MailController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Send Email
Route::get('/send-mail', [MailController::class, 'sendEmail']);

// Send Email When Admin Create Student To Student
Route::post('/account-smls', [StudentController::class,'smlsEmail']);

// Send Email Reject to student
Route::post('/reject-mail/{id}', [StudentController::class,'rejectEMail']);

// Send Email Reject to student 
Route::post('/approved-mail/{id}', [StudentController::class,'approvedMail']);


// -------------------admin--------------------
Route::post('/create', [AdminController::class, 'store']);
Route::post('/login', [AdminController::class, 'login']);
Route::apiResource("/admin", AdminController::class);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/studentsInAdmin', StudentController::class);
    Route::apiResource("leaves", LeaveController::class);
   
    Route::get('/getOneAdmin/{id}', [AdminController::class, 'show']);
    Route::put('/editAdminProfile/{id}', [AdminController::class, 'editProfile']);
    Route::put("/edit/{id}", [StudentController::class, 'editStudentAdmin']);
    // Uplaod Profile 
    Route::put('/updateProfile/{id}', [StudentController::class, 'updateProfile']);
    Route::post('/logout', [AdminController::class, 'logout']);
});
Route::post('/resetPaswordAdmin/{id}', [AdminController::class, 'resetPassword']);
Route::put('/resetPaswordAdmin/{id}', [AdminController::class, 'update']);
// -------------------student--------------------
Route::post('/loginStudent', [StudentController::class, 'login']);
Route::get('/studentCompare', [StudentController::class, 'index']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::put('/updatePhoto/{id}', [StudentController::class, 'updatePhoto']);
    Route::apiResource('/students', StudentController::class);
    Route::apiResource("/leaves", LeaveController::class);
    Route::get("/getAdminId", [AdminController::class, 'index']);
    Route::get("/getOneStudent/{id}", [StudentController::class, 'getOneStudent']);
    Route::post('/logOutStudent', [StudentController::class, 'signOut']);
});

// Reset Password of student
Route::post('/reset-password-student/{id}', [StudentController::class, 'resetPassword']);
Route::put('/reset-password-student/{id}', [StudentController::class, 'update']);
// Uplaod Profile Student
Route::put('/updateProfile/{id}', [StudentController::class, 'updateProfile']);
// Upload Profile Admin 
Route::put('/uploadProfileAdmin/{id}', [AdminController::class, 'uploadProfileAdmin']);
