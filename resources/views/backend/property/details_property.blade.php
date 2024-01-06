@extends('Admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
                    <h6 class="card-title">Property Details</h6>
                    <p class="text-muted mb-3">
                    <div class="table-responsive">
                            <table class="table table-striped">

                                <tbody>
                                    <tr>
                                        <th>Property Name</th>
                                        <td><code>{{$properties->property_name}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Property Status</th>
                                        <td><code>{{$properties->property_status}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Lowest Price</th>
                                        <td><code>{{$properties->lowest_price}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Max Price</th>
                                        <td><code>{{$properties->max_price}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Bedrooms</th>
                                        <td><code>{{$properties->bedrooms}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Bathrooms</th>
                                        <td><code>{{$properties->bathrooms}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Garage</th>
                                        <td><code>{{$properties->garage}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Garage Size</th>
                                        <td><code>{{$properties->garage_size}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td><code>{{$properties->address}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td><code>{{$properties->city}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td><code>{{$properties['pstate']['state_name']}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Postal Code</th>
                                        <td><code>{{$properties->postal_code}}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Main Image</th>
                                        <td>
                                            <img src="{{asset($properties->property_thambnail)}}" style="width: 100px;height:90px;" alt="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($properties->status == 1)
                                            <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                            <span class="badge rounded-pill bg-danger">InActive</span>
                                            @endif
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                    </div>
  </div>
</div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
<div class="card">
  <div class="card-body">


                    <div class="table-responsive">
                        <table class="table table-striped">

                                <tbody>
                                    <tr>

                                        <td>Property Size</td>
                                        <td><code>{{$properties->property_size}}</code></td>
                                    </tr>
                                    <tr>

                                        <td>Property Video</td>
                                        <td><code>{{$properties->property_video}}</code></td>
                                    </tr>
                                    <tr>

                                        <td>Neighborhood</td>
                                        <td><code>{{$properties->neighborhood}}</code></td>
                                    </tr>
                                    <tr>

                                        <td>Latitude</td>
                                        <td><code>{{$properties->latitude}}</code></td>
                                    </tr>
                                    <tr>

                                        <td>Longtitude</td>
                                        <td><code>{{$properties->longtitude}}</code></td>
                                    </tr>
                                    <tr>

                                        <td>Property Type</td>
                                        <td><code>{{$properties['type']['type_name']}}</code></td>
                                    </tr>
                                    <tr>

                                        <td>Property Amenities</td>
                                        <td>
                                            <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%" >
                                                @foreach($amenities as $amenitie)
                                                <option value="{{$amenitie->amenities_name}}" {{(in_array($amenitie->amenities_name,$properties_amenities)) ? 'selected' : ''}}>{{$amenitie->amenities_name}}</option>
                                                @endforeach
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>

                                        <td>Agent</td>
                                        @if($properties->agent_id == NULL)
                                        <td><code>Admin</code></td>
                                        @else
                                        <td><code>{{$properties['user']['name']}}</code></td>
                                        @endif
                                    </td>
                                    </tr>
                                    <tr>

                                        <td>Short Description</td>
                                        <td><code>{{$properties->short_desc}}</code></td>
                                    </tr>
                                    <tr>

                                        <td>Long Description</td>
                                        <td><code>{{!! $properties->long_desc !!}}</code></td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                            <br><br>
                            @if($properties->status == 1)
                            <form method="post" action="{{ route('inactive.properties') }}" >
                             @csrf
                             <input type="hidden" name="id" value="{{$properties->id}}">
                             <button type="submit" class="btn btn-primary">InActive</button>
                            </form>
                            @else
                            <form method="post" action="{{ route('active.properties') }}" >
                                @csrf
                                <input type="hidden" name="id" value="{{$properties->id}}">
                                <button type="submit" class="btn btn-primary">Active</button>
                            </form>
                            @endif

  </div>
</div>
        </div>
    </div>

        </div>






@endsection
