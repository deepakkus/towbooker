 <x-admin-layout>
     @include('admin.flash-message')
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz7nCSdu64pveMDxSLd2KvqyfBfBGsnIs&v=3.exp&sensor=false&libraries=places"></script>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Services</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-list-ol"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Update Booking</li>
				</ol>
			</nav>
		</div>
	</div>
	
	<div class="row">
	  
		<div class="col-xl-12 mx-auto">
			<div class="card">
			      
				<div class="card-body">
				   
				    <h6>Check Bookings Status</h6>
				    
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{route('cancelledeBookingStatus') }}" method="POST" enctype="multipart/form-data">
						    @csrf
					<input type="hidden" name="id" id="id" class="form-control" required >

							  <div class="col-md-2">
								<label class="form-label">Booking Id</label>
				         
                                    
								<select class="form-select bookingid" id="bookingiddd" onchange="getbookingdata()" name="bookid" required>
								    <option disabled="" value="">-Select-</option>
								    @foreach($existing as $existinggg)
								    
								<option value="{{ $existinggg->booking_id }}">{{ $existinggg->booking_id }}</option>
								@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label class="form-label">User Name</label>
								<input type="text" name="username" id="username" class="form-control" required readonly>
							</div>
							<div class="col-md-2">
								<label class="form-label">Service 
								Name</label>
								<input type="text" name="service" id="service" class="form-control" required readonly>
							</div>
						   	<div class="col-md-2">
								<label class="form-label">Subservice Name</label>
								<input type="text" name="subservice" id="sunservicename" class="form-control" required readonly>
							</div>
						   
						   	<div class="col-md-2">
								<label class="form-label">Amount</label>
								<input type="text" name="price" id="amount" class="form-control" required readonly>
							</div>
						  	<div class="col-md-2">
								<label class="form-label">Status</label>
								<input type="text" name="status" id="amount" class="form-control" required readonly value="SEARCHING">
							</div>
							
							
						  
						    
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Update Booking</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>
    
    
    	<div class="row">
	   @include('admin.flash-message')
		<div class="col-xl-12 mx-auto">
			<div class="card">
			      
				<div class="card-body">
				    <h6>Create New Bookings</h6>
					<div class="p-4 border rounded">
						<form class="row g-3" action="{{route('admin.bookingservice') }}" method="POST" enctype="multipart/form-data">
						    @csrf
							  <div class="col-md-2">
								<label class="form-label">User Name</label>
								
				         @php $username = \DB::table('users')->get(); @endphp
								<select class="form-select bookingid" ="" id="bookingiddd" name="user_id" required>
								    <option disabled="" value="">-Select-</option>
								    @foreach ($username as $usernames)
								<option value="{{$usernames->id}}">{{$usernames->first_name}} {{$usernames->last_name}}</option>
							@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label class="form-label">Service Provider</label>
								
				         				         @php $providername = \DB::table('providers')->where('deleted_at',NULL)->get(); @endphp

                                    
								<select class="form-select bookingid" ="" id="bookingiddd" name="provider_id" required>
								    <option disabled="" value="">-Select-</option>
							@foreach ($providername as $providernames)
								<option value="{{$providernames->id}}">{{$providernames->first_name}} {{$providernames->last_name}}</option>
								@endforeach
							
								</select>
							</div>
							<div class="col-md-2">
								<label class="form-label">Service Name</label>
								  
								<select class="form-select bookingid" ="" id="servicesss" onchange="getsubservices()"  name="service_id" required>
								    <option disabled="" value="">-Select-</option>
								  	@foreach ($s as $servicenames)  
								<option value="{{$servicenames->id}}">{{$servicenames->title}}</option>
								@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label class="form-label">Subservice Name</label>
								
								<select class="form-select bookingid"  id="subservicedata" name="sub_service_id" onchange="getsrvamt()" required>
								    <option disabled="" value="">-Select-</option>
								<option>-SelectSubservice-</option>
							
								</select>
							</div>
							 
						  
							<div class="col-md-2">
								<label class="form-label">Amount</label>
								<input type="text" id="priceee" class="form-control" name="amount" readonly >
							</div> 
						   	
							 	<div class="col-md-2">
							 	    <label class="form-label">User Location</label>
								<input type="search" id="location" name="" class="form-control register-form__location-holder" required>
	<div style="margin-top: 17px;
    position: absolute;
    z-index: 1;
  
    width: 176px;
    right: 88px;">
							
   <input type="text" name="user_latitude" value="" class="form-control register-form__latitude-holder" id="latitide" readonly>
   
   <input type="text" name="user_longitude" value="" class="form-control register-form__longitude-holder" id="longitude" style="margin-top: 1px;" readonly>
   
   </div>
    
				                </div>
				                
				                
				                	<div style="width:100%;height:300px" id="map" class="register-formmap register-form_map--user"></div>
				                	
				                	
				                	
							<div class="col-md-2">
								<label class="form-label">Booking Type</label>
								  
								<select class="form-select bookingid"   name="bookingtype" required>
								    <option disabled="" value="">-Select-</option>
								  	 
								<option value="0">Instant Booking</option>
								<option value="1"> Schedule Booking</option>
								
								</select>
							</div>
								<div class="col-md-2">
								<label class="form-label">Start Time</label>
								<input type="time" name="schedule_start" class="form-control" >
							</div>
							 	<div class="col-md-2">
								<label class="form-label">End Time</label>
								<input type="time" name="schedule_end" class="form-control">
							</div>
						   	<div class="col-md-2">
								<label class="form-label">Select Date</label>
								<input type="date" name="schedule_date" class="form-control">
							</div>
						   
							<div class="col-md-2">
								<label class="form-label">No. Of Person</label>
						<input type="number" name="person" class="form-control" value="1" required>

							</div>
							 	
							 	<div class="col-md-2">
								<label class="form-label">Enter Vehicle Number</label>
								<input type="text" name="vehicle_no" class="form-control" required>
							</div>
						  
						 	
						    
						    <div class="col-12">
							    <button class="btn btn-primary" type="submit">Create New Booking</button>
						    </div>
					    </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>
    
    
    
   
</x-admin-layout>


 <script type="text/javascript">


 $(document).ready(function() 
 {
     var autocomplete;
     var id = 'location';
     
     autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), 
     {
         types:['geocode'],

          })
          
          google.maps.event.addListener(autocomplete,'place_changed',function(){
              
              var place = autocomplete.getPlace();
              jQuery("#latitide").val(place.geometry.location.lat());
              jQuery("#longitude").val(place.geometry.location.lng());  
     }) 
        
 });
	
	
	

	   function initMap(lat, long) {	

  var center = new google.maps.LatLng(parseFloat(lat), long);
    var mapOptions = {center: center, zoom: 16, scrollwheel: false};
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    marker = new google.maps.Marker({position: new google.maps.LatLng(lat, long), draggable:true, map: map,title: 'Test'});

        google.maps.event.addListener(marker, 'dragend', function (event) {
            var lat = this.getPosition().lat();
            var long = this.getPosition().lng();
            initMap(lat, long);
            
            $('#latitide').val(lat);
            $('#longitude').val(long);
        });		
    }
    
    
     $('body').on('change', '.register-form__location-holder', function(e) {
        var address = $(this).val();
        var geocoder = new google.maps.Geocoder();
        if (geocoder) {
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    console.log(results[0].geometry.location);
                    var lat = results[0].geometry.location.lat();
                    var long = results[0].geometry.location.lng();

                    console.log("lat="+lat);
                    
                    initMap(lat, long);
                    $('#latitide').val(lat);
                    $('#longitude').val(long);
                }
                else {
                    
                    $('#latitide').focus().select();
                }
            });
        }

    });
                            
    var lat = $('#latitide').val();
    var long = $('#longitude').val();

		
	initMap(0,0);
	
	
	
	</script>
<script
  src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  
  
 <script>
     function getbookingdata()
     {
         var bookid = $("#bookingiddd").val();
        
         $.ajax({
            data :{bookid: bookid},
            url  :"https://demo.towbooker.com/admin/getajaxdata", //php page URL where we post this data to view from database
            type :'GET',
            success: function(data){
              console.log(data.data);
            $("#id").val(data.data.id);
              $("#username").val(data.data.user_first+ data.data.user_last);
              $("#service").val(data.data.service_name);
              $("#sunservicename").val(data.data.sub_title);
              $("#amount").val(data.data.amount);
            }
        });
         
     }
 </script>
 
 <script>
     function getsubservices()
     {
         var servicedata = $("#servicesss").val();
         $.ajax({
            data :{servicedata: servicedata},
            url  :"https://demo.towbooker.com/servicesubservice", //php page URL where we post this data to view from database
            type :'GET',
            success: function(data){
                $("#subservicedata").html(data);
              console.log(data.data);

           
            }
        });
         
     }
     
     
     function getsrvamt()
     {
          var servicedata = $("#subservicedata").val();
         $.ajax({
            data :{servicedata: servicedata},
            url  :"https://demo.towbooker.com/servicesubbservice", //php page URL where we post this data to view from database
            type :'GET',
            success: function(data){
                $("#priceee").val(data);
            //  console.log(data.data);
              

           
            }
        });
         
     }
     
     
     
     
     
     
 </script>
 
 
 
 

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 