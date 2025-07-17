<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking List') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Booking</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Booking History</li>
					<li class="breadcrumb-item active" aria-current="page">	<a href="{{ route('admin.existingcanceelledbooking') }}"><button class="btn btn-primary" style="margin-left:45rem;">Add New Booking</button></a></li>
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
							<th>Booking Id</th>
							<th>User Name</th>
							<th> <a href="#" data-toggle="tooltip" title="Phone Number"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">Phn no.</span></a></th>
							<th>Service</th>
							<th> <a href="#" data-toggle="tooltip" title="Sub Service"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">Sub S</span></a></th>
							<th>Status</th>
							<th><a href="#" data-toggle="tooltip" title="Amount"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">Amnt</span></a></th>
							<th> <a href="#" data-toggle="tooltip" title="Payment Status"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">P.S</span></a></th>
							<th>  <a href="#" data-toggle="tooltip" title="Booking Time"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">Time </span></a></th>
							<th>Action</th>
						</tr>
					
					</thead>
					<tbody>
					    @foreach($booking as $key => $bookings)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td>{{ $bookings->booking_id }}</td>
							<td>	<a href="#" data-toggle="tooltip" title="{{ $bookings->user_first }} {{ $bookings->user_last}}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $bookings->user_first }} {{ $bookings->user_last}}</span></a></td>
								<th>{{ $bookings->mobile_no }}</th>
							<td><a href="#" data-toggle="tooltip" title="{{ $bookings->service_name }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $bookings->service_name }}</span></a></td>
							
							<td><a href="#" data-toggle="tooltip" title="{{ $bookings->sub_title }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $bookings->sub_title }}</span></a></td>
							<td>{{ $bookings->status }}</td>
							<td>{{ $bookings->amount }}</td>
							<td>{{ $bookings->paid }}</td>
							<td>{{ $bookings->created_at->diffForHumans()}}</td>
							<td><a href="{{ route('admin.bookingDetail',$bookings->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="View Booking Details" class="btn btn-sm btn-warning"><i class="bi bi-eye-fill"></i></button></a> <a href="{{ route('admin.bookingdelete',$bookings->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></a></td>
						</tr>
						@endforeach
					</tbody>
				   
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