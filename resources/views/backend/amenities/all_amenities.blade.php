@extends('Admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            {{-- <a href="{{route('add.type')}}" class="btn btn-inverse-info">Add Amenities</a> --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Amenities
              </button>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <h6 class="card-title">All Amenities</h6>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>Sl</th>
            <th>Amenities Name</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
            @foreach($amenities as $key =>$amenitie)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$amenitie->amenities_name}}</td>

            <td>
                <a href="{{route('edit.amenities', $amenitie->id)}}" class="btn btn-inverse-success">Edit</a>
                <a href="{{route('delete.amenities', $amenitie->id)}}" class="btn btn-inverse-danger" id="delete"> Delete  </a>
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




<!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

      <div class="modal-content">
        {{-- <form action="{{route('store.amenities')}}" method="post"> --}}
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Amenities</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>

        <div class="modal-body">
            <form method="post" id="storeAmenities">
                @csrf
            <div class="mb-3">
                <label for="name">Amenities Name</label>
                <input name="amenities_name" type="text" autofocus class="form-control @error('amenities_name') is-invalid @enderror">
                @error('amenities_name')
                <div class="text-danger">
                    {{$message}}
                </div>
               @enderror
            </div>
        </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="storeAmenities" formaction="{{url (route ('store.amenities') )}}">Save changes</button>
        </div>
    </form >
      </div>

    </div>
  </div>




@endsection
