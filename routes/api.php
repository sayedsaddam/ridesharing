<?php

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Resources\EmployeeResource;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;

// Route::get('/hello', function(){
//     return response()->json([
//         'title' => 'Hello',
//         'description' => 'Hello, World! Testing the API call here.'
//     ]);
// });

Route::get('/employees', function(){
    $employees = Employee::orderBy('last_name', 'DESC')->get();
    return EmployeeResource::collection($employees);
});

Route::post('/login', [LoginController::class, 'submit']);
Route::post('/login/verify', [LoginController::class, 'verify']);
Route::group(['middleware' => 'auth:sanctum'], function(){

    Route::get('/driver', [DriverController::class, 'show']);
    Route::post('/driver', [DriverController::class, 'update']);

    Route::post('/trip', [TripController::class, 'store']);
    Route::get('/trip/{trip}', [TripController::class, 'show']);
    Route::post('/trip/{trip}/accept', [TripController::class, 'accept']);
    Route::post('/trip/{trip}/start', [TripController::class, 'start']);
    Route::post('/trip/{trip}/end', [TripController::class, 'end']);
    Route::post('/trip{trip}/location', [TripController::class, 'location']);

    Route::get('/user', function(Request $request){
        return $request->user();
    });
});
