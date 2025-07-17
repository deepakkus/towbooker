<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Question') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Question</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit Question</li>
				</ol>
			</nav>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12 mx-auto">
			<div class="card">
				<div class="card-body">
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{ route('admin.question.update',$question->id) }}" method="POST" enctype="multipart/form-data">
						    @csrf
							<div class="col-md-6">
								<label class="form-label">Service</label>
								<select class="form-select @error('service_id') is-invalid @enderror" name="service_id" id="service">
								    <option disabled selected>-Select Service-</option>
								    @foreach($service as $row)
								    <option value="{{$row->id}}" {{ $row->id==$question->service_id ? 'selected' : '' }}>{{ $row->title}}</option>
								    @endforeach
								</select>
								@error('service_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Sub Service</label>
								<select class="form-select @error('sub_service_id') is-invalid @enderror" name="sub_service_id" id="sub_service">
                                    <option disabled selected>-Select Sub Service-</option>
                                    @foreach($sub as $row)
								    <option value="{{$row->id}}" {{ $row->id==$question->sub_service_id ? 'selected' : '' }}>{{ $row->title}}</option>
								    @endforeach
								</select>
								@error('sub_service_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Question</label>
								<input type="text" value="{{ $question->question }}" name="question" class="form-control @error('question') is-invalid @enderror">
								@error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
							</div>
							<div class="col-md-6">
								<label class="form-label">Option 1</label>
								<input type="text" value="{{ $question->answer1 }}" name="answer1" class="form-control">
							</div>
							<div class="col-md-6">
								<label class="form-label">Option 2</label>
								<input type="text" value="{{ $question->answer2 }}" name="answer2" class="form-control">
							</div>
							<div class="col-md-6">
								<label class="form-label">Option 3</label>
								<input type="text" value="{{ $question->answer3 }}" name="answer3" class="form-control">
							</div>
							<div class="col-md-6">
								<label class="form-label">Option 4</label>
								<input type="text" value="{{ $question->answer4 }}" name="answer4" class="form-control">
							</div>
						    
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Update Question</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>
<!--Get Sub Service-->
<script>
    $(document).ready( function()
    {
        $('#service').on('change', function()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var service_id=$(this).val();
            // alert(state_id);
            if(service_id)
            {
                $.ajax({
                    type:'post',
                    url:'{{route("admin.question.getSubService")}}',
                    data:{
                        service_id:service_id,
                    },
                    success:function(data)
                    {
                        $('#sub_service').html(data);
                    }
                });
            }else
            {
                $('#sub_service').html('<option>Select Service first</option>');
            }
        });
    });
</script>