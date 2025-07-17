<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Banner') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Banner</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
				</ol>
			</nav>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12 mx-auto">
			<div class="card">
				<div class="card-body">
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{ route('admin.banner.update',$banner->id) }}" method="POST" enctype="multipart/form-data">
						    @csrf
							<div class="col-md-4">
								<label class="form-label">Title</label>
								<input type="text" value="{{ $banner->title }}" name="title" class="form-control @error('title') is-invalid @enderror">
								@error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-4">
								<label for="formFile" class="form-label">Banner</label>
								<input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="formFile">
								@error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
						    <div class="col-md-4 text-center">
						        <img src="{{ asset('public/banner/'.$banner->image) }}" width="100px">
						    </div>
						    <div class="col-md-12">
								<label class="form-label">Description</label>
								<textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ $banner->description }}</textarea>
								@error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Update Banner</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>