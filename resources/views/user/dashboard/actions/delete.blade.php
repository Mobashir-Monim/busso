@if (auth()->user()->hasSystemRole('super-admin') || auth()->user()->hasSystemRole('admin') || auth()->user()->hasSystemRole('user-admin'))
    <button class="btn btn-danger user-delete-button" type="button" data-toggle="modal" data-target="#user-delete">
        <i class="fas fa-user-times"></i>
    </button>

    <div class="modal fade" id="user-delete" tabIndex="-1" role="dialog" aria-labelledby="user-delete-prompt" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card-rounded">
                <div class="modal-body">
                    <h3 class="border-bottom border-primary" id="user-delete-prompt">Application Roles</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('users.delete', ['user' => $user->id]) }}" method="POST" id="user-delete">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <p>You are about to delete the user account for <b><span class="text-danger">{{ $user->name }}</span></b> with email address <b><span class="text-danger">{{ $user->email }}</span></b>.</p>

                                <p>Please confirm this action by typing in the email address below</p>
                                
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" name="email_confirm" class="form-control mb-2" placeholder="{{ $user->email }}" id="email-confirm" onkeyup="checkEmailAddress()">
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

    <script>
        let emailConfirm = document.getElementById('email-confirm');
        let deleteButton = document.getElementById('delete-button');

        const checkEmailAddress = () => {
            if (emailConfirm.value == '{{ $user->email }}') {
                deleteButton.disabled = false;
            } else {
                deleteButton.disabled = true;
            }
        }
    </script>
@endif