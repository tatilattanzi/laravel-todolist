<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    });

    /**
     * Show a Task
     */
     Route::get('/task/{id}', function ($id) {
        $task = Task::findOrFail($id);

        return Response::json($task);
     });

    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:50',
            'description' => 'max:255',
        ]);

        if ($validator->fails()) {
            return Response::json($validator->errors(), 400);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->done = $request->done;
        $task->save();

        return Response::json($task);
    });

    /**
     * Update Task
     */
     Route::put('/task/{id}', function (Request $request, $id) {
        $task = Task::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:50',
            'description' => 'max:255',
        ]);

        if ($validator->fails()) {
            return Response::json($validator->errors(), 400);
        }
    
        $task->name = $request->name;
        $task->description = $request->description;
        $task->done = $request->done;

        $task->save();

        return Response::json($task);
     });

    /**
     * Delete Task
     */
    Route::delete('/task/{id}', function ($id) {
        $task = Task::destroy($id);
        
        return Response::json($task);
    });
});
