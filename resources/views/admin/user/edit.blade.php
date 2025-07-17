<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">User</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit User</li>
				</ol>
			</nav>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12 mx-auto">
			<div class="card">
				<div class="card-body">
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{ route('admin.user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
						    @csrf
							<div class="col-md-6">
								<label class="form-label">First Name</label>
								<input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control @error('first_name') is-invalid @enderror">
								@error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Last Name</label>
								<input type="text" value="{{ $user->last_name }}" name="last_name" class="form-control">
							</div>
							<div class="col-md-6">
								<label class="form-label">Email</label>
								<input type="email" value="{{ $user->email }}" name="email" class="form-control @error('email') is-invalid @enderror">
								@error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Mobile</label>
								<div class="input-group">
    								<select class="form-select" style="width:20%;" name="country_code">
    								    @foreach($country as $countries)
    								    <option value="{{$countries->phonecode}}" {{ $countries->phonecode==$user->country_code ? 'selected' : '' }}>{{ $countries->iso}} - {{$countries->phonecode}}</option>
    								    @endforeach
    								</select>
    								<input type="number" value="{{ $user->mobile_number }}" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" style="width:80%;">
    								@error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
    							</div>
							</div>
						    <div class="col-md-6">
								<label class="form-label">Birth Date</label>
								<input type="date" name="birth_date" value="{{ date('Y-m-d', strtotime($user->birth_date)) }}" class="form-control @error('birth_date') is-invalid @enderror">
								@error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Postcode</label>
								<input type="number" value="{{ $user->postcode }}" name="postcode" class="form-control">
							</div>
						    <div class="col-md-6">
								<label for="formFile" class="form-label">Profile Picture</label>
								<input class="form-control" name="profile_pic" type="file" id="formFile">
                            </div>
						    <div class="col-md-6 text-center">
						        <img src="{{ asset('public/images/'.$user->profile_photo) }}" width="100px">
						    </div>
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Update User</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>