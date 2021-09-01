@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="border-bottom">{{ $logs[0]->type }}::{{ $logs[0]->mode }} by {{ $logs[0]->user->name }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @foreach ($logs as $log)
                <div class="card my-3 card-rounded">
                    <div class="card-body">
                        @include("change-log.parts.$log->route_name")

                        <div class="accordion mt-2" id="accordion-{{ $log->id }}">
                            <div class="card p-0 border-0">
                              <div id="collapse-{{ $log->id }}" class="collapse" aria-labelledby="heading-{{ $log->id }}" data-parent="#accordion-{{ $log->id }}">
                                    <div class="card-body p-0">
                                        <div class="change-log-data p-3 overflow-auto">
                                            @foreach (explode(PHP_EOL, json_encode($log->change_data, JSON_PRETTY_PRINT)) as $l => $line)
                                                <div class="line pt-2">
                                                    <pre class="line-pre d-inline-block text-white my-1">{{ $l + 1 }}</pre>
                                                    <pre class="line-pre d-inline-block my-1">{{ $line }}</pre>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mt-2 text-right">
                                <button class="btn btn-dark btn-rounded" type="button" data-toggle="collapse" data-target="#collapse-{{ $log->id }}" aria-expanded="true" aria-controls="collapse-{{ $log->id }}"><span class="material-icons-outlined d-inline-block mt-1">visibility</span></button>
                                <button class="btn btn-dark btn-rounded" {{ $log->reverted ? 'disabled' : 'onclick=confirmRevert("' . $log->id . '")' }}><span class="material-icons-outlined d-inline-block mt-1">undo</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('change-log.parts.confirm')
@endsection

@section('scripts')
    @include('change-log.scripts.confirm')
    @include('change-log.scripts.' . $logs[0]->route_name)
@endsection