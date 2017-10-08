<?php

namespace App\Http\Controllers;

use Validator;
use Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'asc')->get();
        return View::make('tasks')->with('tasks', $tasks);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return Response::json($task, 200);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(TaskRequest $request)
    {
        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->done = $request->done;
        $task->save();

        return Response::json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->done = $request->done;

        $task->save();
        return Response::json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $task = Task::destroy($id);

        return Response::json($task, 200);
    }
}
