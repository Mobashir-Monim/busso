<div class="modal fade" id="role-show" tabIndex="-1" role="dialog" aria-labelledby="role-show-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content card-rounded">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <h4 class="border-bottom" id="role-show-name">Display Name</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <input type="text" name="display_name" class="form-control" id="display_name_show" placeholder="Role Name" onkeyup="setRoleSystemName('show')" required>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>Role Name</b></label>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row" data-toggle="tooltip" data-placement="bottom" title="Users with role">
                                    <div class="col offset-3 my-2 text-right border-bottom" id="role-user-count">
        
                                    </div>
                                    <div class="col-2 my-2">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row" data-toggle="tooltip" data-placement="bottom" title="Resouce Groups attached">
                                    <div class="col offset-3 my-2 text-right border-bottom" id="role-group-count">
        
                                    </div>
                                    <div class="col-2 my-2">
                                        <i class="fa fas fa-layer-group text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <input type="text" name="name" class="form-control" id="system_name_show" readonly>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>System Name</b></label>
                    </div>
                    @if (auth()->user()->hasSystemRole('super-admin'))
                        <div class="col-md-4 offset-md-2 my-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" id="is_system_role_show" value="1" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                                <input type="text" class="form-control disabled" value="Is system role" disabled>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-8 my-2">
                        <textarea name="description" id="description_show" class="form-control" cols="30" rows="3" placeholder="Role Description" required></textarea>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>Role Description</b></label>
                    </div>
                    <div class="col-md-4 mt-auto text-right mb-4">
                        <button class="btn btn-dark align-middle" onclick="showUsers()"><i class="fas fa-user"></i></button>
                        <button class="btn btn-dark align-middle" onclick="updateRole()"><i class="fa fas fa-layer-group"></i></button>
                        <button class="btn btn-dark align-middle" onclick="updateRole()"><i class="far fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('roles.scripts.show')
@include('roles.scripts.update')