@if (auth()->user()->hasRole('super-admin'))
    <form action="{{ route('users.password.override', ['user' => $user->id]) }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-rounded">
                    <div class="card-body">
                        <h4 class="border-bottom border-3 border-primary">Override Password</h4>
                        <div class="row">
                            <div class="col-md-8 mb-2">
                                <input type="password" name="super_admin_password" class="form-control @error('super_admin_password') is-invalid @enderror" placeholder="Super Admin Password">
                                <label for="super_admin_password" class="sso-inp-label mr-2 text-primary">Super Admin Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-2">
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="New Password">
                                <label for="new_password" class="sso-inp-label mr-2 text-primary">New Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-2">
                                <button class="btn btn-dark w-100">Override Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif