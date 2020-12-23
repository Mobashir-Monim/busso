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
                            <form action="{{ route('password.email') }}" method="post">
                                @csrf

                                <input type="email" name="email" id="email" class="form-control sso-inp  @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
                                
                                @error('email')
                                    <span class="invalid-feedback text-right mb-2" role="alert">{{ $message }}</span>
                                @else
                                    <label for="email" class="sso-inp-label">Email</label>
                                @enderror
                                
                                <div class="row mt-4">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8 text-right">
                                        <button class="btn btn-dark" type="submit">Send Reset Link</button>
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
