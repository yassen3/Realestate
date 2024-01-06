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

                <h6 class="card-title">Replay Comment</h6>

                 <form method="POST" action="{{ route('replay.message') }}" class="forms-sample" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$comments->id}}">
                                    <input type="hidden" name="user_id" value="{{$comments->user_id}}">
                                    <input type="hidden" name="post_id" value="{{$comments->post_id}}">


                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">User Name:</label>
                                         <code>{{$comments['user']['name']}}</code>
                                    </div>

                                        <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Post Title:</label>
                                        <code>{{$comments['post']['post_title']}}</code>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Subject:</label>
                                        <code>{{$comments->subject}}</code>
                                    </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Message:</label>
                                          <code>{{$comments->message}}</code>
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Subject</label>
                                            <input class="form-control" name="subject" type="text">

                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Message</label>
                                            <input class="form-control" name="message" type="text">
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
