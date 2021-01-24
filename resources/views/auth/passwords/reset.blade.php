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
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
        
                                <input type="hidden" name="token" value="{{ $token }}">

                                <input type="email" name="email" id="email" class="form-control sso-inp  @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback text-right mb-2" role="alert">{{ $message }}</span>
                                @else
                                    <label for="email" class="sso-inp-label">Email</label>
                                @enderror

                                <input type="password" name="password" id="password" class="form-control sso-inp  @error('password') is-invalid @enderror" value="" placeholder="Password" required autocomplete="password" autofocus>

                                @error('password')
                                    <span class="invalid-feedback text-right mb-2" role="alert">{{ $message }}</span>
                                @else
                                    <label for="password" class="sso-inp-label">Password</label>
                                @enderror

                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control sso-inp" value="" placeholder="Password Confirmation" required autocomplete="password" autofocus>

                                <label for="password" class="sso-inp-label">Password Confirmation</label>
                                
                                <div class="row mt-4">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8 text-right">
                                        <button class="btn btn-dark" type="submit">Reset Password</button>
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
