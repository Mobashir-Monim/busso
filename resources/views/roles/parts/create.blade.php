<div class="modal fade" id="role-create" tabIndex="-1" role="dialog" aria-labelledby="role-create-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content card-rounded">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <h4 class="border-bottom">Add New Role</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <input type="text" name="display_name" class="form-control" id="display_name" placeholder="Role Name" onkeyup="setRoleSystemName()" required>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>Role Name</b></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <input type="text" name="name" class="form-control" id="system_name" readonly>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>System Name</b></label>
                    </div>
                    @if (auth()->user()->hasSystemRole('super-admin'))
                        <div class="col-md-4 offset-md-2 my-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" id="is_system_role" value="1" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                                <input type="text" class="form-control disabled" value="Is system role" disabled>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-8 my-2">
                        <textarea name="description" id="description" class="form-control" cols="30" rows="3" placeholder="Role Description" required></textarea>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>Role Description</b></label>
                    </div>
                    <div class="col-md-4 mt-auto text-right mb-4">
                        <button class="btn btn-dark align-middle" onclick="createRole()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('roles.scripts.create')