@if (!is_null($group->oauth))
    <div class="row mb-4">
        <div class="col-md-12 my-2">
            <div class="card card-rounded">
                <div class="card-body">
                    <h4 class="border-bottom border-3 border-primary">Oauth Details</h4>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-10 col-9 mb-2">
                                    <input type="text" class="form-control disabled" readonly id="client_id" value="{{ $group->oauth->id }}">
                                    <label for="" class="sso-inp-label mr-2 text-primary"><b>Client ID</b></label>
                                </div>
                                <div class="col-md-2 col-3 mb-2 text-right">
                                    <button type="button" class="btn btn-dark" onclick="copyData('client_id')"><i class="far fa-copy"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-10 col-9 mb-2">
                                    <input type="text" class="form-control disabled" readonly id="client_secret" value="{{ $group->oauth->secret }}">
                                    <label for="" class="sso-inp-label mr-2 text-primary"><b>Client Secret</b></label>
                                </div>
                                <div class="col-md-2 col-3 mb-2 text-right">
                                    <button type="button" class="btn btn-dark" onclick="copyData('client_secret')"><i class="far fa-copy"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12 col-12 mb-2">
                                    <form action="{{ route('resource-groups.oauth.reset', ['group' => $group->id, 'oauth' => $group->oauth->id]) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-dark w-100">Reset Secret</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('resource-groups.oauth.redirect-set', ['group' => $group->id, 'oauth' => $group->oauth->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h4 class="border-bottom border-3 border-primary">Configuration</h4>
                            </div>
                            <div class="col-md-8 my-2">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="url" name="redirect" class="form-control" placeholder="Issuer Metadata URL" value="{{ $group->oauth->redirect }}">
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>Redirect URL</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-auto mb-4 text-right">
                                <button class="btn btn-dark">Save Config</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif