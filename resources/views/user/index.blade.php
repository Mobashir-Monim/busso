@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="border-bottom border-2 border-primary">Users</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h3 class="border-bottom border-2 border-primary">User Stats</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">Total users:</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>Total users:</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['users'] }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">Super Admins:</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>Super Admins:</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['super-admins'] }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">User Admins:</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>User Admins:</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['user-admins'] }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">Resource Admins:</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>Resource Admins:</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['resource-admins'] }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">Active users:</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>Active users:</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['active-users'] }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">Activity (30 days):</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>Activity (30 days):</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['activity-month'] }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">Activity (7 days):</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>Activity (7 days):</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['activity-week'] }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2 d-md-none"><b class="border-bottom d-block">Activity (today):</b></div>
                                        <div class="col-md-6 mb-2 d-none d-md-block"><b>Activity (today):</b></div>
                                        <div class="col-md-6 mb-2">{{ $stats['activity-today'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection