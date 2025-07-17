<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dress Code List') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Dress Code</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Dress Code List</li>
				</ol>
			</nav>
		</div>
	</div>
	@include('admin.flash-message')
    <div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table id="example2" class="table table-striped table-bordered">
					<thead>
						<tr>
						    <th>#</th>
							<th>Title</th>
							<th>Dress Code</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($dress as $key => $row)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td>{{ $row->title }}</td>
							<td><img src="{{ asset('public/dress/'.$row->image) }}" width="100px" height="100px"></td>
							<td>
							    <div class="form-check form-switch">
									<input class="form-check-input dress-status" data-id="{{$row->id}}" type="checkbox" {{ $row->status ? '' : 'checked' }}>
								</div>
							</td>
							<td><a href="{{ route('admin.dress.edit',$row->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="btn btn-sm btn-info"><i class="bi bi-pencil-square"></i></button></a></td>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
                            <th>#</th>
							<th>Title</th>
							<th>Dress Code</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</x-admin-layout>