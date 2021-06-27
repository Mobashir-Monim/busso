@extends('layouts.dashboard')

@section('content')
    @include('roles.parts.role-details')

    <div class="row my-5">
        @include('roles.parts.groups.search')
        @include('roles.parts.groups.attached')
    </div>
@endsection

@section('scripts')
    @include('roles.scripts.groups.index')
    @include('roles.scripts.groups.attach')
    @include('roles.scripts.groups.detach')
@endsection