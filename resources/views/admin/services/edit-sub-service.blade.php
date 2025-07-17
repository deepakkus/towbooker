<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sub Service') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Services</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit Service</li>
				</ol>
			</nav>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12 mx-auto">
			<div class="card">
				<div class="card-body">
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{ route('admin.service.updateSubService',$subService->id) }}" method="POST" enctype="multipart/form-data">
						    @csrf
						    <div class="col-md-6">
								<label class="form-label">Select Service</label>
								<select class="form-select" required="" name="service_id">
									<option selected="" disabled="" value="">-Select-</option>
									@foreach($service as $services)
									<option {{ $subService->service_id==$services->id ? 'selected' : '' }} value="{{ $services->id }}">{{ $services->title }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label">Title</label>
								<input type="text" name="title" class="form-control" value="{{ $subService->title }}" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Service Price</label>
								<input type="text" name="price" value="{{ $subService->price }}" class="form-control" required>
							</div>
						    <div class="col-md-6">
								<label class="form-label">Pricing Logic</label>
								<select class="form-select" required="" name="time">
									<option disabled="" value="">-Select-</option>
									<option {{ $subService->time=='min.' ? 'selected' : '' }} value="min.">Per Minute Pricing</option>
									<option {{ $subService->time=='hr.' ? 'selected' : '' }} value="hr.">Per Hour Pricing</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label">Service Image</label>
								<input type="file" name="image" class="form-control">
							</div>
							<div class="col-md-6 text-center">
								<img src="{{ asset('public/images/'.$subService->image) }}" width="100px">
							</div>
						    <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="4" cols="4" spellcheck="false" name="description">{{ $subService->description }}</textarea>
                            </div>
						    
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Update Service</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>