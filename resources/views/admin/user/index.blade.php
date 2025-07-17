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
		<div class="breadcrumb-title pe-3">Users</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">User List</li>
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
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Birth Date</th>
							<th>Post Code</th>
							<th>Wallet</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($userList as $key => $users)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td>{{ $users->first_name }} {{ $users->last_name }}</td>
							<td>{{ $users->email }}</td>
							<td>+{{ $users->country_code }}{{ $users->mobile_number }}</td>
							<td>{{ $users->birth_date }}</td>
							<td>{{ $users->postcode }}</td>
							<td>{{ $users->wallet_balance }}</td>
							<td>
							    <div class="form-check form-switch">
									<input class="form-check-input user-status" data-id="{{$users->id}}" type="checkbox" {{ $users->status ? 'checked' : '' }}>
								</div>
							</td>
							<td><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $users->id }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="View Profile" class="btn btn-sm btn-warning"><i class="bi bi-eye-fill"></i></button></a> <a href="{{ route('admin.userhistoryyy',$users->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="User Bookings History" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button></a> <a href="{{ route('admin.user.edit',$users->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="btn btn-sm btn-info"><i class="bi bi-pencil-square"></i></button></a> <a href="{{ route('admin.user.delete',$users->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></a></td>
						</tr>
						<!-- Modal -->
						<div class="modal fade" id="exampleModal{{ $users->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body" style="white-space:normal !important;">
									    <!--<img src="{{ asset('public/images/'.$users->profile_photo) }}">-->
									   
									    <p><b>Name: {{ $users->first_name }} {{ $users->last_name }}  </b></p>
									    <p><b>Email: {{ $users->email }} </b></p>
									    <p><b>Mobile: +{{ $users->country_code }}-{{ $users->mobile_number }} </b></p>
									    <p><b>Birth Date: {{ $users->birth_date }} </b></p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary">Save changes</button>
									</div>
								</div>
							</div>
						</div>
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
							<th>Status</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</x-admin-layout>