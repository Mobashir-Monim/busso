@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Route</th>
                        <th scope="col">Data</th>
                        <th scope="col">Response</th>
                        <th scope="col">Error</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\OidcResponseLogger as $item)
                        <tr>
                            <td>{{ $item->route }}</td>
                            <td>{{ $item->data }}</td>
                            <td>{{ $item->eesponse }}</td>
                            <td>{{ $item->error ? '1' : '0' }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection