@extends('admin.layout.master')

@section('content')
    <div class="mt-3">
        <a href="{{ route('category.index') }}" class="btn btn-secondary">All Categories</a>
    </div>
    <hr>
    <form action="{{ route('category.update', $category->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Enter Category Name</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Enter Category MM-Name</label>
            <input type="text" name="mm_name" value="{{ $category->mm_name }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Choose Image</label>
            <input type="file" name="image" class="form-control">
            <img src="{{ asset('/images/' . $category->image) }}" style="width: 200px" class="img-thumbnail mt-2"
                alt="">
        </div>
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
@endsection
