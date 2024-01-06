@extends('Admin.admin_dashboard')
@section('admin')
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

                                  <h6 class="card-title">Edit Post</h6>

                                  <form method="POST" action="{{ route('update.post') }}" class="forms-sample" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{$post->id}}">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Post Title</label>
                                                <input type="text" name="post_title" class="form-control" @error('post_title') is-invalid @enderror value="{{$post->post_title}}" >
                                                @error('post_title')
                                                 <div class="text-danger">
                                                    {{$message}}
                                                 </div>
                                               @enderror
                                            </div>
                                        </div><!-- Col -->
                                        <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Blog Category</label>
                                            <select name="blogcat_id" id="property_status" class="form-select" @error('blogcat_id') is-invalid @enderror >
                                                <option selected="" disabled="">Select Status</option>
                                                @foreach ($blogcat as $item)
                                                <option value="{{$item->id}}" {{$item->id == $post->blogcat_id ? 'selected' : ''}}>{{$item->category_name}}</option>
                                                @endforeach

                                            </select>
                                            @error('blogcat_id')
                                                 <div class="text-danger">
                                                    {{$message}}
                                                 </div>
                                               @enderror
                                            </div>
                                        </div><!-- Col -->
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Short Description</label>
                                            <textarea class="form-control" name="short_desc" id="exampleFormControlTextarea1" rows="3" @error('short_desc') is-invalid @enderror>{{$post->short_desc}}</textarea>
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
                                            <textarea class="form-control" name="long_desc" id="tinymceExample" rows="10" @error('long_desc') is-invalid @enderror>{!! $post->long_desc !!}</textarea>
                                            @error('long_desc')
                                            <div class="text-danger">
                                               {{$message}}
                                            </div>
                                          @enderror
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Post Tags</label>
                                            <input name="post_tags" id="tags" value="{{$post->post_tags}}" />



                                        </div>
                                    </div><!-- Col -->
                                                       <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">Post Photo</label>
                                                        <input class="form-control" name="post_image" type="file" @error('post_image') is-invalid @enderror id="image">
                                                        @error('post_image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label"></label>
                                                        <img id=showImage class="wd-100 rounded-circle" src=" {{asset($post->post_image)}}" alt="profile" id="showImage">

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
