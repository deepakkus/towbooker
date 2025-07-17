<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Review List') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Review</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">User Review List</li>
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
							<th>Rating</th>
							<th>Review</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($review as $key => $row)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td>{{ $row->booking_id }}</td>
							<td>{{ $row->first_name }} {{ $row->last_name }}</td>
							<td>
							    @if($row->user_rated == 0)
							    No Rating
							    @elseif($row->user_rated == 1)
							    <i class="bi bi-hand-thumbs-up-fill" style="color:green;font-size:20px;"></i>
							    @elseif($row->user_rated == 2)
							    <i class="bi bi-hand-thumbs-down-fill" style="color:red;font-size:20px;"></i>
							    @endif
					        </td>
							<td>{{ $row->user_review }}</td>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
                            <th>#</th>
							<th>Booking Id</th>
							<th>User Name</th>
							<th>Rating</th>
							<th>Review</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</x-admin-layout>