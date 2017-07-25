@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">All Users</div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                            </thead>
                        <tbody>
                            @foreach ($all_users as $user)
                                <tr id="user-div-{{$user->id}}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-xs">Edit</button>
                                        <button class="btn btn-danger btn-xs" onClick="deleteUser({{$user->id}},'{{$user->email}}');">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    var _token = "{{ csrf_token() }}";

    $(document).ready(function() {


    });

    function deleteUser(id, email) {
        if (confirm("Are you sure you want to delete this user?")) {
            $('#user-div-'+id).remove();
            $.post("{{action('UserController@delete')}}", {id:id, email:email, _token:_token}, function(data, status) {
                //deleted
            });
        }
    }

</script>
@endsection
