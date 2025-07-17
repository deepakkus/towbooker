<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Booking History') }}
        </h2>
    </x-slot>
    <style>
        .btn i
        {
            margin-left:0px !important;
        }
    </style>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Users</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">User Booking History</li>
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
							<th>Provider Name</th>
							<th>Service</th>
							<th>Sub Service</th>
							<th>Status</th>
							<th>Amount</th>
							<th>Payment Status</th>
							<th>Booking Time</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($booking as $key => $bookings)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td>{{ $bookings->booking_id }}</td>
							<td>{{ $bookings->user_first }} {{ $bookings->user_last}}</td>
							<td>{{ $bookings->provider_id }}</td>
							<td>{{ $bookings->service_name }}</td>
							<td>{{ $bookings->sub_title }}</td>
							<td>{{ $bookings->status }}</td>
							<td>{{ $bookings->amount }}</td>
							<td>{{ $bookings->paid }}</td>
							<td>{{ $bookings->created_at->diffForHumans()}}</td>
							<td>{{ $bookings->paid }}</td>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
						    <th>#</th>
							<th>Booking Id</th>
							<th>User Name</th>
							<th>Provider Name</th>
							<th>Service</th>
							<th>Sub Service</th>
							<th>Status</th>
							<th>Amount</th>
							<th>Payment Status</th>
							<th>Booking Time</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</x-admin-layout>