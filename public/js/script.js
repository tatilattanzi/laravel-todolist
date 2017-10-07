$(document).ready(function() {

    var url = "/task";


    //display modal form for task editing
    $(document).on('click', '#btn-edit', function() {
        var task_id = $(this).val();

        $.get(url + '/' + task_id, function(data) {
            //success data
            console.log(data);
            $('#task_id').val(data.id);
            $('#name').val(data.name);
            $('#description').val(data.description);
            $('#done').prop('checked', data.done == 1 ? true : false);
            $('#btn-save').val('update');
            console.log($('#btn-save').val());;
            $('#modalEdit').modal('show');
        })
    });

    //display modal form for creating new task
    $(document).on('click', '#btn-add', function() {
        $('#btn-save').val('add');
        $('#frmTasks').trigger('reset');
        $('#name').val($('#task-name').val());
        $('#task-name').val('');
        $('#modalEdit').modal('show');
    });

    //create new task / update existing task
    $(document).on('click', '#btn-save', function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        e.preventDefault();

        var formData = {
            name: $('#name').val(),
            description: $('#description').val(),
            done: (($('#done')[0].checked == true) ? 1 : 0)
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var my_url = url;

        if (state == "update") {
            type = "PUT"; //for updating existing resource
            var task_id = $('#task_id').val();
            my_url += '/' + task_id;
        }

        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {
                console.log(data);

                var task_name = '<div id="task-name' + data.id + '">' + data.name + '</div>';
                var task_desc = '<div id="task-desc' + data.id + '">' + data.description + '</div>';
                var task_done = '<div id="task-done' + data.id + '"><input id="task-done' + data.id + '" type="checkbox" disabled="true" ' + (data.done == 1 ? 'checked="checked"' : '') + '></div>';

                if (state == "add") {
                    var new_task = '<tr id="task' + data.id + '">';
                    new_task += '<td class="table-text">' + task_name + '</td>';
                    new_task += '<td class="table-text">' + task_desc + '</td>';
                    new_task += '<td class="table-text">' + task_done + '</td>';
                    new_task += '<td><button id="btn-edit" class="btn btn-success" value="' + data.id + '"><i class="fa fa-btn fa-edit"></i>Edit</button></td>';
                    new_task += '<td><button id="btn-confirm-delete" class="btn btn-danger" value="' + data.id + '"><i class="fa fa-btn fa-trash"></i>Delete</button></td>';
                    new_task += '</tr>';

                    $('#tasks-list').append(new_task);

                } else {
                    $('#task-name' + task_id).replaceWith(task_name);
                    $('#task-desc' + task_id).replaceWith(task_desc);
                    $('#task-done' + task_id).replaceWith(task_done);
                }

                $('#frmTasks').trigger('reset');
                $('#errors').replaceWith('<div id="errors" class="alert alert-danger" hidden="true"></div>');
                $('#modalEdit').modal('hide');
            },
            error: function(data) {
                var errors = data.responseJSON;

                var errorsHtml = '<div id="errors" class="alert alert-danger"><ul>';

                for (var index in errors) {
                    console.log(errors[index]);
                    errorsHtml += '<li>' + errors[index] + '</li>';
                }

                errorsHtml += '</ul></div>';
                $('#errors').replaceWith(errorsHtml);
            }
        });
    });

    // confirm delete
    $(document).on('click', '#btn-confirm-delete', function() {
        $('#task_id').val($(this).val());
        $('#modalDelete').modal('show');
    });

    //delete task and remove it from list
    $(document).on('click', '#btn-delete', function() {
        var task_id = $('#task_id').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            url: url + '/' + task_id,

            success: function(data) {
                $('#task' + task_id).remove();
                $('#modalDelete').modal('hide');
            },
            error: function(data) {
                console.log('Error:', data);
            }

        });
    });

    // reset modal
    $('#modalEdit').on('hidden.bs.modal', function(e) {
        $('#task_id').val('');
        $('#name').val('');
        $('#description').val('');
        $('#done').prop('checked', false);
        $('#errors').replaceWith('<div id="errors" class="alert alert-danger" hidden="true"></div>');
    });

});