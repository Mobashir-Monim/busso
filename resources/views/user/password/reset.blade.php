@extends('auth.layouts.app')

@section('content')
    <div class="row h-60">
        <div class="col-md-12 my-auto">
            <div class="row my-auto">
                <div class="col-md col-lg"></div>
                <div class="col-md-7 col-lg-5">
                    <div class="card card-login">
                        <div class="card-body">
                            <h3>Reset Password</h3>
                            <form action="{{ route('users.password.reset') }}" method="POST">
                                @csrf
                                
                                <input type="password" name="password" id="password" class="form-control sso-inp  @error('password') is-invalid @enderror" placeholder="New Password" required autofocus>
                                
                                @error('password')
                                    <span class="invalid-feedback text-right mb-2" role="alert">{{ $message }}</span>
                                @else
                                    <label for="email" class="sso-inp-label">Email</label>
                                @enderror
                                
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control sso-inp  @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required>

                                @error('password_confirmation')
                                    <span class="invalid-feedback text-right mb-2" role="alert">{{ $message }}</span>
                                @else
                                    <label for="password" class="sso-inp-label">Re-enter New Password</label>
                                @enderror
                                
                                <div class="row mt-4">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-dark" type="submit">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md col-lg"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection