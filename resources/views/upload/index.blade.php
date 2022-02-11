@extends('layouts.app')


@section('content')

<div class="file-upload">

    <!--Display the required fields Message-->
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{$error}}
        </div>
    @endforeach

    @if ($msg = Session::get('msg'))
    <div class="alert alert-primary" role="alert">
        {{$msg}}
    </div>
    @endif

    <form action="{{route('upload.store')}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="alert alert-success">
        <button class="file-upload-btn" type="submit">Upload</button>
        <input type="checkbox" name="access" id="access" value="1">
        <label for="access">Public</label>
    </div>
    <div class="image-upload-wrap">
        <input type="file" name="file_name" class="file-upload-input" onchange="readURL(this);" accept="*" />
        <div class="drag-text">
        <h3>Drag and drop a file or select add file</h3>
        </div>
    </div>
    <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add File</button>
    <div class="file-upload-content">
    <object data="{{asset('assets/images/default.png')}}" type="image">
        <img class="file-upload-image" src="#"/>
    </object>
        <div class="image-title-wrap">
        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
        </div>
    </form>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">File</th>
        <th scope="col">Link</th>
        <th scope="col">Access</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
     @forelse ($files as $file )
     <tr>
        <td>{{$file->name}}</td>
        <td><a href="{{asset($file->path)}}">{{asset($file->path)}}</a></td>
        <td>{{($file->access==0)?'private':'public'}}</td>
        <td>
         <form action="{{route('upload.delete',$file->id)}}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger">Delete</button>
         </form>
        </td>

      </tr>
     @empty
     <tr>
      <td>{{"No Files Found"}}</td>
     </tr>
     @endforelse

    </tbody>
  </table>
</div>
@endsection
