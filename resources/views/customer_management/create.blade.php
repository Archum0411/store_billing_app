@extends('layouts.app')
@section('css')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="container">
                <div class="d-flex justify-content-between">
                    <h2>Create User</h2>
                    <a href="{{ route('user.index') }}" class="btn btn-primary">Back</a>
                </div>
                <hr>

                <div id="stepper1" class="bs-stepper">
                    <div class="card">
                        <div class="card-body">

                            <div class="bs-stepper-content">
                                <form action="{{ route('customer.store') }}" method="POST">
                                    @csrf

                                    <div class="bs-stepper-pane mt-4">
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-6">
                                                <label for="customer_name" class="form-label">Customer Name</label>
                                                <input type="text" class="form-control" id="customer_name" name="customer_name"
                                                    placeholder="Customer Name" required value="{{ old('customer_name') }}">
                                                @error('customer_name')
                                                    <span style="color: red">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Email" required value="{{ old('email') }}">
                                                @error('email')
                                                    <span style="color: red">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-lg-12">
                                                <button class="btn btn-primary px-4">Submit <i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end stepper one-->
            </div>
        </div>
    </div>
@endsection
