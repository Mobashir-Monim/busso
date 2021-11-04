@extends('layouts.dashboard')

@section('content')
    @foreach ($debug_items as $item)
        <div class="card card-rounded" onclick="window.open('{{ route('debugger.settings', ['item' => $item->id]) }}', '_self')">
            <div class="card-body">
                <h5 class="border-bottom border-primary mb-0">{{ $item->name }}</h5>
                <i class="d-block text-right">{{ $item->identifier }}</i>
            </div>
        </div>
    @endforeach

    <button class="btn add-btn btn-dark" onclick="window.open('{{ route('debugger.create') }}', '_self')">
        <span class="material-icons-outlined" style="font-size: 2.2em">add</span>
    </button>
@endsection