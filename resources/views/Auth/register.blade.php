
  @extends('layouts.master')
  @section('title', 'Register')
  @section('content')
  <link rel="stylesheet" href="{{asset('css/style.css')}}"> 
  <link rel="stylesheet" href="{{asset('css/main.css')}}"> 
  <link rel="stylesheet" href="{{asset('css/LineIcons.3.0.css')}}">  
  @include('flash::message')
  
  <div class="account-login   p-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
          <form class="card login-form" method="post" action="{{route('register')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="title">
                <h3>Register Now</h3>
                <p>
                  You can Refister using your social media account or email
                  address.                </p>
              </div>
              <div class="social-login">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <a class="btn facebook-btn" href="{{ route('social.login', 'facebook') }}"
                      ><i class="lni lni-facebook-filled"></i> Facebook
                      Regisetr</a
                    >
                  </div>

                  <div class="col-lg-6 col-md-6 col-12">
                    <a class="btn google-btn" href="{{ route('social.login', 'google') }}"
                      ><i class="lni lni-google"></i> Google Regisetr</a
                    >
                  </div>
                </div>
              </div>
              <div class="alt-option">
                <span>Or</span>
              </div>
              <div class="form-group input-group">
                <label for="reg-fn">Name</label>
                <input
                  class="form-control"
                  type="text"
                  id="reg-email"
                  required
                  name="name"
                  value="{{ old('name') }}"
                />
                @if($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
              <div class="form-group input-group">
                <label for="reg-fn">Email</label>
                <input
                  class="form-control"
                  type="text"
                  id="reg-email"
                  required
                  name="email"
                  value="{{ old('email') }}"
                />
                @if($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
              <div class="form-group input-group">
                <label for="reg-fn">Phone</label>
                <input
                  class="form-control"
                  type="text"

                
                  name="phone"
                  value="{{ old('phone') }}"
                />
                @if($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
              </div>
              <div class="form-group input-group">
                <label for="reg-fn">Image</label>
                <input
                  class="form-control"
                  type="file"
     
                  
                  name="image"
                  value="{{ old('image') }}"
                />
                @if($errors->has('image'))
                <span class="text-danger">{{ $errors->first('image') }}</span>
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
              <div class="form-group input-group">
                <label for="reg-fn">Confirm Password</label>
                <input
                  class="form-control"
                  type="password"
                  id="reg-pass"
                  required
                  name="password_confirmation"
                />
                @if($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
              </div>
              <div class="button">
                <button class="btn" type="submit">Register</button>
              </div>
              <p class="outer-link">
                Already have an account?
                <a href="{{route('login')}}">Login here </a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection


