@extends('auth.layouts.app')

@section('content')
    <div class="row h-60">
        <div class="col-md-12 my-auto">
            <div class="row my-auto">
                <div class="col-md col-lg"></div>
                <div class="col-md-7 col-lg-5">
                    <div class="card card-login">
                        <div class="card-body">
                            <h3>Confirm Password</h3>
                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf
                                
                                <input type="password" name="password" id="password" class="form-control sso-inp  @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback text-right mb-2" role="alert">{{ $message }}</span>
                                @else
                                    <label for="password" class="sso-inp-label">Password</label>
                                @enderror
                                
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Password</a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button class="btn btn-dark" type="submit">Confirm</button>
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
