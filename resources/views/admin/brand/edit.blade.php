@extends('admin.layout.master')

@section('content')
    <div class="mt-3">
        <a href="{{ route('brand.index') }}" class="btn btn-secondary">All Categories</a>
    </div>
    <hr>
    <form action="{{ route('brand.update', $brand->slug) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Enter Brand Name</label>
            <input type="text" name="name" value="{{ $brand->name }}" class="form-control">
        </div>
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
@endsection
