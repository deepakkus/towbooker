<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User List') }}
        </h2>
    </x-slot>
    <style>
        .btn i
        {
            margin-left:0px !important;
        }
    </style>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Users Booking</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">User List</li>
				</ol>
			</nav>
		</div>
	</div>

    <div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table id="example2" class="table table-striped table-bordered">
					<thead>
						<tr>
						    <th>#</th>
							<th>Booking Id</th>
							<th>User Name</th>
							<th>Service</th>
							<th>Subservice</th>
							<th>Status</th>
							
							<th>Booking Time</th>
							
						
						</tr>
					</thead>
					<tbody>
					    @foreach($booking as $key => $bookingss)
						<tr>
						    <td>{{ $key+1 }}</td>
						   	<td>{{ $bookingss->booking_id }}</td>

							<td>{{ $bookingss->user_first }} {{ $bookingss->user_last }}</td>
							<td>{{ $bookingss->service_name }}</td>
							<td>+{{ $bookingss->sub_title }}</td>
						
							<td>{{ $bookingss->status }}</td>
							<td>{{ $bookingss->created_at }}</td>
						
						
						</tr>
						
						
						@endforeach
					</tbody>
				  
				</table>
			</div>
		</div>
	</div>
</x-admin-layout>