<form id="rg-create-form" action="{{ route('resource-groups') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="rg-create" tabIndex="-1" role="dialog" aria-labelledby="rg-create-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="rg-create-title">Create New Resource Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" id="type" value="saml">
                    <div class="row form-group">
                        <div class="col-md-6 my-2">
                            <input type="text" name="name" class="form-control" placeholder="Resource Group Name" id="rg-name" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <input type="url" name="url" class="form-control" placeholder="Resource Group URL" id="rg-url" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <textarea class="form-control" name="description" id="rg-description" placeholder="Resource Group Description"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="file" name="image" id="rg-image" class="form-control">
                            <label for="cert" class="sso-inp-label mr-2">Resource Group Image</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link badge-dark rounded-0 active" onclick="setOnboarding('saml')" id="saml-tab" data-toggle="pill" href="#saml" role="tab" aria-controls="saml" aria-selected="true">SAML</a>
                                <a class="nav-link badge-dark rounded-0" onclick="setOnboarding('oauth')" id="oauth-tab" data-toggle="pill" href="#oauth" role="tab" aria-controls="oauth" aria-selected="false">Oauth</a>
                                <a class="nav-link badge-dark rounded-0" onclick="setOnboarding('both')" id="both-tab" data-toggle="pill" href="#oauth" role="tab" aria-controls="oauth" aria-selected="false">Both</a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="p-2 tab-pane fade show active" id="saml" role="tabpanel" aria-labelledby="saml-tab">
                                    No additional values needed at this point. Please configure SAML after creation.
                                </div>
                                <div class="p-2 tab-pane fade" id="oauth" role="tabpanel" aria-labelledby="oauth-tab">
                                    <input type="url" name="endpoint" id="endpoint" class="form-control" placeholder="Oauth Callback">
                                </div>
                                {{-- <div class="p-2 tab-pane fade" id="both" role="tabpanel" aria-labelledby="both-tab">Both</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="submit" class="btn btn-primary tick-btn"></button>
                </div>
            </div>
        </div>
    </div>
</form>