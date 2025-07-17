<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question List') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Question</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Question List</li>
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
							<th>Service</th>
							<th>Sub Service</th>
							<th>Question</th>
							<th>Options</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @foreach($question as $key => $row)
						<tr>
						    <td>{{ $key+1 }}</td>
							<td><a href="#" data-toggle="tooltip" title="{{ $row->service_name }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $row->service_name }}</span></a></td>
							<td>	<a href="#" data-toggle="tooltip" title="{{ $row->sub_service_name }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $row->sub_service_name }}</span></a></td>
							<td><a href="#" data-toggle="tooltip" title="{{ $row->question }}"><span style="display:inline-block;width:80px;white-space:nowrap;overflow:hidden!important;text-overflow:ellipsis;color:black;">{{ $row->question }}</span></a> </td>
							<td>a. {{ $row->answer1 }}<br>b. {{ $row->answer2 }} @if($row->answer3 != '')<br>c. {{ $row->answer3 }}@endif @if($row->answer4 != '')<br>d. {{ $row->answer4 }}@endif</td>
							<td>
							    <div class="form-check form-switch">
									<input class="form-check-input question-status" data-id="{{$row->id}}" type="checkbox" {{ $row->status ? '' : 'checked' }}>
								</div>
							</td>
							<td><a href="{{ route('admin.question.edit',$row->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="btn btn-sm btn-info"><i class="bi bi-pencil-square"></i></button></a> <a href="{{ route('admin.question.delete',$row->id) }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></a></td>
						</tr>
						@endforeach
					</tbody>
				    <tfoot>
						<tr>
                            <th>#</th>
							<th>Service</th>
							<th>Sub Service</th>
							<th>Question</th>
							<th>Options</th>
							<th>Status</th>
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