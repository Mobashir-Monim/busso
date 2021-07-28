@extends('layouts.dashboard')

@section('content')
    @if (request()->route()->getName() == 'home')
        <div class="row">
            <div class="col-md-12">
                <h3 class="border-bottom border-3 border-primary">Dashboard</h3>
            </div>
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-md-8 my-2">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                @csrf
                                <input type="text" name="name" class="form-control mb-3 h4-input" value="{{ $user->name }}">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-1 text-center"><b><span class="material-icons-outlined text-dark font-icon-24">alternate_email</span></b></div>
                        <div class="col-10 col-sm-11 my-auto">{{ $user->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-1 mb-1 text-center"><b><i class="fas fa-user-tag text-dark font-icon-24"></i></b></div>
                        <div class="col-10 col-sm-11 my-auto">{{ $user->roles->where('is_system_role', true)->first()->display_name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-1 mb-1 text-center"><b><i class="far fa-calendar-plus text-dark font-icon-24"></i></b></div>
                        <div class="col-10 col-sm-11 my-auto">{{ Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-1 mb-1 text-center"><b><span class="material-icons-outlined font-icon-24 text-dark">lock_clock</span></b></div>
                        <div class="col-10 col-sm-11 my-auto">{{ !is_null($user->pass_change_at) ? Carbon\Carbon::parse($user->pass_change_at)->format('d M, Y') : 'Not changed' }}</div>
                    </div>
                    
                    @if (auth()->user()->hasSystemRole('super-admin') || auth()->user()->hasSystemRole('admin') || auth()->user()->hasSystemRole('user-admin'))
                        <form action="{{ route('users.alter-status', ['user' => $user->id]) }}" method="POST" id="status-alter">
                            @csrf
                        </form>
                        @if ($user->is_active)
                            <button class="btn btn-primary user-status-button" type="button" onclick="document.getElementById('status-alter').submit()">
                                <span class="material-icons-outlined">lock_open</span>
                            </button>
                        @else
                            <button class="btn btn-secondary user-status-button" type="button" onclick="document.getElementById('status-alter').submit()">
                                <span class="material-icons-outlined">lock</span>
                            </button>
                        @endif
                    @endif

                    <button class="btn btn-dark user-access-button" type="button" data-toggle="modal" data-target="#access-list">
                        <span class="material-icons-outlined">accessibility_new</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md"></div>
        <div class="col-md-2 my-2">
            <div class="card card-rounded d-none d-md-block">
                <div class="card-body p-0">
                    <img src="/img/user-image.jpg" class="img-fluid card-rounded" alt="{{ $user->name }} Image">
                </div>
            </div>
            @if ($user->id == auth()->user()->id)
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('users.password.reset') }}" class="btn btn-dark mt-4"><i class="fas fa-redo-alt"></i> <i class="fas fa-key"></i></a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="access-list" tabIndex="-1" role="dialog" aria-labelledby="access-list-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card-rounded">
                <div class="modal-body">
                    <h3 class="border-bottom border-primary" id="access-list-title">Application Roles</h3>
                    <div class="row">
                        <div class="col-md-12">
                            @if (count($user->roles->where('is_system_role', false)) > 0)
                                <ul class="list-group">
                                    @foreach ($user->roles->where('is_system_role', false) as $role)
                                        <li class="list-group-item">{{ $role->display_name }} ({{ $role->name }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <h5 class="text-center">No application roles assigned</h5>
                                <h1 class="text-center mt-3">( 0 _ 0 )</h1>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.password.override')
@endsection
