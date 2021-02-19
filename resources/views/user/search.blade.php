@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('users.search') }}" method="POST">
        @csrf
        <div class="row my-3">
            <div class="col-md-12">
                <div class="card card-rounded">
                    <div class="card-body">
                        <h3 class="border-bottom border-2 border-primary">Search User(s)</h3>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="text" name="phrase" class="form-control" placeholder="Search Phrase" value="{{ $phrase }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <select name="type" class="form-control" required>
                                    <option value="{{ App\Helpers\UserHelpers\SearchHelpers\SearchHelper::getType($type)[0] }}">{{ App\Helpers\UserHelpers\SearchHelpers\SearchHelper::getType($type)[1] }}</option>
                                    @foreach (App\Helpers\UserHelpers\SearchHelpers\SearchHelper::getTypes() as $searchType)
                                        @if ($searchType[0] != $type)
                                            <option value="{{ $searchType[0] }}">{{ $searchType[1] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-2 text-right">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <h5 class="border-bottom mb-0 mt-3">Search Results</h5>
            <div class="row">
                @if (count($users) == 0)
                    <div class="col-md-12">
                        <div class="card card-rounded mt-4">
                            <div class="card-body">
                                <h4 class="text-center text-primary mb-0">No Users meet this criteria</h4>
                            </div>
                        </div>
                    </div>
                @endif
                @foreach ($users as $user)
                    <div class="col-md-6 my-3">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <p class="mb-0 border-bottom border-primary"><b>{{ $user->name }}</b></p>
                                <p>{{ $user->email }}</p>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="border-bottom border-primary">
                                            <div class="row">
                                                <div class="col-sm-6 mt-1">
                                                    <p class="mb-0"><b>Account Status</b></p>
                                                </div>
                                                <div class="col-sm-6 mt-1">
                                                    <p class="mb-0">{{ $user->is_active ? 'Active' : 'Inactive' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-bottom border-primary">
                                            <div class="row">
                                                <div class="col-sm-6 mt-1">
                                                    <p class="mb-0"><b>Created on</b></p>
                                                </div>
                                                <div class="col-sm-6 mt-1">
                                                    <p class="mb-0">{{ Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-bottom border-primary">
                                            <div class="row">
                                                <div class="col-sm-6 mt-1">
                                                    <p class="mb-0"><b>Last password changed on</b></p>
                                                </div>
                                                <div class="col-sm-6 mt-1">
                                                    <p class="mb-0">{{ !is_null($user->pass_change_at) ? Carbon\Carbon::parse($user->pass_change_at)->format('d M, Y') : 'Not changed' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mt-auto text-right">
                                        <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-dark"><i class="fas fa-eye"></i></a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{ $users->links() }}
@endsection