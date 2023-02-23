@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td id="name-{{$user->id}}">{{ $user->name }}</td>
                                <td id="email-{{$user->id}}">{{ $user->email }}</td>
                                <td>
                                    <button class="btn btn-primary btn-edit edit-user" data-id="{{ $user->id }}">Editar</button>
                                    <button class="btn btn-danger btn-delete delete-user" data-id="{{ $user->id }}">Deletar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </tbody>
                    </table>

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.edit')
<script>
        $(document).on('click', '.edit-user', function() {
        
            var user_id = $(this).data('id');
            var name = $('#name-' + user_id).text();
            var email = $('#email-' + user_id).text();

            $('#edit-user-modal #user_id').val(user_id);
            $('#edit-user-modal #name').val(name);
            $('#edit-user-modal #email').val(email);
            $('#edit-user-modal').modal('show');
        });

        $('#update-user').on('click', function() {
            var user_id = $('#user_id').val();
            var name = $('#name').val();
            var email = $('#email').val();

            $.ajax({
                url: '/users/' + user_id,
                type: 'POST',
                data: {
                    name: name,
                    email: email
                },
                dataType: 'json',
                success: function(response) {
                    $('#edit-user-modal').modal('hide');
                    $('#name-' + user_id).text(name);
                    $('#email-' + user_id).text(email);
                    toastr.success(response.message);
                },
                error: function(response) {
                    toastr.error(response.responseJSON.message);
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-user', function() {
            var user_id = $(this).data('id');

            if (confirm("Tem certeza que dejesa deletar esse usuário?")) {
                $.ajax({
                    url: '/users/' + user_id,
                    type: 'DELETE',
                    data: {
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#row-' + user_id).remove();
                        toastr.success(response.message);
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            }
        });
    </script>
@endsection