<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Provider') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Provider</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Add Provider</li>
				</ol>
			</nav>
		</div>
	</div>
@include('admin.flash-message')	
	<div class="row">
		<div class="col-xl-12 mx-auto">
			<div class="card">
				<div class="card-body">
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{ route('admin.provider.store') }}" method="POST" enctype="multipart/form-data">
						    @csrf
							<div class="col-md-6">
								<label class="form-label">First Name</label>
								<input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror">
								@error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Last Name</label>
								<input type="text" name="last_name" class="form-control">
							</div>
							<div class="col-md-6">
								<label class="form-label">Job Title</label>
								<input type="text" name="jobtitle" class="form-control" required>
							</div>
								<div class="col-md-6">
								<label class="form-label">Mobile</label>
								<div class="input-group">
    								<select class="form-select" style="width:20%;" name="country_code">
    								    @foreach($country as $countries)
    								    <option value="{{$countries->phonecode}}" {{ $countries->phonecode=='90' ? 'selected' : '' }}>{{ $countries->iso}} - {{$countries->phonecode}}</option>
    								    @endforeach
    								</select>
    								<input type="number" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" style="width:80%;">
    								@error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
    							</div>
							</div>
							<div class="col-md-6">
								<label class="form-label">Email</label>
								<input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
								@error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Password</label>
								<input type="text" name="password" class="form-control @error('password') is-invalid @enderror">
								@error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
								<div class="col-md-6">
								<label class="form-label">Invite Code(Optional)</label>
								<input type="text" name="invite_code" class="form-control" required>
							</div>
								<div class="col-md-6">
								<label class="form-label">Company Name</label>
								<input type="text" name="company_name" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Company Address</label>
								<input type="text" name="company_add" class="form-control" required>
							</div>
								<div class="col-md-6">
								<label class="form-label">Account Number</label>
								<input type="text" name="account_no" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Routing Number</label>
								<input type="text" name="routing_name" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Insurance Number</label>
								<input type="text" name="insurance_no" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Vehicle Make</label>
								<input type="text" name="vehicle_make" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Vehicle Name</label>
								<input type="text" name="vehicle_name" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Vehicle Model</label>
								<input type="text" name="vehicle_model" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Plate Number</label>
								<input type="text" name="plate_no" class="form-control" required>
							</div>
								<div class="col-md-6">
								<label class="form-label">Engine Number</label>
								<input type="text" name="engine_no" class="form-control" required>
							</div>
							 <div class="col-md-6">
								<label for="formFile" class="form-label">Profile Picture</label>
								<input class="form-control" name="profile_pic" type="file" id="formFile" required>
                            </div>
							<div class="col-md-6">
								<label class="form-label">Upload Driving Licence</label>
								<input type="file" name="driving_license" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Experience Letter</label>
								<input type="file" name="experiance_letter" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Identification Proof</label>
								<input type="file" name="idproofff" class="form-control" required>
							</div>
								<div class="col-md-6">
								<label class="form-label">Address Proof</label>
								<input type="file" name="add_proof" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Upload Your RC.</label>
								<input type="file" name="rc_card" class="form-control" required>
							</div>
							
						    <div class="col-md-6">
								<label class="form-label">Birth Date</label>
								<input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror">
								@error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Postcode</label>
								<input type="number" name="postcode" class="form-control">
							</div>
						
						   
						    
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Add Provider</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>