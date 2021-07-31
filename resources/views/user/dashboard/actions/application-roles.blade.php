<button class="btn btn-dark user-access-button" type="button" data-toggle="modal" data-target="#access-list">
    <span class="material-icons-outlined">accessibility_new</span>
</button>

<div class="modal fade" id="access-list" tabIndex="-1" role="dialog" aria-labelledby="access-list-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content card-rounded">
            <div class="modal-body">
                <h3 class="border-bottom border-primary" id="access-list-title">Application Roles</h3>
                <div class="row">
                    <div class="col-md-12">
                        @if (count($user->roles->where('is_system_role', false)) > 0)
                            <ul class="list-group">
                                @foreach ($user->roles->where('is_system_role', false) as $role)
                                    <li class="list-group-item">{{ $role->display_name }} ({{ $role->name }})</li>
                                @endforeach
                            </ul>
                        @else
                            <h5 class="text-center">No application roles assigned</h5>
                            <h1 class="text-center mt-3">( 0 _ 0 )</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>