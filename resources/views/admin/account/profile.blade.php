<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    
    <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3 text-white">Profile</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt text-white"></i></a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Admin Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="profile-cover bg-dark"></div>
        
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-0">My Account</h5>
                        <hr>
                        @include('admin.flash-message')
                        <form action="{{ route('admin.updateProfile') }}" method="post">
                            @csrf
                            <div class="card shadow-none border">
                                <div class="card-header">
                                    <h6 class="mb-0">ADMIN INFORMATION</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" id="name" name="name" class="form-control not-allowed" value="{{ $admin->name }}" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Email address</label>
                                            <input type="text" id="email" name="email" class="form-control not-allowed" value="{{ $admin->email }}" readonly>
                                        </div>
                                        <div class="col-12">
        									<label for="formFile" class="form-label">Profile Picture</label>
        									<input class="form-control not-allowed" type="file" id="formFile" disabled>
        								</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border">
                                <div class="card-header">
                                    <h6 class="mb-0">CONTACT INFORMATION</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <input type="text" id="address" name="address" class="form-control not-allowed" value="{{ $admin->address }}" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Country</label>
                                            <select class="form-select not-allowed" id="country" name="country" disabled="true" aria-label="Default select example">
                                                <option></option>
                                                @foreach($country as $countrys)
            									<option @if($admin->country == $countrys->id) selected @endif value="{{ $countrys->id }}">{{ $countrys->name}}</option>
            									@endforeach
            								</select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">State</label>
                                            <input type="text" id="state" name="state" class="form-control not-allowed" value="{{ $admin->state }}" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">City</label>
                                            <input type="text" id="city" name="city" class="form-control not-allowed" value="{{ $admin->city }}" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Pin Code</label>
                                            <input type="text" id="pincode" name="pincode" class="form-control not-allowed" value="{{ $admin->pincode }}" readonly>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">About Me</label>
                                            <textarea class="form-control not-allowed" id="about" name="about" rows="4" cols="4" placeholder="Describe yourself..." readonly>{{ $admin->about }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-start">
                                <input type="button" id="edit" value="Edit" class="btn btn-warning px-4">
                                <button type="submit" id="update" class="btn btn-primary px-4 not-allowed" disabled>Update Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-body">
                        <div class="profile-avatar text-center">
                            <img src="{{asset('public/admin/images/avatars/avatar-1.png')}}" class="rounded-circle shadow" width="120" height="120" alt="">
                        </div>
                        <div class="text-center mt-4">
                            <h4 class="mb-1">{{ $admin->name }}</h4>
                            <p class="mb-0 text-secondary">{{ config('app.name', 'Laravel') }} Admin</p>
                        </div>
                        <hr>
                        <div class="text-start">
                            <h5 class="">About</h5>
                            <p class="mb-0 text-justify">{{ $admin->about }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </x-admin-layout>