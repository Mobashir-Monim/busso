@extends('layouts.dashboard')

@section('content')
    @include('roles.parts.role-details')
    
    <div class="row">
        <div class="col-md-12 mb-2 mt-5">
            <div class="card card-rounded">
                <div class="card-body">
                    <h4 class="bordor-bottom">Users</h4>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">User Name</th>
                                <th scope="col">User Email</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="users" style="font-size: 0.8em">
                            @foreach ($users as $user)
                                <tr id="{{ $user->email }}">
                                    <td class="py-4">{{ $user->name }}</td>
                                    <td class="py-4">{{ $user->email }}</td>
                                    <td class="text-right">
                                        <button class="btn btn-dark" onclick="removeUser('{{ $user->email }}', true)" type="button"><i class="fas fa-user-times"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-dark w-50 {{ $users->hasMorePages() ? '' : 'hidden' }}" id="user-load-btn" onclick="loadMore()" type="button">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('roles.parts.users.attach')
    @include('roles.parts.users.detach')
@endsection

@section('scripts')
    @include('roles.scripts.users.index')
    @include('roles.scripts.users.detach')
@endsection