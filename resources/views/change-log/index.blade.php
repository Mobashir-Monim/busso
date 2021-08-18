@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="border-bottom border-primary">Change Log</h2>
            @foreach ($logs as $log)
                <div class="card card-rounded card-hoverable my-3" onclick="window.open('{{ route('change-log.view', ['group' => $log->group_id]) }}', '_blank')">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 border-right">
                                <h4 class="border-bottom mb-0">
                                    {{ $log->type }}::{{ $log->mode }} ({{ $log->groupCount }})
                                </h4>
                                <p class="text-muted mb-0 d-inline-block">
                                    {{ $log->group_id }}
                                </p>
                            </div>
                            <div class="col-md-2 my-auto text-center">
                                <p class="text-primary mb-0">{{ $log->user->name }}</p>
                                {{-- <a href="{{ route('change-log.view', ['group' => $log->group_id]) }}" target="_blank" class="btn btn-sm btn-dark"><i class="fas fa-eye"></i></a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection