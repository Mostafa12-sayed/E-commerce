
  @extends('layouts.master')
  @section('title', 'Login')
  @section('content')
  <link rel="stylesheet" href="{{asset('css/style.css')}}"> 
  <link rel="stylesheet" href="{{asset('css/main.css')}}"> 
  <link rel="stylesheet" href="{{asset('css/LineIcons.3.0.css')}}">  
  @include('flash::message')
  
  <div class="account-login   p-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
          <form class="card login-form" method="post" action="{{route('login')}}">
            @csrf
            <div class="card-body">
              <div class="title">
                <h3>Login Now</h3>
                <p>
                  You can login using your social media account or email
                  address.
                </p>
              </div>
              <div class="social-login">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <a class="btn facebook-btn" href="{{ route('social.login', 'facebook') }}"
                      ><i class="lni lni-facebook-filled"></i> Facebook
                      login</a
                    >
                  </div>

                  <div class="col-lg-6 col-md-6 col-12">
                    <a class="btn google-btn" href="{{ route('social.login', 'google') }}"
                      ><i class="lni lni-google"></i> Google login</a
                    >
                  </div>
                </div>
              </div>
              <div class="alt-option">
                <span>Or</span>
              </div>
              <div class="form-group input-group">
                <label for="reg-fn">Email</label>
                <input
                  class="form-control"
                  type="text"
                  id="reg-email"
                  required
                  name="login"
                  value="{{ old('login') }}"
                />
                @if($errors->has('login'))
                <span class="text-danger">{{ $errors->first('login') }}</span>
                @endif
              </div>
              <div class="form-group input-group">
                <label for="reg-fn">Password</label>
                <input
                  class="form-control"
                  type="password"
                  id="reg-pass"
                  required
                  name="password"
                />
                @if($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>

              <div
                class="d-flex flex-wrap justify-content-between bottom-content"
              >
                <div class="form-check">
                  <input
                    type="checkbox"
                    class="form-check-input width-auto"
                    id="exampleCheck1"
                  />
                  <label class="form-check-label">Remember me</label>
                </div>
                <a class="lost-pass" href="account-password-recovery.html"
                  >Forgot password?</a
                >
              </div>
              <div class="button">
                <button class="btn" type="submit">Login</button>
              </div>
              <p class="outer-link">
                Don't have an account?
                <a href="{{route('register')}}">Register here </a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection


