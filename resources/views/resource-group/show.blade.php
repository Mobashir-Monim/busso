@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="border-bottom border-3 border-primary">Resource Group</h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-8 my-2">
            <div class="card card-rounded">
                <div class="card-body">
                    <h4 class="border-bottom border-3 border-primary">{{ $group->name }}</h4>
                    <div class="row">
                        <div class="col-md-12 mb-2">{{ $group->description }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2 d-md-none"><b class="border-bottom d-block">Configured URL:</b></div>
                        <div class="col-md-4 mb-2 d-none d-md-block"><b>Configured URL:</b></div>
                        <div class="col-md-8 mb-2">
                            {{ $group->url }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2 d-md-none my-auto"><b class="border-bottom d-block">Configured for:</b></div>
                        <div class="col-md-4 mb-2 d-none d-md-block my-auto"><b>Configured for:</b></div>
                        <div class="col-md-8 mb-2">
                            <ul class="list-group list-group-horizontal">
                                @if (!is_null($group->saml))
                                    <li class="list-group-item">SAML</li>
                                @endif

                                @if (!is_null($group->oauth))
                                    <li class="list-group-item">Oauth/OIDC</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md"></div>
        <div class="col-md-2 my-2">
            <div class="card card-rounded">
                <div class="card-body rg-image card-rounded"
                    style="background-image: url('{{ is_null($group->image) ? "/img/rg-placeholder.png" : Storage::url("$group->image") }}');">
                </div>
            </div>
        </div>
    </div>

    @include('resource-group.oauth')
    @include('resource-group.saml')
@endsection

@section('scripts')
    
@endsection