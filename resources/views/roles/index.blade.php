@extends('layouts.dashboard')

@section('content')
    <div class="row my-3">
        <div class="col-md-12" id="roles-cont">
            @if (count($roles) != 0)
                @foreach ($roles as $role)
                    <div class="card my-3 card-rounded" id="{{ $role->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="border-bottom mb-0" id="display-{{ $role->id }}">{{ $role->display_name }}</h4>
                                    <i class="d-block text-right"><span id="name-{{ $role->id }}">{{ $role->name }}</span> ({{ count($role->users) }})</i>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md">
                                    <p class="border role-description border-primary p-4 mb-0" id="description-{{ $role->id }}">
                                        {{ $role->description }}
                                    </p>
                                </div>
                                <div class="col-md-3 mt-auto text-right">
                                    <a class="btn btn-dark align-middle" href="{{ route('roles.attachment.user', ['role' => $role['id']]) }}">
                                        <i class="fas fa-user"></i>
                                    </a>
                                    <a class="btn btn-dark align-middle" href="{{ route('roles.attachment.group', ['role' => $role['id']]) }}">
                                        <i class="fa fas fa-layer-group"></i>
                                    </a>
                                    <button class="btn btn-dark" onclick="showRole('{{ $role->id }}')">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card card-rounded">
                    <div class="card-body">
                        <h3 class="text-center my-4 text-secondary"><i>No Roles to display</i></h3>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{ $roles->links() }}
    
    <button class="btn add-btn btn-dark" data-toggle="modal" data-target="#role-create">
        <span class="material-icons-outlined" style="font-size: 2.2em">add</span>
    </button>
    <button class="hidden" data-toggle="modal" data-target="#role-show" id="role-show-btn"></button>
    @include('roles.parts.create')
    @include('roles.parts.show')
@endsection