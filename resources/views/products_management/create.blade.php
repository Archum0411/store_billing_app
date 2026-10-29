@extends('layouts.app')
@section('css')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="container">
                <div class="d-flex justify-content-between">
                    <h2>Create Product</h2>
                    <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
                </div>
                <hr>

                <div id="stepper1" class="bs-stepper">
                    <div class="card">
                        <div class="card-body">

                            <div class="bs-stepper-content">
                                <form action="{{ route('product.store') }}" method="POST">
                                    @csrf

                                    <div class="bs-stepper-pane mt-4">
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-6">
                                                <label for="product_name" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" id="product_name" name="product_name"
                                                    placeholder="Product Name" required value="{{ old('product_name') }}">
                                                @error('product_name')
                                                    <span style="color: red">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" step=".01" min=0.01 class="form-control" id="price" name="price"
                                                    placeholder="Price" required value="{{ old('price') }}">
                                                @error('price')
                                                    <span style="color: red">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="col-12 col-lg-6">
                                                <label for="tax_percentage" class="form-label">Tax Percentage</label>
                                                <input type="number" step=".01" min=0.01 class="form-control" id="tax_percentageta" name="tax_percentage"
                                                    placeholder="tax_percentage" required value="{{ old('tax_percentage') }}">
                                                @error('tax_percentage')
                                                    <span style="color: red">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label for="stock_on_hand" class="form-label">Stock ON Hand</label>
                                                <input type="number" class="form-control" id="stock_on_hand" name="stock_on_hand"
                                                    placeholder="stock_on_hand" required value="{{ old('stock_on_hand') }}">
                                                @error('stock_on_hand')
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

