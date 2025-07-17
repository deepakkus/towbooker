<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sub Service List') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Services</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Sub Service List</li>
				</ol>
			</nav>
		</div>
	</div>
    <div class="card">
        @include('admin.flash-message')
		<div class="card-body">
			<div class="table-responsive">
				<table id="example2" class="table table-striped table-bordered">
					<thead>
						<tr>
						    <th>#</th>
							<th>Service Name</th>
							<th>Sub Service Name</th>
							<th>Price</th>
							<th>Sub Service Image</th>
							<th>Description</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($subService as $key => $subServices)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td>{{ $subServices->service_name }}</td>
							<td>{{ $subServices->title }}</td>
							<td>{{ $subServices->currency_code }} {{ $subServices->price }}</td>
							<td><img src="{{ asset('public/images/'.$subServices->image) }}" width="auto" height="70px"></td>
							<td>{{ Str::words($subServices->description,10) }}</td>
							<td>
							    <div class="form-check form-switch">
									<input class="form-check-input sub-service-status" data-id="{{$subServices->id}}" type="checkbox" {{ $subServices->status ? 'checked' : '' }}>
								</div>
							</td>
							<td><a href="{{ route('admin.service.editSubService',$subServices->id) }}"><button type="button" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button></a> <a href="{{ route('admin.service.deleteSubService',$subServices->id) }}"><button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></a></td>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
						    <th>#</th>
							<th>Service Name</th>
							<th>Sub Service Name</th>
							<th>Price</th>
							<th>Service Image</th>
							<th>Description</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

</x-admin-layout>