@extends('Admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">

        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <h6 class="card-title">All Blog Comment</h6>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>Sl</th>
            <th>Post Title</th>
            <th>User Name</th>
            <th>Subject</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
            @foreach($comments as $key =>$comment)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$comment['post']['post_title']}}</td>
            <td>{{$comment['user']['name']}}</td>
            <td>{{$comment->subject}}</td>
            <td>
                <a href="{{route ('admin.comment.replay', $comment->id) }}" class="btn btn-inverse-success">Replay</a>
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
