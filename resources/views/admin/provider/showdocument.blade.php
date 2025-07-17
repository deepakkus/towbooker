<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Documents') }}
        </h2>
    </x-slot>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Documents</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">{{$document->first_name}} {{$document->last_name}}'s Documents</li>
				</ol>
			</nav>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12 mx-auto">
			<div class="  card">
				<div class="card-body">
					<div class="p-4 border rounded row">
						
						   <div class="col-md-6 my-4 ">
						       <div style="margin-left: 29px;
    margin-bottom: 20px;
    font-weight: 500;
    font-size: 18px;">						  	<label class="form-label">Registration Card</label>
</div>

							<a href="{{ asset('public/admin/images/registrationcard/'.$document->rc_card) }}">	<img src="{{ asset('public/admin/images/registrationcard/'.$document->rc_card) }}" alt="Document is not Available" width="200px">
													  	
							</a>
							</div>
							
							
						
                            <div class="col-md-6 my-4 ">
                                <div style="margin-left: 29px;
    margin-bottom: 20px;
    font-weight: 500;
    font-size: 18px;">
                    	<label class="form-label">ID Proof</label>
</div>
						<a href="{{ asset('public/admin/images/idproof/'.$document->id_proof) }}">	<img src="{{ asset('public/admin/images/idproof/'.$document->id_proof) }}" alt="Document is not Available" width="200px">
							</a>	
							</div>

							 <div class="col-md-6 my-4 ">
							    
                                <div style="margin-left: 29px;
    margin-bottom: 20px;
    font-weight: 500;
    font-size: 18px;">
							<label class="form-label">Address Proof</label>
</div>

					

							<a href="{{ asset('public/admin/images/addressproof/'.$document->address_proof) }}"><img src="{{ asset('public/admin/images/addressproof/'.$document->address_proof) }}" alt="Document is not Available" width="200px">
							</a>		
							</div>

							 <div class="col-md-6 my-4 ">
							   
                                <div style="margin-left: 29px;
    margin-bottom: 20px;
    font-weight: 500;
    font-size: 18px;">
							 <label class="form-label">Experience Letter</label>
</div>
			

							<a href="{{ asset('public/admin/images/experienceletter/'.$document->experience_letter) }}">	<img src="{{ asset('public/admin/images/experienceletter/'.$document->experience_letter) }}" alt="Document is not Available" width="200px">
							</a>	
							</div>

							 <div class="col-md-6 my-4 ">
							    
                                <div style="margin-left: 29px;
    margin-bottom: 20px;
    font-weight: 500;
    font-size: 18px;">
							<label class="form-label">Driving License</label>
</div>

					

							<a href="{{ asset('public/admin/images/drivinglicense/'.$document->driving_license) }}"><img src="{{ asset('public/admin/images/drivinglicense/'.$document->driving_license) }}" alt="Document is not Available" width="200px">
							</a>		
							</div>
   
						  
				    </div>
			    </div>
		    </div>
	    </div>
    </div>

</x-admin-layout>