@extends('admin.layout.master')

@section('category', 'nav-link nav-link active')

@section('content')
    <div class="mt-3">
        <a href="{{ route('category.create') }}" class="btn btn-secondary">Create Category</a>
    </div>
    <hr>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Name(MM)</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td><img src="{{ asset('/images/' . $category->image) }}" width="100px" class="img-thumbnail"
                            alt=""></td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->mm_name }}</td>
                    <td class="d-flex">
                        <a href="{{ route('category.edit', $category->slug) }}" class="btn btn-success me-4">Edit</a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $categories->links() }}
@endsection
