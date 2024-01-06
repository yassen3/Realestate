@extends('Admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route("add.testimonials")}}" class="btn btn-primary">Add Testimonial</a>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <h6 class="card-title">All Testimonials</h6>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>Sl</th>
            <th>Name</th>
            <th>Postion</th>
            <th>Image</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $key =>$item)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->position}}</td>
            <td><img src="{{asset($item->image)}}" style="width: 80px; height:50px;"></td>
            <td>
                <a href="{{route ('edit.testimonials', $item->id) }}" class="btn btn-inverse-success">Edit</a>
                <a href="{{ route('delete.testimonials', $item->id) }}" class="btn btn-inverse-danger" id="delete"> Delete  </a>
            </td>

          </tr>
           @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
        </div>
    </div>

</div>


@endsection
