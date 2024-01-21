@extends('admin.layout.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection {}
    </style>
@endsection
@section('content')
    <div class="mt-3">
        <a href="{{ route('product.index') }}" class="btn btn-secondary">All Products</a>
    </div>
    <hr>
    <form action="{{ route('product.update', $p->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-8">

                <div class="card p-4">
                    <small class="text-muted">Product Info</small>
                    <div class="form-group">
                        <label for="">Enter Product Name</label>
                        <input type="text" name="name" value="{{ $p->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Choose Product Image</label>
                        <input type="file" name="image" class="form-control">
                        <img src="{{ asset('/images/' . $p->image) }}" style="width: 200px" class="img-thumbnail"
                            alt="">
                    </div>
                    <div class="form-group">
                        <label for="">Enter Description</label>
                        <textarea name="description" id="description" class="form-control">{{ $p->description }}</textarea>
                    </div>
                </div>
                <div class="card p-4 mt-2">
                    <small class="text-muted">Product Pricing</small>
                    <div class="form-group">
                        <label for="">Total Quantity</label>
                        <input type="number" name="total_quantity" value="{{ $p->total_quantity }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Buy Price</label>
                        <input type="number" name="buy_price" value="{{ $p->buy_price }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Sale Price</label>
                        <input type="number" name="sale_price" value="{{ $p->sale_price }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Discount Price</label>
                        <input type="number" name="discounted_price" value="{{ $p->discount_price }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card p-4">
                    <label for="">Choose Supplier</label>
                    <select name="supplier_slug" id="supplier">
                        @foreach ($supplier as $s)
                            <option value="{{ $s->id }}" @if ($s->id == $p->supplier_id) selected @endif>
                                {{ $s->name }}</option>
                        @endforeach
                    </select>

                    <label for="" class="mt-4">Choose Category</label>
                    <select name="category_slug" id="category">
                        @foreach ($category as $c)
                            <option value="{{ $c->slug }}" @if ($c->id == $p->category_id) selected @endif>
                                {{ $c->name }}</option>
                        @endforeach
                    </select>


                    <label for="" class="mt-4">Choose Brand</label>
                    <select name="brand_slug" id="brand">
                        @foreach ($brand as $c)
                            <option value="{{ $c->slug }}" @if ($c->id == $p->brand_id) selected @endif>
                                {{ $c->name }}</option>
                        @endforeach
                    </select>


                    <label for="" class="mt-4">Choose Color</label>
                    <select name="color_slug[]" id="color" multiple>
                        @foreach ($color as $c)
                            <option value="{{ $c->slug }}"
                                @foreach ($p->colors as $pc)
                                    @if ($pc->id == $c->id)
                                        selected
                                    @endif @endforeach>
                                {{ $c->name }}</option>
                        @endforeach
                    </select>
                    <input type="submit" class="btn btn-primary mt-4" value="Update">
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#supplier').select2();
            $('#category').select2();
            $('#brand').select2();
            $('#color').select2();

            $('#description').summernote({
                callbacks: {
                    onImageUpload: function(files) {
                        var frmData = new FormData();
                        frmData.append('image', files[0]);
                        frmData.append('_token', "@php echo csrf_token(); @endphp")
                        $.ajax({
                            method: 'POST',
                            url: '/admin/product-upload',
                            contentType: false,
                            processData: false,
                            data: frmData,
                            success: function(data) {
                                $('#description').summernote('insertImage', data)
                            }
                        })
                    }
                }
            });
        });
    </script>
@endsection
