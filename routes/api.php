<?php

use App\User;
use App\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

    // Route for register user -> with e-mail usage check and confirmation of e-mail
    Route::post('/register/{name}/{email}/{password}', function(Request $request, $name, $email, $password)
    {
        $test_email = User::whereEmail($email)->first();

        if($test_email == null){
            $input['name'] = $name;
            $input['email'] = $email;
            $input['password'] = Hash::make($password);
            $input['for_activation'] = rand();
            $user = User::create($input);

            $user_id = $user->id;

            // collect data for e-mail and send mail for confirmation
            $data = [
                'name' => $name,
                'link' => 'http://localhost/laravel_rest_api/public/api/confirm_email/' . $user_id . '/' . $input['for_activation'],
                'email' => $email
            ];

            Mail::send('emails.email', $data, function ($message) use ($data){
                $message->from('luketic.damir@gmail.com', 'Damir Luketic');
                $message->to($data['email'], $data['name'])->subject('E-mail confirmation');
            });

            // response after accept/refuse registration
            return json_encode('Confirm e-mail to activate account');
        }else{
            return json_encode('email in usage');
        }
    });

    // route for e-mail confirmation and account activation
    Route::get('/confirm_email/{user_id}/{activation_key}', function($user_id, $activation_key){
        $user = User::whereId($user_id)->whereForActivation($activation_key);
        $affected = $user->update(['active' => 1]);

        if($affected != 0){

            $user = User::findOrFail($user_id);
            $user_name = $user->name;

            return view('user.welcome', compact('user_name'));
        }else{
            echo 'Acitvation failed';
        }

    });

    // Route for edit task
    Route::put('/edit_task/{task}', function(Request $request, $task)
    {
        $task = Tasks::findOrFail($request->id);
        $task->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return json_encode('The task is changed.');

    });

    // Route for delete task
    Route::delete('/delete_task/{task_id}', function ($task_id)
    {
        Tasks::destroy($task_id);

        return json_encode('Task deleted.');
    });

    // Route for create task
    Route::post('/create_task/{new_task}', function(Request $request, $new_task)
    {
        Tasks::create([
            'user_id'        => $request->user_id,
            'name'           => $request->name,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'description'    => $request->description,
        ]);

        return json_encode('Task created.');
        }
    );
});


























