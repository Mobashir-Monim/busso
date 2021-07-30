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
        @include('user.dashboard.info')
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

    @include('user.dashboard.roles')
    @include('user.password.override')
@endsection
