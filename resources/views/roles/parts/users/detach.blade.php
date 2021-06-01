<div class="modal fade" id="user-detach" tabIndex="-1" role="dialog" aria-labelledby="user-detach-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content card-rounded">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <h4 class="border-bottom" id="user-detach-name">Detach User</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="nav flex-column nav-pills" id="detach-v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link badge-dark rounded-0 active" id="single-detach" data-toggle="pill" href="#detach-single" role="tab" aria-controls="detach-single" aria-selected="true">Single User</a>
                            <a class="nav-link badge-dark rounded-0" id="batch-detach" data-toggle="pill" href="#detach-batch" role="tab" aria-controls="detach-batch" aria-selected="false">Batch Detach</a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-content" id="detach-v-pills-tabContent">
                            <div class="p-2 tab-pane fade show active" id="detach-single" role="tabpanel" aria-labelledby="single-detach">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom border-2 border-primary">Detach Single User</h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6 mb-2">
                                        <input type="email" name="email" class="form-control" placeholder="User Email" id="detach-user-email" required>
                                    </div>
                                    <div class="col-md-6 mb-2 text-right" id="detach-single-btn-cont">
                                        <button class="btn btn-dark" type="button" onclick="singleDetachUser()">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 tab-pane fade" id="detach-batch" role="tabpanel" aria-labelledby="batch-detach">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom border-2 border-primary">Batch Detach Users</h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6 mb-2">
                                        <input type="file" name="detach-batch-file" id="detach-batch-file" class="form-control" accept=".xls, .xlsx, .csv">
                                    </div>
                                    <div class="col-md-6 mb-2 text-right" id="detach-batch-button-cont">
                                        <button class="btn btn-dark" type="button" onclick="batchDetachUsers()"><i class="fas fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="detachment-messages">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>