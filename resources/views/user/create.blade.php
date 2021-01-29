<div class="modal fade" id="user-create" tabIndex="-1" role="dialog" aria-labelledby="user-create-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="user-create-title">Add New User(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link badge-dark rounded-0 active" id="single-create" data-toggle="pill" href="#single" role="tab" aria-controls="single" aria-selected="true">Single User</a>
                            <a class="nav-link badge-dark rounded-0" id="batch-create" data-toggle="pill" href="#batch" role="tab" aria-controls="batch" aria-selected="false">Batch Add</a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="p-2 tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-create">
                                <form action="{{ route('users.create') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="border-bottom border-2 border-primary">Add Single User</h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="name" class="form-control" placeholder="User Name" id="user-name" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="email" name="email" class="form-control" placeholder="User Email" id="user-email" required>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6 mb-2">
                                            <select name="system_role" id="system_role" class="form-control" required>
                                                <option value="">Please select System Role</option>
                                                @foreach (App\Models\Role::where('is_system_role', true)->where('name', '!=', 'super-admin')->get() as $role)
                                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <button class="btn btn-dark w-100">Add User</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="p-2 tab-pane fade" id="batch" role="tabpanel" aria-labelledby="batch-create">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom border-2 border-primary">Batch Addition</h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12 hidden" id="batch-progress"">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="progress-bar">0%</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2" id="batch-inp">
                                        <input type="file" name="batch-file" id="batch-file" class="form-control" accept=".xls, .xlsx">
                                    </div>
                                    <div class="col-md-6 mb-2" id="batch-button">
                                        <button class="btn btn-dark w-100" onclick="readFile()" type="button">Batch Add Users</button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12 my-2">
                                        <label for="cert" class="sso-inp-label text-primary mr-2"><b>NOTE:</b> For security purposes, users added in batch will automatically get <i>"system-user"</i> role</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark">
                {{-- <button type="submit" class="btn btn-primary tick-btn"></button> --}}
            </div>
        </div>
    </div>
</div>

@include('user.scripts.create')