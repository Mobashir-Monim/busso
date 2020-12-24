@extends('layouts.dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-rounded">
                <div class="card-body">
                    <h3 class="border-bottom border-3 border-primary">{{ auth()->user()->name }}</h3>
                    <div class="row">
                        <div class="col-md-4 mb-2 d-md-none"><b class="border-bottom d-block">Email Address:</b></div>
                        <div class="col-md-4 mb-2 d-none d-md-block"><b>Email Address:</b></div>
                        <div class="col-md-8 mb-2">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2 d-md-none"><b class="border-bottom d-block">System Role:</b></div>
                        <div class="col-md-4 mb-2 d-none d-md-block"><b>System Role:</b></div>
                        <div class="col-md-8 mb-2">{{ auth()->user()->roles->where('is_system_role', true)->first()->display_name }}</div>
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
