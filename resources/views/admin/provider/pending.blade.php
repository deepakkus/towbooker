<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Withdrawal Request') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Provider</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Withdrawal Request</li>
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
							<th>Provider Name</th>
							<th>Wallet Balance</th>
							<th>Withdrawl Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($withdraw as $key => $row)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td>{{ $row->first_name }} {{ $row->last_name }}</td>
							<td>{{ $row->wallet }}</td>
							<td>{{ $row->amount }}</td>
							<td><button type="button" class="btn btn-{{$row->status == '0' ? 'warning' : ''}}{{$row->status == '1' ? 'success' : ''}}{{$row->status == '2' ? 'danger' : ''}} split-bg-primary dropdown-toggle dropdown-toggle-split px-4 radius-30" data-bs-toggle="dropdown"> @if($row->status == 0) Pending @elseif($row->status == 1) Approve @else Decline @endif	<span class="visually-hidden">Toggle Dropdown</span></button>
                                @if($row->status == '0')
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                    <a class="dropdown-item" href="{{ route('admin.provider.withdrawalStatus',['id'=>$row->id,'status'=>'1']) }}">Approve</a>
                                    <a class="dropdown-item" href="{{ route('admin.provider.withdrawalStatus',['id'=>$row->id,'status'=>'2']) }}">Decline</a>
                                </div>
                                @endif
                            </td>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
						    <th>#</th>
							<th>Provider Name</th>
							<th>Wallet Balance</th>
							<th>Withdrawl Amount</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</x-admin-layout>