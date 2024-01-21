@extends('admin.layout.master')

@section('brand', 'nav-link nav-link active')

@section('content')
    <div class="mt-3">
        <a href="{{ route('brand.create') }}" class="btn btn-secondary">Create Brand</a>
    </div>
    <hr>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->name }}</td>
                    <td class="d-flex">
                        <a href="{{ route('brand.edit', $brand->id) }}" class="btn btn-success me-4">Edit</a>
                        <form action="{{ route('brand.destroy', $brand->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $brands->links() }}
@endsection
