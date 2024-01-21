@extends('layout.master')

@section('header-text', 'Register')

@section('content')
    <div class="container">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header bg-success text-center text-white">Register</div>
                <div class="card-body">
                    <form action="{{ url('/register') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Enter Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Enter Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Enter Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Enter Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Enter Phone Number</label>
                            <input type="number" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Enter Address</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>
                        <input type="submit" value="Register" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
