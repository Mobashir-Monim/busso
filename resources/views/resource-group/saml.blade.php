@if (!is_null($group->saml))
    <form action="{{ route('resource-groups.saml.config', ['group' => $group->id, 'saml' => $group->saml->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-4">
            <div class="col-md-12 my-2">
                <div class="card card-rounded">
                    <div class="card-body">
                        <h4 class="border-bottom border-3 border-primary">SAML Details</h4>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-10 col-9 mb-2">
                                        <input type="text" class="form-control disabled" readonly id="idp-id" value="{{ route('sso.saml.login', ['entity' => $group->saml->id]) }}">
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>IdP Issuer ID</b></label>
                                    </div>
                                    <div class="col-md-2 col-3 mb-2 text-right">
                                        <button type="button" class="btn btn-dark" onclick="copyData('idp-id')"><i class="far fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-10 col-9 mb-2">
                                        <input type="text" class="form-control disabled" readonly id="login-url" value="{{ route('sso.saml.login', ['entity' => $group->saml->id]) }}">
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>IdP Login URL</b></label>
                                    </div>
                                    <div class="col-md-2 col-3 mb-2 text-right">
                                        <button type="button" class="btn btn-dark" onclick="copyData('login-url')"><i class="far fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-10 col-9 mb-2">
                                        <input type="text" class="form-control disabled" readonly id="logout-url" value="{{ route('sso.saml.logout', ['entity' => $group->saml->id]) }}">
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>IdP Logout URL</b></label>
                                    </div>
                                    <div class="col-md-2 col-3 mb-2 text-right">
                                        <button type="button" class="btn btn-dark" onclick="copyData('logout-url')"><i class="far fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-2">
                                        <a target="_blank" href="{{ route('sso.saml.metadoc', ['entity' => $group->saml->id, 'type' => 'certificate']) }}" class="btn btn-dark w-100"><i class="fas fa-cloud-download-alt"></i></a>
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>X509 Certificate Download</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-10 col-9 mb-2">
                                        <input type="text" class="form-control disabled" readonly id="metadata-doc" value="{{ route('sso.saml.metadoc', ['entity' => $group->saml->id, 'type' => 'url']) }}">
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>IdP Metadata URL</b></label>
                                    </div>
                                    <div class="col-md-2 col-3 mb-2 text-right">
                                        <button type="button" class="btn btn-dark" onclick="copyData('metadata-doc')"><i class="far fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-2">
                                        <a target="_blank" href="{{ route('sso.saml.metadoc', ['entity' => $group->saml->id, 'type' => 'download']) }}" class="btn btn-dark w-100"><i class="fas fa-cloud-download-alt"></i></a>
                                        <label for="" class="sso-inp-label mr-2 text-primary"><b>IdP Metadata Download</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h4 class="border-bottom border-3 border-primary">Configuration</h4>
                            </div>
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
                                        <label for="cert" class="sso-inp-label text-primary mr-2">Issuer Certificate</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="text" name="aud" class="form-control" placeholder="Audience Restriction" value={{ $group->saml->aud }}>
                                        <label for="cert" class="sso-inp-label text-primary mr-2">Audience Restriction</label>
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