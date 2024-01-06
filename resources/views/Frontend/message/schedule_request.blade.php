@extends('Frontend.frontend_dashboard')
@section('main')

        <!--Page Title-->
        <section class="page-title centred" style="background-image: url({{asset('frontend/assets/images/background/page-title-5.jpg')}});">
            <div class="auto-container">
                <div class="content-box clearfix">
                    <h1>User Profile </h1>
                    <ul class="bread-crumb clearfix">
                        <li><a href="index.html">Home</a></li>
                        <li>User Profile </li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Title-->


        <!-- sidebar-page-container -->
        <section class="sidebar-page-container blog-details sec-pad-2">
            <div class="auto-container">
                <div class="row clearfix">


@php
$id = Auth::user()->id;
$userData = App\Models\User::find($id);

@endphp



        <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
            <div class="blog-sidebar">
              <div class="sidebar-widget post-widget">
                    <div class="widget-title">
                        <h4>User Profile </h4>
                    </div>
                    <div class="post-inner">
                        <div class="post">
                            <figure class="post-thumb"><a href="blog-details.html">
       <img src="{{(!empty($userData->photo)) ? url('upload/user_images/'.$userData->photo) : url('upload/no_image.jpg')}}" alt="" style="width: 100px; height: 100px" ></a></figure>
        <h5><a href="blog-details.html">{{$userData->name}} </a></h5>
         <p>{{$userData->email}} </p>
                        </div>
                    </div>
                </div>

        <div class="sidebar-widget category-widget">
            <div class="widget-title">

                @include('Frontend.dashboard.dashboard_sidebar')

            </div>
          </div>

                        </div>
                    </div>




  <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                        <div class="blog-details-content">
                            <div class="news-block-one">
                                <div class="inner-box">

                                    <div class="lower-content">
                                        <h3>Schedule Request.</h3>

                                        <table class="table table-striped">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Property Name</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Status</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($srequest as $key => $item)
                                              <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$item['property']['property_name']}}</td>
                                                <td>{{$item->tour_date}}</td>
                                                <td>{{$item->tour_time}}</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <span class="badge rounded-pill bg-success">Confirm</span>
                                                    @else
                                                    <span class="badge rounded-pill bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                              </tr>
                                              @endforeach
                                            </tbody>
                                          </table>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- subscribe-section end -->



        @endsection
