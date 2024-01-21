@extends('admin.layout.master')

@section('product', 'nav-link nav-link active')

@section('content')
    <div class="mt-3">
        <a href="{{ route('product.create') }}" class="btn btn-secondary">Create Product</a>
    </div>
    <hr>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Remain Qty</th>
                <th>Add or Rremove</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><img src="{{ asset('/images/' . $product->image) }}" style="width: 200px" class="img-thumbnail"
                            alt=""></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->total_quantity }}</td>
                    <td>
                        <a href="{{ url('/admin/create-product-remove', $product->slug) }}" class="btn btn-warning">-</a>
                        <a href="{{ url('/admin/create-product-add', $product->slug) }}" class="btn btn-warning">+</a>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-success me-4">Edit</a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger deleteButton"
                                    data-id="{{ $product->id }}">Delete</button>
                            </form>
                        </div>


                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $products->links() }}
@endsection


@section('script')
    <script>
        $(document).on('click', '.deleteButton', function(e) {
            e.preventDefault();
            const deleteButton = $(this);
            const productId = deleteButton.data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/admin/product/' + productId,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                    });
                    location.reload();
                }
            });
        });
    </script>
@endsection
