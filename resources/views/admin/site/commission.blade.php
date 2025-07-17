<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Commission') }}
        </h2>
    </x-slot>
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Site Setting</div>
		<div class="ps-3">
		    <nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Admin Commission</li>
				</ol>
			</nav>
		</div>
	</div>
    
    <div class="row">
		<div class="col-xl-12 mx-auto">
		    @include('admin.flash-message')
		    <div class="card">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Admin Commission</h6>
                        <hr/>
                        <form class="row g-3" action="{{ route('admin.updateCommission',$commission->id) }}" method="POST">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Admin Commission (%)</label>
                                <input type="text" class="form-control" name="commission" value="{{ $commission->commission }}">
                                <!--@error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror-->
                            </div>
                            <div class="col-3 mx-auto">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>