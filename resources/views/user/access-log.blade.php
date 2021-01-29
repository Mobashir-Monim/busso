@extends('layouts.dashboard')

@section('content')
    <div class="row mn-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Service Name</th>
                        <th scope="col">Access type</th>
                        <th scope="col">Access Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->group->name }}</td>
                            <td>{{ $log->type }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $logs->links() }}
@endsection

@section('scripts')
    
@endsection