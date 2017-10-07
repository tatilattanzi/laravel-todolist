@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <div class="form-horizontal">

                        <!-- Task Name -->
                        <div class="form-group required">
                            
                            <label for="task-name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="" placeholder="Must have at least 5 characters" >
                            </div>

                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                            <button id="btn-add" class="btn btn-primary">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Tasks -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Current Tasks
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <tr>
                            <th>Task</th>
                            <th>Description</th>
                            <th>Done</th>
                            <th>Actions</th>
                            <th/>
                        </tr>
                        <tbody id="tasks-list" name="tasks-list">
                            @foreach ($tasks as $task)
                                <tr id="task{{$task->id}}">
                                    <td class="table-text">
                                        <div id="task-name{{$task->id}}">{{ $task->name }}</div>
                                    </td>
                                    <td class="table-text">
                                        <div id="task-desc{{$task->id}}">{{ $task->description }}</div>
                                    </td>

                                    <td class="table-text">
                                        <div id="task-done{{$task->id}}">
                                            <input type="checkbox" disabled="true" @if($task->done == 1) ? checked='checked' @endif >
                                        </div>
                                    </td>

                                    <!-- Task Edit Button -->
                                    <td>
                                        <button id="btn-edit" class="btn btn-success" 
                                            value="{{$task->id}}">
                                            <i class="fa fa-btn fa-edit"></i>Edit
                                        </button>
                                    </td>

                                    <!-- Task Delete Button -->
                                    <td>
                                        <button id="btn-confirm-delete" class="btn btn-danger"
                                            value="{{$task->id}}">
                                            <i class="fa fa-btn fa-trash"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
             </div>
        </div>

         <!-- Modal (add / edit tasks) -->
         <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="modalEditLabel">Task Editor</h4>
                        </div>                        
                        <div class="modal-body">

                        <div id="errors"></div>
                        
                        <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">

                            <div class="form-group required error">
                                <label for="inputTask" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control has-error" id="name" name="name" placeholder="Must have at least 5 characters" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="description" name="description" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDone" class="col-sm-3 control-label">Done</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="form-control" id="done" name="done">
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-save" class="btn btn-info" value="">
                            <i class="fa fa-btn fa-check"></i>Save
                        </button>
                        <input type="hidden" id="task_id" name="task_id" value="0">
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal (confirm delete) -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4>Confirm delete</h4>
                    </div>                        
                    <div class="modal-body">
                        <p>Do you really want to delete the task?</p>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-delete" class="btn btn-warning" value="">
                             <i class="fa fa-btn fa-check"></i>Ok
                         </button>

                         <button id="btn-cancel" class="btn btn-primary" data-dismiss="modal">
                              <i class="fa fa-btn fa-close"></i>Cancel
                        </button>
                        <input type="hidden" id="task_id" name="task_id" value="0">
                    </div>
                </div>
            </div>
        </div>

    </div>

    
@endsection
