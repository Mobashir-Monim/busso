@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="border-bottom border-primary">Change Log</h2>
            @foreach ($logs as $log)
                <div class="card card-rounded my-3">
                    <div class="card-body">
                        <h4 class="border-bottom mb-0">{{ $log->type }}::{{ $log->mode }} ({{ $log->groupCount }})</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted mb-0 d-inline-block">
                                    {{ $log->group_id }}
                                </p>
                                <p class="text-primary mb-0 d-inline-block float-right">
                                    {{ $log->user->name }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('change-log.view', ['group' => $log->group_id]) }}" target="_blank" class="btn btn-dark float-right"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection