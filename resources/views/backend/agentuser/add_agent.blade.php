@extends('Admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">
      <!-- left wrapper start -->

      <!-- left wrapper end -->
      <!-- middle wrapper start -->
      <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
            <div class="card">
                <div class="card-body">

                                  <h6 class="card-title">Add Agent</h6>

                                  <form method="POST" action="{{ route('store.agent') }}" class="forms-sample">
                                    @csrf

                                    <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Agent Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " id="name" autocomplete="off" >
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>

                                    <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Agent Email</label>
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror " id="email" autocomplete="off" >
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Agent Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror " id="phone" autocomplete="off" >
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Agent Address</label>
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror " id="address" autocomplete="off" >
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Agent Password</label>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror " id="password" autocomplete="off" >
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                </div>

                                      <button type="submit" class="btn btn-primary me-2">Submit</button>

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




@endsection
