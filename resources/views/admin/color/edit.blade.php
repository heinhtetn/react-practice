@extends('admin.layout.master')

@section('content')
    <div class="mt-3">
        <a href="{{ route('color.index') }}" class="btn btn-secondary">All Categories</a>
    </div>
    <hr>
    <form action="{{ route('color.update', $color->slug) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Enter Color Name</label>
            <input type="text" name="name" value="{{ $color->name }}" class="form-control">
        </div>
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
@endsection
