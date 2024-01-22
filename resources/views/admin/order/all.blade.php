@extends('admin.layout.master')

@section('content')
    <div class="mt-3">
        <a href="{{ url('/admin/order') }}" class="btn btn-dark">All</a>
    </div>
    <hr>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Status</th>
                <th>User Info</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order as $o)
                <tr>
                    <td>
                        <img src="{{ url('/images/' . $o->product->image) }}" style="width: 40px" alt="">
                    </td>
                    <td>
                        {{ $o->product->name }}
                    </td>
                    <td>
                        {{ $o->total_quantity }}
                    </td>
                    <td>
                        {{ $o->product->sale_price }}
                    </td>
                    <td>
                        @if ($o->status === 'success')
                            <span class="badge badge-success">Success</span>
                        @endif
                        @if ($o->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @endif
                        @if ($o->status === 'cancel')
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </td>
                    <td>
                        <table class="table border">
                            <tr>
                                <td>Image</td>
                                <td>Name</td>
                                <td>Phone</td>
                                <td>Address</td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ url('/images/' . $o->user->image) }}" style="width: 40px" alt="">
                                </td>
                                <td>{{ $o->user->name }}</td>
                                <td>{{ $o->user->phone }}</td>
                                <td>{{ $o->user->address }}</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <a href="" class="btn btn-success">Success</a>
                        <a href="" class="btn btn-danger">Cancel</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $order->links() }}
@endsection
