@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="border-bottom border-3 border-primary">Dashboard</h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-8 my-2">
            <div class="card card-rounded">
                <div class="card-body">
                    <h4 class="border-bottom border-3 border-primary">{{ $user->name }}</h4>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-1 d-md-none"><b class="border-bottom d-block border-primary">Email Address:</b></div>
                        <div class="col-md-4 col-sm-12 mb-1 d-none d-md-block"><b>Email Address:</b></div>
                        <div class="col-md-8 mb-1">{{ $user->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-1 d-md-none"><b class="border-bottom d-block border-primary">System Role:</b></div>
                        <div class="col-md-4 mb-1 d-none d-md-block"><b>System Role:</b></div>
                        <div class="col-md-8 mb-1">{{ $user->roles->where('is_system_role', true)->first()->display_name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-1 d-md-none"><b class="border-bottom d-block border-primary">Additional Roles/Groups:</b></div>
                        <div class="col-md-4 mb-1 d-none d-md-block"><b>Additional Roles/Groups:</b></div>
                        <div class="col-md-8 mb-1">
                            @if (getAdditionalRoles()['count'] > 0)
                                {{ printAdditonalRoles() }}
                            @else
                                No Additional Roles/Groups found
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-1 d-md-none"><b class="border-bottom d-block border-primary">Account Status:</b></div>
                        <div class="col-md-4 mb-1 d-none d-md-block"><b>Account Status:</b></div>
                        <div class="col-md-8 mb-1">{{ $user->is_active ? 'Active' : 'Inactive' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-1 d-md-none"><b class="border-bottom d-block border-primary">Created on:</b></div>
                        <div class="col-md-4 mb-1 d-none d-md-block"><b>Created on:</b></div>
                        <div class="col-md-8 mb-1">{{ Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-1 d-md-none"><b class="border-bottom d-block border-primary">Last password changed on:</b></div>
                        <div class="col-md-4 mb-1 d-none d-md-block"><b>Last password changed on:</b></div>
                        <div class="col-md-8 mb-1">{{ !is_null($user->pass_change_at) ? Carbon\Carbon::parse($user->pass_change_at)->format('d M, Y') : 'Not changed' }}</div>
                    </div>
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
            <a href="{{ route('users.password.reset') }}" class="btn btn-dark w-100 mt-4">Reset Password</a>
        </div>
    </div>


    @include('user.password.override')
@endsection
