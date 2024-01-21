@extends('admin.layout.master')

@section('product-transaction', 'nav-link nav-link active')

@section('content')
    <div>
        <a href="{{ url('/admin/add-transaction') }}" class="btn btn-success">Add Transactions</a>
        <a href="{{ url('/admin/remove-transaction') }}" class="btn btn-outline-success">Remove Transactions</a>
    </div>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Total Qty</th>
                <th>Description</th>
                <th>Removed Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
                <tr>
                    <td>
                        <img style="width: 100px" class="img-thumbnail" src="{{ asset('/images/' . $t->product->image) }}"
                            alt="">
                    </td>
                    <td>
                        {{ $t->product->name }}
                    </td>
                    <td>
                        {{ $t->total_quantity }}
                    </td>
                    <td>
                        {{ $t->description }}
                    </td>
                    <td>
                        {{ $t->created_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
@endsection
