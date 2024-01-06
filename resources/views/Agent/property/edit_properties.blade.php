@extends('Agent.agent_dashboard')
@section('agent')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">
      <!-- left wrapper start -->

      <!-- left wrapper end -->
      <!-- middle wrapper start -->
      <div class="col-md-12 col-xl-12 middle-wrapper">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Property</h6>
                        <form method="post" action="{{ route('agent.update.properties') }}"  id="myForm" enctype="multipart/form-data" >
                            @csrf
                             {{-- @method('POST') --}}
                             <input type="hidden" name="id" value="{{$properties->id}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Name</label>
                                        <input type="text" name="property_name" class="form-control" @error('property_name') is-invalid @enderror value="{{$properties->property_name}}" >
                                        @error('property_name')
                                         <div class="text-danger">
                                            {{$message}}
                                         </div>
                                       @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Property Status</label>
                                    <select name="property_status" id="property_status" class="form-select" @error('property_status') is-invalid @enderror >
                                        <option selected="" disabled="">Select Status</option>
                                        <option value="rent" {{$properties->property_status == 'rent' ? 'selected' : ''}}>For Rent</option>
                                        <option value="buy" {{$properties->property_status == 'buy' ? 'selected' : ''}}>For Buy</option>
                                    </select>
                                    @error('property_status')
                                         <div class="text-danger">
                                            {{$message}}
                                         </div>
                                       @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Lowest Price</label>
                                        <input type="text" name="lowest_price" class="form-control" placeholder="Enter Property name" @error('lowest_price') is-invalid @enderror value="{{$properties->lowest_price}}">
                                        @error('lowest_price')
                                         <div class="text-danger">
                                            {{$message}}
                                         </div>
                                       @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Max Price</label>
                                        <input type="text" name="max_price" class="form-control" placeholder="Enter Property name" @error('max_price') is-invalid @enderror value="{{$properties->max_price}}">
                                        @error('max_price')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->


                            </div><!-- Row -->

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Bedrooms</label>
                                        <input type="text" name="bedrooms" class="form-control" @error('bedrooms') is-invalid @enderror value="{{$properties->bedrooms}}">
                                        @error('bedrooms')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                     </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Bathrooms</label>
                                        <input type="text" name="bathrooms" class="form-control" @error('bathrooms') is-invalid @enderror value="{{$properties->bathrooms}}">
                                        @error('bathrooms')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Garage</label>
                                        <input type="text" name="garage" class="form-control"@error('garage') is-invalid @enderror value="{{$properties->garage}}">
                                        @error('garage')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                     </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Garage Size</label>
                                        <input type="text" name="garage_size" class="form-control"@error('garage_size') is-invalid @enderror value="{{$properties->garage_size}}" >
                                        @error('garage_size')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                     </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control"@error('address') is-invalid @enderror value="{{$properties->address}}">
                                        @error('address')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" name="city" class="form-control"@error('city') is-invalid @enderror value="{{$properties->city}}">
                                        @error('city')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">State</label>
                                        <select class="form-select" name="state" id="exampleFormControlSelect1" @error('state') is-invalid @enderror>
                                            <option selected="" disabled="">Select State</option>
                                            @foreach($pstate as $state)
                                            <option value="{{$state->id}}"{{$state->id == $properties->state ? 'selected' : ''}}>{{$state->state_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                     </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Postal Code</label>
                                        <input type="text" name="postal_code" class="form-control"@error('postal_code') is-invalid @enderror value="{{$properties->postal_code}}">
                                        @error('postal_code')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                      </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Size</label>
                                        <input type="text" name="property_size" class="form-control" @error('property_size') is-invalid @enderror value="{{$properties->property_size}}">
                                        @error('propetry_size')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                      </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Video</label>
                                        <input type="text" name="property_video" class="form-control"@error('property_video') is-invalid @enderror value="{{$properties->property_video}}">
                                        @error('property_video')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Neighborhood</label>
                                        <input type="text" name="neighborhood" class="form-control" @error('neighborhood') is-invalid @enderror value="{{$properties->neighborhood}}">
                                        @error('neighborhood')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->

                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" name="latitude" class="form-control"@error('latitude') is-invalid @enderror value="{{$properties->latitude}}">
                                        @error('latitude')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get latitude from address</a>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Longtitude</label>
                                        <input type="text" name="longtitude" class="form-control" @error('longtitude') is-invalid @enderror value="{{$properties->longtitude}}">
                                        @error('longtitude')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get longtitude from address</a>

                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Type</label>
                                        <select class="form-select" name="ptype_id" id="exampleFormControlSelect1" @error('ptype_id') is-invalid @enderror >
                                            <option selected="" disabled="">Select Type</option>
                                            @foreach($propertytype as $ptype)
                                            <option value="{{$ptype->id}}" {{ $ptype->id == $properties->ptype_id ? 'selected' : '' }}>{{$ptype->type_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('ptype_id')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                             </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Amenities</label>
                                        <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%" @error('amenities_id[]') is-invalid @enderror>
                                            @foreach($amenities as $amenitie)
                                            <option value="{{$amenitie->amenities_name}}" {{(in_array($amenitie->amenities_name,$properties_amenities)) ? 'selected' : ''}}>{{$amenitie->amenities_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('amenities_id[]')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Short Description</label>
                                        <textarea class="form-control" name="short_desc" id="exampleFormControlTextarea1" rows="3" @error('short_desc') is-invalid @enderror>{{$properties->short_desc}}</textarea>
                                        @error('short_desc')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Long Description</label>
                                        <textarea class="form-control" name="long_desc" id="tinymceExample" rows="10" @error('long_desc') is-invalid @enderror>{{$properties->long_desc}}</textarea>
                                        @error('long_desc')
                                        <div class="text-danger">
                                           {{$message}}
                                        </div>
                                      @enderror
                                    </div>
                                </div><!-- Col -->
                                <hr>
                                <div class="form-group mb-3">
                                    <div class="form-check form-check-inline">
                                       <input name="featured" value="1" type="checkbox" class="form-check-input" id="checkInline1"{{$properties->featured == '1' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="checkInline1">
                                            Features Property
                                        </label>

                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="hot" value="1" type="checkbox" class="form-check-input" id="checkInline" {{$properties->hot == '1' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="checkInline">
                                               Hot Property
                                            </label>
                                    </div>


                                </div>
                            </div><!-- Row -->

                         <button type="submit" class="btn btn-primary submit">Save Changes</button>
                        </form>

                </div>
            </div>

        </div>
      </div>
      <!-- middle wrapper end -->
      <!-- right wrapper start -->
      <div class="d-none d-xl-block col-xl-3">

      </div>
      <!-- right wrapper end -->
    </div>

        </div>

        {{-- // Property Main Thambnail Image Update // --}}

        <div class="page-content" style="margin-top: -35px">


            <div class="row profile-body">

              <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit Main Thambnail</h6>
                                <form method="post" action="{{ route('agent.update.properties.thambnail') }}"  enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" name="id" value="{{$properties->id}}">
                                    <input type="hidden" name="old_img" value="{{$properties->property_thambnail}}">

                                    <div class="row mb-3">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Main Thambnail</label>
                                            <input type="file" name="property_thambnail" class="form-control" onchange="mainThamUrl(this)" placeholder="Enter Property name" @error('property_thambnail') is-invalid @enderror>
                                            @error('property_thambnail')
                                            <div class="text-danger">
                                               {{$message}}
                                            </div>
                                          @enderror
                                            <img src="" id="mainThmb">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group col-md-6">
                                                <label class="form-label"></label>
                                                <img src="{{asset($properties->property_thambnail)}}" style="width: 100px; height:100px;" id="mainThmb">
                                            </div>
                                        </div>
                                    </div><!-- Col -->
                                    <button type="submit" class="btn btn-primary submit">Save Changes</button>

                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        {{-- //End Property Main Thambnail Image Update // --}}



                {{-- // Property Multi Image Update // --}}

                <div class="page-content" style="margin-top: -35px">


                    <div class="row profile-body">

                      <div class="col-md-12 col-xl-12 middle-wrapper">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Edit Multi Image Thambnail</h6>
                                        <form method="post" action="{{ route('agent.update.properties.multiimage') }}"  enctype="multipart/form-data" >
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>S1</th>
                                                            <th>Image</th>
                                                            <th>Change Image</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($multiImage as $key => $img)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td class="py-1">
                                                                <img src="{{ asset($img->photo_name) }}" alt="image"  style="width:60px; height:60px;">
                                                            </td>

                                                            <td>
                                                                <input type="file" class="form-control" name="multi_img[{{$img->id}}]" @error('multi_img[{{$img->id}}]') is-invalid @enderror>
                                                                @error('multi_img[{{$img->id}}]')
                                                                <div class="text-danger">
                                                                   {{$message}}
                                                                </div>
                                                              @enderror
                                                            </td>
                                                            <td><input type="submit" class="btn btn-primary px-4" value="Update Image">
                                                                <a href="{{route('agent.delete.properties.multiimage',$img->id)}}" class="btn btn-danger" id="delete">Delete</a>
                                                            </td>


                                                        </tr>
                                                         @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
<br><br>

                                        </form>
                      {{-- // End Property Multi Image Update // --}}


                       {{-- //  Property Store New Multi Image Update // --}}
                       <form method="post" action="{{ route('agent.store.new.multiimage') }}" id="myForm" enctype="multipart/form-data">
                        @csrf

                <input type="hidden" name="imageid" value="{{ $properties->id }}">

        <table class="table table-striped">
         <tbody>
            <tr>
                <td>
                    <input type="file" class="form-control" name="multi_img">
                </td>

                <td>
                    <input type="submit" class="btn btn-info px-4" value="Add Image" >
                </td>
            </tr>
        </tbody>
        </table>

        </form>




                </div>
                  </div>

                </div>
            </div>
          </div>
        </div>

                {{-- // End Property Store New Multi Image Update // --}}


                  {{-- // Property Facilities // --}}

        <div class="page-content" style="margin-top: -35px">


            <div class="row profile-body">

              <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit Property Facilities</h6>
                                <form method="post" action="{{ route('agent.update.properties.facilities') }}"  enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" name="id" value="{{$properties->id}}">
                                    @foreach($facilities as $item)
                                    <div class="row add_item">
                                    <div class="whole_extra_item_add" id="whole_extra_item_add">
                                    <div class="whole_extra_item_delete" id="whole_extra_item_delete">
                                        <div class="container mt-2">
                                           <div class="row">

                                              <div class="form-group col-md-4">
                                                 <label for="facility_name">Facilities</label>
                                                 <select name="facility_name[]" id="facility_name" class="form-control">
                                                       <option value="">Select Facility</option>
                                                       <option value="Hospital"{{$item->facility_name == 'Hospital' ? 'selected' : ''}}>Hospital</option>
                                                       <option value="SuperMarket" {{$item->facility_name == 'SuperMarket' ? 'selected' : ''}}>Super Market</option>
                                                       <option value="School" {{$item->facility_name == 'School' ? 'selected' : ''}}>School</option>
                                                       <option value="Entertainment" {{$item->facility_name == 'Entertainment' ? 'selected' : ''}}>Entertainment</option>
                                                       <option value="Pharmacy" {{$item->facility_name == 'Pharmacy' ? 'selected' : ''}}>Pharmacy</option>
                                                       <option value="Airport" {{$item->facility_name == 'Airport' ? 'selected' : ''}}>Airport</option>
                                                       <option value="Railways" {{$item->facility_name == 'Railways' ? 'selected' : ''}}>Railways</option>
                                                       <option value="Bus Stop" {{$item->facility_name == 'Bus Stop' ? 'selected' : ''}}>Bus Stop</option>
                                                       <option value="Beach" {{$item->facility_name == 'Beach' ? 'selected' : ''}}>Beach</option>
                                                       <option value="Mall" {{$item->facility_name == 'Mall' ? 'selected' : ''}}>Mall</option>
                                                       <option value="Bank" {{$item->facility_name == 'Bank' ? 'selected' : ''}}>Bank</option>
                                                 </select>
                                              </div>
                                              <div class="form-group col-md-4">
                                                 <label for="distance">Distance</label>
                                                 <input type="text" name="distance[]" id="distance" class="form-control" value="{{ $item->distance }}">
                                              </div>
                                              <div class="form-group col-md-4" style="padding-top: 20px">
                                                 <span class="btn btn-success addeventmore">Add</span>
                                                 <span class="btn btn-danger removeeventmore">Remove</span>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
                                    </div>
                                </div>
                                     @endforeach
                                     <br>
                                     <button type="submit" class="btn btn-primary submit">Save Changes</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

       {{-- // End Property Facilities // --}}

       <!--========== Start of add multiple class with ajax ==============-->
<div style="visibility: hidden">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
       <div class="whole_extra_item_delete" id="whole_extra_item_delete">
          <div class="container mt-2">
             <div class="row">

                <div class="form-group col-md-4">
                   <label for="facility_name">Facilities</label>
                   <select name="facility_name[]" id="facility_name" class="form-control">
                         <option value="">Select Facility</option>
                         <option value="Hospital">Hospital</option>
                         <option value="SuperMarket">Super Market</option>
                         <option value="School">School</option>
                         <option value="Entertainment">Entertainment</option>
                         <option value="Pharmacy">Pharmacy</option>
                         <option value="Airport">Airport</option>
                         <option value="Railways">Railways</option>
                         <option value="Bus Stop">Bus Stop</option>
                         <option value="Beach">Beach</option>
                         <option value="Mall">Mall</option>
                         <option value="Bank">Bank</option>
                   </select>
                </div>
                <div class="form-group col-md-4">
                   <label for="distance">Distance</label>
                   <input type="text" name="distance[]" id="distance" class="form-control" placeholder="Distance (Km)">
                </div>
                <div class="form-group col-md-4" style="padding-top: 20px">
                   <span class="btn btn-success addeventmore">Add</span>
                   <span class="btn btn-danger removeeventmore">Remove</span>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>


             <!----For Section-------->
             <script type="text/javascript">
                $(document).ready(function(){
                   var counter = 0;
                   $(document).on("click",".addeventmore",function(){
                         var whole_extra_item_add = $("#whole_extra_item_add").html();
                         $(this).closest(".add_item").append(whole_extra_item_add);
                         counter++;
                   });
                   $(document).on("click",".removeeventmore",function(event){
                         $(this).closest("#whole_extra_item_delete").remove();
                         counter -= 1
                   });
                });
             </script>
             <!--========== End of add multiple class with ajax ==============-->

 {{-- <script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                property_name: {
                    required : true,
                },
                 property_status: {
                    required : true,
                },
                 lowest_price: {
                    required : true,
                },
                 max_price: {
                    required : true,
                },
                 ptype_id: {
                    required : true,
                },


            },
            messages :{
                property_name: {
                    required : 'Please Enter Property Name',
                },
                 property_status: {
                    required : 'Please Select Property Status',
                },
                lowest_price: {
                    required : 'Please Enter Lowest Price',
                },
                max_price: {
                    required : 'Please Enter Max Price',
                },
                ptype_id: {
                    required : 'Please Select Property Type',
                },


            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script> --}}


 {{-- The Main Image Part --}}
 <script type="text/javascript">
    function mainThamUrl(input){
        if(input.files && input.files[0]){
            var reader = new FileReader()
            reader.onload = function(e){
              $('#mainThmb').attr('src',e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    </script>
     {{-- Enf Of The Main Image Part --}}
    <script>

    //  {{-- The Main Multi_Image Part --}}
        $(document).ready(function(){
         $('#multiImg').on('change', function(){ //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data

                $.each(data, function(index, file){ //loop though each file
                    if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file){ //trigger function on successful read
                        return function(e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                        .height(80); //create image element
                            $('#preview_img').append(img); //append image to output element
                        };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            }else{
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
         });
        });

        </script>
            {{-- The End Of Main Multi_Image Part --}}










@endsection
