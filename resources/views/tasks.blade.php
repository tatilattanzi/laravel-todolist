@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('task')}}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group required">
                            <label for="task-name" class="col-sm-3 control-label required">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}" placeholder="Must have at least 5 characters" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="task-description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <input type="text" name="description" id="task-description" class="form-control" value="{{ old('task') }}" >
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Done</th>
                                <th>Actions</th>
                                <th/>
                                <th/>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td class="table-text"><div>{{ $task->name }}</div></td>
                                        <td class="table-text"><div>{{ $task->description }}</div></td>

                                        @if ($task->done == 1)
                                            <td class="table-text"><div>Done</div></td>
                                        @else
                                        <td class="table-text"><div>Pending</div></td>
                                        @endif

                                        <!-- Task Done Button -->
                                        <td>
                                            <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                
                                                @if ($task->done == 1)
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fa fa-btn fa-refresh"></i>Pending
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-btn fa-check"></i>Done
                                                    </button>                                                  
                                                @endif
                                            </form>
                                        </td>

                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
