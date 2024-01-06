@extends('admin.admin_dashboard')
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

			<h6 class="card-title">Update Site Setting   </h6>

  <form id="myForm" method="POST" action="{{ route('update.site.setting') }}" class="forms-sample" enctype="multipart/form-data">
				@csrf
  <input type="hidden" name="id" value="{{ $siteSettings->id }}">

				<div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Support Phone</label>
	  <input type="text" name="support_phone" class="form-control" value="{{ $siteSettings->support_phone }}" >
				</div>

                        <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Company address</label>
      <input type="text" name="company_address" class="form-control" value="{{ $siteSettings->company_address }}" >
                </div>


                        <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Email</label>
      <input type="text" name="email" class="form-control" value="{{ $siteSettings->email}}" >
                </div>



                        <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Facebook</label>
      <input type="text" name="facebook" class="form-control" value="{{ $siteSettings->facebook}}" >
                </div>

                        <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Twitter</label>
      <input type="text" name="twitter" class="form-control" value="{{ $siteSettings->twitter}}" >
                </div>

                        <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Copyright</label>
      <input type="text" name="copyright" class="form-control" value="{{ $siteSettings->copyright }}" >
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Logo</label>
                    <input class="form-control" name="logo" type="file" id="image">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label"></label>
                    <img id=showImage class="wd-70 rounded-circle" src="{{asset($siteSettings->logo)}}" alt="profile" id="showImage">

                </div>

	 <button type="submit" class="btn btn-primary me-2">Save Changes </button>

			</form>

              </div>
            </div>




            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->

          <!-- right wrapper end -->
        </div>

			</div>


            <script type="text/javascript">
                $(document).ready(function(){
                    $('#image').change(function(e){
                        var reader = new FileReader();
                        reader.onload = function(e){
                            $('#showImage').attr('src',e.target.result);
                        }
                        reader.readAsDataURL(e.target.files['0']);
                    });
                });
                </script>


@endsection
