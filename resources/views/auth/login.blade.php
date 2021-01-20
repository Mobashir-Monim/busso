@extends('auth.layouts.app')

@section('content')
    <div class="row h-60">
        <div class="col-md-12 my-auto">
            <div class="row my-auto">
                <div class="col-md col-lg"></div>
                <div class="col-md-7 col-lg-5">
                    <div class="card card-login">
                        <div class="card-body">
                            <h3>{{ isset(request()->SAMLRequest) || isset($oauth) ? 'BuSSO ' : '' }}Login</h3>
                            <form action="{{ 
                                !isset(request()->SAMLRequest) && !isset($oauth) ? route('login') : (
                                    !isset(request()->SAMLRequest) ?
                                        route('sso.oauth.login', ['oauth' => request()->oauth]) : route('sso.saml.assert-login', ['entity' => $entity->id])
                                )
                            }}" method="post">
                                @csrf
                                
                                @isset(request()->SAMLRequest)
                                    @include('auth.sso.saml')
                                @endisset

                                @isset($oauth)
                                    @include('auth.sso.oauth')
                                @endisset

                                <input type="email" name="email" id="email" class="form-control sso-inp  @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
                                
                                @error('email')
                                    <span class="invalid-feedback text-right mb-2" role="alert">{{ $message }}</span>
                                @else
                                    <label for="email" class="sso-inp-label">Email</label>
                                @enderror
                                
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
                                        <button class="btn btn-dark" type="submit">Login</button>
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
    {{-- <script>
        window.onload = () => {
            for (let index = 0; index < 10; index++) {
                console.log('hello')
            }
        }
    </script> --}}
@endsection