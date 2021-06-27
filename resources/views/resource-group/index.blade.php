@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="border-bottom border-2 border-primary">Resource Groups</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 text-center">
            @foreach ($groups as $group)
                <a href="{{ route('resource-groups.show', ['group' => $group->id]) }}" class="text-left">
                    <div class="card hoverable-card m-3">
                        <div class="card-img-top rg-image" style="background-image: url('{{ is_null($group->image) ? "/img/rg-placeholder.png" : Storage::url("$group->image") }}');"></div>
                        <div class="card-body">
                            <h5>{{ $group->name }}</h5>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <button class="btn add-btn btn-dark" data-toggle="modal" data-target="#rg-create">
        <span class="material-icons-outlined" style="font-size: 2.2em">add</span>
    </button>
    
    {{ $groups->links() }}

    @include('resource-group.create')
@endsection

@section('scripts')
    <script>
        const typeInp = document.getElementById('type');
        const endpointInp = document.getElementById('endpoint');
        const oauthReq = ['oauth', 'both'];

        const setOnboarding = (type) => {
            typeInp.value = type;

            if (oauthReq.includes(type)) {
                endpointInp.required = true;
            } else {
                endpointInp.required = false;
            }
        }
    </script>
@endsection
