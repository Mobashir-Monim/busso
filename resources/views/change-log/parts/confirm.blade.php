<button class="hidden" type="button" data-toggle="modal" data-target="#change-revert" id="confirm-modal-button"></button>

<div class="modal fade" id="change-revert" tabIndex="-1" role="dialog" aria-labelledby="change-revert-prompt" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content card-rounded">
            <div class="modal-body">
                <h3 class="border-bottom border-primary" id="user-delete-prompt">Confirm Reversion</h3>
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="POST" id="change-revert-form">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div id="confirmation-message"></div>
                            
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="confirm_text" class="form-control mb-2" id="confirm_text" onkeyup="checkConfirmText()">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-danger w-100" id="revert-button" disabled><i class="fas fa-undo"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>