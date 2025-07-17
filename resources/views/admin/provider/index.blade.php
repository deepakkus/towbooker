<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Provider List') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Provider</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Provider List</li>
				</ol>
			</nav>
		</div>
	</div>
	@include('admin.flash-message')
    <div class="card">
		<div class="card-body">
		    in
			<div class="table-responsive">
				<table id="example2" class="table table-striped table-bordered">
					<thead>
						<tr>
						    <th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Birth Date</th>
							<th>Post Code</th>
							<th>Wallet</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($provider as $key => $providers)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td><a href="#" data-toggle="tooltip" title="{{ $providers->first_name }} {{ $providers->last_name }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $providers->first_name }} {{ $providers->last_name }}</span></a></td>
							<td>	<a href="#" data-toggle="tooltip" title="{{ $providers->email }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $providers->email }}</span></a></td>
							<td>	<a href="#" data-toggle="tooltip" title="+{{ $providers->country_code }}-{{ $providers->mobile_number }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">+{{ $providers->country_code }}-{{ $providers->mobile_number }}</span></a></td>
							<td>{{ $providers->birth_date }}</td>
							<td>{{ $providers->postcode }}</td>
							<td>{{ $providers->wallet }}</td>
							
						
							
						
							
							<td><a href="#"  class="mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $providers->id }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="View Profile" class="btn btn-sm btn-warning"><i class="bi bi-eye-fill"></i></button></a> 
							
							<a class="mx-1" href="{{ route('admin.editprovider',$providers->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="btn btn-sm btn-info"><i class="bi bi-pencil-square"></i></button></a> 
							
							<a class="mx-1" href="{{ route('admin.provider.provider',$providers->id) }}"><button  style="font-size:11px;"  type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="View Document" class="btn btn-dark btn-info"><i class="bi-file-earmark-pdf"></i></button></a> 
							
							
							<a class="mx-1" href="{{ route('admin.provider.document.update',$providers->id) }}"><button style="font-size:11px;" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve Provider" class="btn btn-success"><i class="bi-check-circle-fill"></i></button></a>
							
							<a class="mx-1" href="{{ route('admin.deleteproviderr',$providers->id) }}"><button style="font-size:11px;" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Provider" class="btn btn-danger"><i class="bi-x-circle-fill"></i></button></a> </td>
							<!-- Modal -->
						<div class="modal fade" id="exampleModal{{ $providers->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body" style="white-space:normal !important;">
									    
									    <p><b>Name: {{ $providers->first_name }} {{ $providers->last_name }} </b></p>
									    <p><b>Email: {{ $providers->email }} </b></p>
									    <p><b>Mobile: +{{ $providers->country_code }}-{{ $providers->mobile_number }} </b></p>
									    <p><b>Birth Date: {{ $providers->birth_date }} </b></p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary">Save changes</button>
									</div>
								</div>
							</div>
						</div>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
						    <th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Birth Date</th>
							<th>Post Code</th>
							<th>Wallet</th>
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