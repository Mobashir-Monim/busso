@if (auth()->user()->hasSystemRole('super-admin') || auth()->user()->hasSystemRole('admin') || auth()->user()->hasSystemRole('user-admin') || auth()->user()->hasSystemRole('resource-admin'))
    <div class="modal fade" id="role-delete" tabIndex="-1" role="dialog" aria-labelledby="role-delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card-rounded">
                <div class="modal-body">
                    <h3 class="border-bottom border-primary" id="role-delete">Confirm Deletion</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="POST" id="role-delete-form">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <p>
                                    You are about to delete the role named <b><span class="text-danger" id="delete-role-name"></span></b>
                                    with <b><span class="text-danger" id="delete-role-users"></span></b> users attached and
                                    <b><span class="text-danger" id="delete-role-groups"></span></b> resource groups attached.
                                </p>

                                <p>Please confirm this action by typing in the role's name</p>
                                
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" name="email_confirm" class="form-control mb-2" placeholder="" id="delete-confirm" onkeyup="confirmDelete()">
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-danger w-100" id="delete-button" disabled><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('roles.scripts.delete')
@endif