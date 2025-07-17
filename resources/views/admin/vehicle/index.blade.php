<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehicle List') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Vehicle List</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Vehicle List</li>
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
							<th>Vehicle Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					   @foreach( $vehiclelist as $key=>$vehiclelists )
						<tr>
						    <td>{{ $key+1 }} </td>
							<td><a href="#" data-toggle="tooltip" title="{{ $vehiclelists->titlle }}"><span style="display:inline-block;width:50px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black">{{ $vehiclelists->titlle }}</span></a></td>
							
							<td><img src="{{ asset('public/admin/vehicle/'.$vehiclelists->vihele_image) }}" width="auto" height="70px"></td>
							
							<td><a href="{{ route('admin.vehicle.edit',$vehiclelists->id) }}"><button type="button" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button></a> <a href="{{ route('admin.vehicle.delete',$vehiclelists->id) }}"><button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></a></td>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
						    <th>#</th>
							<th>Title</th>
							<th>Vehicle Image</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  
  <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</x-admin-layout>