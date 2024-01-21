@extends('admin.layout.master')

@section('color', 'nav-link nav-link active')

@section('content')
    <div class="mt-3">
        <a href="{{ route('color.create') }}" class="btn btn-secondary">Create Color</a>
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
            @foreach ($colors as $color)
                <tr>
                    <td>{{ $color->name }}</td>
                    <td class="d-flex">
                        <a href="{{ route('color.edit', $color->id) }}" class="btn btn-success me-4">Edit</a>
                        <form action="{{ route('color.destroy', $color->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $colors->links() }}
@endsection
