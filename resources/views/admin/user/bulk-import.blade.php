<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bulk Import') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">User</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Bulk Import</li>
				</ol>
			</nav>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12 mx-auto">
			<div class="card">
				<div class="card-body">
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{ route('admin.user.import.store') }}" method="POST" enctype="multipart/form-data">
						    @csrf
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<label for="formFile" class="form-label">Upload File</label>
								<input class="form-control" name="file" type="file" id="formFile">
								<br>
								<center><a href="{{ asset('public/user_sample.xlsx') }}" download>Click To Download (Sample File)</a></center>
							</div>
							<div class="col-md-3"></div>
						    <div class="col-12 text-center">
							    <button class="btn btn-primary" type="submit">Insert Bulk</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>