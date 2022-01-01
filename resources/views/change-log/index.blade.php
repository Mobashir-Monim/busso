@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="border-bottom border-primary">Change Log</h2>
            <div class="row">
                @foreach ($logs as $log)
                    <div class="col-md-6">
                        <div class="card card-rounded card-hoverable my-3" onclick="window.open('{{ route('change-log.view', ['group' => $log->group_id]) }}', '_blank')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 my-2">
                                        <h4 class="border-bottom mb-0 d-flex justify-content-between">
                                            <span>{{ $log->type }}::{{ $log->mode }}</span>
                                            <span class="text-muted" style="font-size: 0.7em">
                                                [ <span class="text-primary">{{ $log->groupCount }}</span> ]
                                            </span>
                                        </h4>
                                        <p class="text-muted mb-0 text-right">
                                            {{ $log->group_id }}
                                        </p>
                                        @if ($log->user_type == 'user')
                                            <p class="text-primary mb-0 d-flex justify-content-end bg-light" onclick="window.open('{{ route('users.show', ['user' => $log->user_id]) }}')">
                                                <span class="material-icons-outlined mr-2" style="font-size: 19px">account_circle</span>
                                                {{ $log->user->name }}
                                            </p>
                                        @else
                                            <p class="text-primary mb-0 d-flex justify-content-end bg-light" onclick="window.open('{{ route('resource-groups.show', ['group' => $log->user->group->id]) }}')">
                                                <span class="material-icons-outlined mr-2" style="font-size: 19px">account_circle</span>
                                                {{ $log->user->name }} (API Client)
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection