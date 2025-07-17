<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('App Setting') }}
        </h2>
    </x-slot>
    
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">App Setting</div>
		<div class="ps-3">
		    <nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Upadate App Setting</li>
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
                        <h6 class="mb-0 text-uppercase">App Setting</h6>
                        <hr/>
                        <form class="row g-3" action="{{ route('admin.updateAppSetting',$app->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-12 col-md-4 mx-auto text-end">
                                <label class="form-label">App Name: </label>
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <input type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" autocomplete="app_name" value="{{ $app->app_name }}">
                                @error('app_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2"></div>
                            
                            <div class="col-12 col-md-4 mx-auto text-end">
                                <label for="formFile" class="form-label">App Icon</label>
                            </div>    
                            <div class="col-12 col-md-6 mx-auto">
                                <input class="form-control @error('app_icon') is-invalid @enderror" type="file" id="formFile" name="app_icon">
                                @error('app_icon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2"></div>
                            
                            <div class="col-md-4 mx-auto"></div>
                            <div class="col-md-6 mx-auto">
                                <img src="{{ $app->app_icon }}" width="auto" height="200px">
                            </div>
                            <div class="col-md-2"></div>
                            
                            <div class="col-12 col-md-4 mx-auto text-end">
                                <label class="form-label">Currency Symbol: </label>
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" name="currency_symbol" autocomplete="currency_symbol" value="{{ $app->currency_symbol }}">
                                @error('currency_symbol')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2"></div>
                            
                            <div class="col-12 col-md-4 mx-auto text-end">
                                <label class="form-label">Currency Code: </label>
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <input type="text" class="form-control @error('currency_code') is-invalid @enderror" name="currency_code" autocomplete="currency_code" value="{{ $app->currency_code }}">
                                @error('currency_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Update App Setting</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-admin-layout>    