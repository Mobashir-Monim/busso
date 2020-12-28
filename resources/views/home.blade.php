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
                        <div class="col-md-4 mb-2 d-md-none"><b class="border-bottom d-block">Email Address:</b></div>
                        <div class="col-md-4 mb-2 d-none d-md-block"><b>Email Address:</b></div>
                        <div class="col-md-8 mb-2">{{ $user->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2 d-md-none"><b class="border-bottom d-block">System Role:</b></div>
                        <div class="col-md-4 mb-2 d-none d-md-block"><b>System Role:</b></div>
                        <div class="col-md-8 mb-2">{{ $user->roles->where('is_system_role', true)->first()->display_name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2 d-md-none"><b class="border-bottom d-block">Additional Roles/Groups:</b></div>
                        <div class="col-md-4 mb-2 d-none d-md-block"><b>Additional Roles/Groups:</b></div>
                        <div class="col-md-8 mb-2">
                            @if (getAdditionalRoles()['count'] > 0)
                                {{ printAdditonalRoles() }}
                            @else
                                No Additional Roles/Groups found
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md"></div>
        <div class="col-md-2 my-2">
            <div class="card card-rounded">
                <div class="card-body p-0">
                    <img src="/img/user-image.jpg" class="img-fluid card-rounded" alt="{{ $user->name }} Image">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-rounded">
                <div class="card-body">
                    <h3 class="border-bottom border-3 border-primary">Applications</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
