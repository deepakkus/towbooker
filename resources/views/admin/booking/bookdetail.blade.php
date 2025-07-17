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
					<li class="breadcrumb-item active" aria-current="page">Booking Detail</li>
				</ol>
			</nav>
		</div>
	</div>
		@include('admin.flash-message')

    <div class="card">
		<div class="card-body">
		   <!-- <h2>{{ $booking  }}</h2>-->
		
		<h3>Booking Id: {{ $booking->booking_id  }}</h3>
		<div class="row">
		    <div class="col-md-4">
		        <h5>User info</h5>
		        @php
		        $userdata = \DB::table('users')->where('id',$booking->user_id)->get()->first();
		        @endphp
		        <p>Name:<b>{{ $userdata->first_name }} {{ $userdata->last_name }}</b></p>
		        <p>Email: <b>{{ $userdata->email }}</b></p>
		        <p>Contact: <b>{{ $userdata->mobile_number }}</b></p>
		    </div>
		  
		    <div class="col-md-4">
		        
		        @php $providerdata = \DB::table('providers')->where('id',$booking->provider_id)->get()->first();  @endphp
		        
		        <h5>Provider info</h5>
		         @if($providerdata === Null)
		        
		        <p>Name:Provider Not Found<b></b></p>
		        <p>Email:<b></b></p>
		        <p>Contact: <b></b></p>
		        
		        @else
		        
		        <p>Name:<b> {{ $providerdata->first_name }}</b></p>
		        <p>Email:<b> {{ $providerdata->email }}</b></p>
		        <p>Contact: <b>{{ $providerdata->mobile_number }}</b></p>
		        
		        @endif
		        
		    </div>
		  
		     <div class="col-md-4">
		         @php
		         $subservdata = \DB::table('sub_services')->where('id',$booking->sub_service_id)->get()->first();
		         @endphp
		        <h5>Booking Detail</h5>
		        <p>Service: <b>{{ $subservdata->title }}</b></p>
		        <p>Start Time:<b> {{ $booking->schedule_date }} {{ $booking->schedule_start }}</b></p>
		        <p>End Time: <b>{{ $booking->schedule_date }} {{ $booking->schedule_end }}</b></p>
		        <p>Amount:<b> {{ $booking->amount }}</b></p>
		        
		        @if($booking->status == 'COMPLETED')
		        
		         <p>Amount:<b> COMPLETED</b></p>
		         
		         @else
		        
		        <form method="POST" action="{{ route('status.update.store') }}">
		            @csrf
		            <input type="hidden" name="id" value="{{ $booking->id }}">
		            <div class="row">
		           
		       	<select style="width:224px;"class="form-select" required="" name="status">
		       	    <option disabled="" value="">-Select-</option>
								<option  value="CANCELLED">CANCELLED</option>
									<option  value="COMPELETED">COMPELETED</option>
									<option value="ACCEPTED">ACCEPTED</option>
									<option value="STARTED">STARTED</option>
     			</select>
		

<button class="mt-4 btn btn-primary" style="width: 50%;">update status</button>
</div>
		       </form>
		       @endif
		    </div>
		</div>
		
		<div class="row">
		    <h5>Service Location: </h5>
		</div>
		
		
		
		
		
		
		
		</div>
	</div>
</x-admin-layout>