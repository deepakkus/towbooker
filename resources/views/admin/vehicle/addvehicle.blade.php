<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Vehicle Type') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Vehicle Type</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Add Vehicle Type</li>
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
						<form class="row g-3" action="{{ route('admin.vehicle.add') }}" method="POST" enctype="multipart/form-data">
						    @csrf
							<div class="col-md-6">
								<label class="form-label">Title</label>
								<input type="text" name="title" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Vehicle Image</label>
								<input type="file" name="image" class="form-control">
							</div>
						
						    
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Add Vehicle</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>