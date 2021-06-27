<div class="row">
    <div class="col-md-12 my-2">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <h4 class="border-bottom" id="role-show-name">{{ $role['display_name'] }}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <p class="form-control mb-0">{{ $role['display_name'] }}</p>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>Role Name</b></label>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row" data-toggle="tooltip" data-placement="bottom" title="Users with role">
                                    <div class="col offset-3 my-2 text-right border-bottom" id="role-user-count">
                                        {{ $role['users'] }}
                                    </div>
                                    <div class="col-2 my-2">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row" data-toggle="tooltip" data-placement="bottom" title="Resouce Groups attached">
                                    <div class="col offset-3 my-2 text-right border-bottom" id="role-group-count">
                                        {{ $role['resource_groups'] }}
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
                        <input type="text" name="name" class="form-control" id="system_name_show" value="{{ $role['name'] }}" readonly>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>System Name</b></label>
                    </div>
                    @if (auth()->user()->hasSystemRole('super-admin'))
                        <div class="col-md-4 offset-md-2 my-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" disabled id="is_system_role_show" {{ $role['is_system_role'] ? 'checked' : '' }} value="1" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                                <input type="text" class="form-control disabled" value="Is system role" disabled>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-8 my-2">
                        <textarea name="description" id="description_show" class="form-control" cols="30" rows="1" disabled style="background-color: #fff" placeholder="Role Description" required>{{ $role['description'] }}</textarea>
                        <label for="" class="sso-inp-label mr-2 text-primary"><b>Role Description</b></label>
                    </div>
                    <div class="col-md-4 mt-auto text-right mb-4">
                        @if (request()->url() != route('roles.attachment.group', ['role' => $role['id']]))
                            <button class="btn btn-dark align-middle" data-toggle="modal" data-target="#user-attach"><i class="fas fa-user-plus"></i></button>
                            <button class="btn btn-dark align-middle" data-toggle="modal" data-target="#user-detach"><i class="fas fa-user-times"></i></button>
                            <a class="btn btn-dark align-middle" href="{{ route('roles.attachment.group', ['role' => $role['id']]) }}"><i class="fa fas fa-layer-group"></i></a>
                        @else
                            <a class="btn btn-dark align-middle" href="{{ route('roles.attachment.user', ['role' => $role['id']]) }}"><i class="fas fa-user"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>