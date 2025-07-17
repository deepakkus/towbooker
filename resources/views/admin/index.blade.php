<x-adminAuth-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sign In') }}
        </h2>
    </x-slot>
    <div class="container-fluid mt-0 p-0">
        <div >
            <div class="card rounded-0 overflow-hidden shadow-none border mb-5 mb-lg-0">
                <div class="row g-0">
                    <div class="col-12 order-1 col-xl-7 d-flex align-items-center justify-content-center border-end">
                        <img src="{{ asset('public/admin/images/error/road.png') }}" width="90%" style="height:265px;" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 col-xl-5 order-xl-2" style="background-color: rgb(232,240,254);padding:70px;">
                        <div class="card-body p-4 p-sm-5" >
                          
                          <h3 class="login-heading mb-4">Welcome back!</h3>
<form class="form-body" action="{{ route('admin.loginn')}}" method="POST">
    @csrf
<div class="form-label-group">
<input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address">
<label for="inputEmail">Email address / Mobile</label>
</div>
<div class="form-label-group">
<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">
<label for="inputPassword">Password</label>
</div>
<div class="custom-control custom-checkbox mb-3">
<input type="checkbox" class="custom-control-input" id="customCheck1">
<label class="custom-control-label" for="customCheck1">Remember password</label>
</div>
<button class="btn btn-lg btn-outline-primary btn-block btn-login text-uppercase font-weight-bold mb-2"> Login</button>
<div class="text-center pt-3">
This is password protected admin panel,  <a class="font-weight-bold" >Please handle it carefully</a>
</div>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-adminAuth-layout>