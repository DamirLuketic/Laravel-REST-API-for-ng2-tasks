<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'cors'], function(){

    // route for access  user task (by ID)
    Route::post('/tasks/{user_id}', function(Request $requests, $user_id)
    {
        $tasks = User::findOrFail($user_id)->tasks;
        return json_encode($tasks);
    });

    // Route for check user registration status
    Route::post('/user/{email}/{password}', function(Request $requests, $email, $password)
    {
        $user = User::whereEmail($email)->whereActive(1)->first();
        $return = null;
        if($user != null){
            if (password_verify($password, $user->password)){
                $return = array_except($user, ['for_activation', 'created_at', 'updated_at', 'active']);
            }
        }
        return json_encode($return);
    });

    // Route for register user -> with e-mail check
    Route::post('/register/{name}/{email}/{password}', function(Request $request, $name, $email, $password)
    {
        $test_email = User::whereEmail($email)->first();

        if($test_email == null){
            $input['name'] = $name;
            $input['email'] = $email;
            $input['password'] = Hash::make($password);
            $input['for_activation'] = rand();
            User::create($input);
            return json_encode('in db');
        }else{
            return json_encode('email in usage');
        }
    });

});


























