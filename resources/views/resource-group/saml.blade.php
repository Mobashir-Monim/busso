@if (!is_null($group->saml))
    <form action="{{ route('resource-groups.saml.config', ['group' => $group->id, 'saml' => $group->saml->id]) }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-12 my-2">
                <div class="card card-rounded">
                    <div class="card-body">
                        <h4 class="border-bottom border-3 border-primary">Oauth Details</h4>
                        <div class="row">
                            <div class="col-md-8 my-2">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="text" name="issuer" class="form-control" placeholder="Issuer Entity ID" value="{{ $group->saml->issuer }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="url" name="acs" class="form-control" placeholder="Issuer ACS" value="{{ $group->saml->acs }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="file" name="cert" class="form-control" placeholder="Issuer Certificate">
                                        <label for="cert" class="sso-inp-label mr-2">Issuer Certificate</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="url" name="meta_url" class="form-control" placeholder="Issuer Metadata URL" value="{{ $group->saml->doc }}">
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>NOTE: It is better to configure the URL</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-auto mb-4 text-right">
                                <button class="btn btn-dark">Save Config</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif