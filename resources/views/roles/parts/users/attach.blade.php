<div class="modal fade" id="user-attach" tabIndex="-1" role="dialog" aria-labelledby="user-attach-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content card-rounded">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <h4 class="border-bottom" id="user-attach-name">Attach User</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="nav flex-column nav-pills" id="attach-v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link badge-dark rounded-0 active" id="single-attach" data-toggle="pill" href="#attach-single" role="tab" aria-controls="attach-single" aria-selected="true">Single User</a>
                            <a class="nav-link badge-dark rounded-0" id="batch-attach" data-toggle="pill" href="#attach-batch" role="tab" aria-controls="attach-batch" aria-selected="false">Batch Attach</a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-content" id="attach-v-pills-tabContent">
                            <div class="p-2 tab-pane fade show active" id="attach-single" role="tabpanel" aria-labelledby="single-attach">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom border-2 border-primary">Attach Single User</h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6 mb-2">
                                        <input type="email" name="email" class="form-control" placeholder="User Email" id="attach-user-email" required>
                                    </div>
                                    <div class="col-md-6 mb-2 text-right" id="attach-single-btn-cont">
                                        <button class="btn btn-dark" type="button" onclick="singleAttachUser()">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 tab-pane fade" id="attach-batch" role="tabpanel" aria-labelledby="batch-attach">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom border-2 border-primary">Batch Attach Users</h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6 mb-2">
                                        <input type="file" name="attach-batch-file" id="attach-batch-file" class="form-control" accept=".xls, .xlsx, .csv">
                                    </div>
                                    <div class="col-md-6 mb-2 text-right" id="attach-batch-button-cont">
                                        <button class="btn btn-dark" type="button" onclick="batchAttachUsers()"><i class="fas fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="attachment-messages">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('roles.scripts.users.attach')