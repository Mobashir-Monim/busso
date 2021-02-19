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

    <form action="{{ route('users.search') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="row my-3">
                    <div class="col-md-12">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <h3 class="border-bottom border-2 border-primary">Search User(s)</h3>
                                <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <input type="text" name="phrase" class="form-control" placeholder="Search Phrase">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <select name="type" class="form-control" required>
                                            <option value="">Search Phrase Type</option>
                                            <option value="email @bracu.ac.bd">@bracu.ac.bd Email</option>
                                            <option value="email @g.bracu.ac.bd">@g.bracu.ac.bd Email</option>
                                            <option value="email non-bracu">Non BracU Email</option>
                                            <option value="email specific">Specific Email Address</option>
                                            <option value="all">All Users</option>
                                            <option value="role application">Application Role</option>
                                            <option value="role system">System Role</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-dark w-100">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <button class="btn add-btn btn-dark" data-toggle="modal" data-target="#user-create"></button>

    @include('user.create')
@endsection

@section('scripts')
    
@endsection