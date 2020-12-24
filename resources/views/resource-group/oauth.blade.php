@if (!is_null($group->oauth))
    <div class="row mb-4">
        <div class="col-md-12 my-2">
            <div class="card card-rounded">
                <div class="card-body">
                    <h4 class="border-bottom border-3 border-primary">Oauth Details</h4>
                    <div class="row">
                        <div class="col-md-8 my-2">
                            <div class="row">
                                <div class="col-md-4 mb-2 d-md-none my-auto"><b class="border-bottom d-block">Client ID:</b></div>
                                <div class="col-md-4 mb-2 d-none d-md-block my-auto"><b>Client ID:</b></div>
                                <div class="col-md-8 mb-2">
                                    <ul class="list-group list-group-horizontal">
                                        <li class="list-group-item">{{ $group->oauth->id }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2 d-md-none my-auto"><b class="border-bottom d-block">Client Secret:</b></div>
                                <div class="col-md-4 mb-2 d-none d-md-block my-auto"><b>Client Secret:</b></div>
                                <div class="col-md-8 mb-2">
                                    <ul class="list-group list-group-horizontal">
                                        <li class="list-group-item">{{ $group->oauth->secret }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-auto mb-3 text-right">
                            <form action="{{ route('resource-groups.oauth.reset', ['group' => $group->id, 'oauth' => $group->oauth->id]) }}" method="POST">
                                @csrf
                                <button class="btn btn-dark">Reset Secret</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif