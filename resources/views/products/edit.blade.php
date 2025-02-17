@extends('layouts.app')

@section('content')
    <div class="bg-dark py-3 px-3 ">
        <h1 class="text-white text-center">Laravel Crud</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center   ">
            <div class="col-md-10">
                <div class="card my-4 border-0 shadow-lg ">
                    <div class="card-header bg-dark text-white">
                        <h3>Edit Product</h3>
                    </div>
                    <form enctype="multipart/form-data" action="{{ route('products.update', $product->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class= "mb-3">
                                <label for="" class="form-label h4">Name:</label>
                                <input value="{{ old('name', $product->name) }}" type="text"
                                    class="@error('name') is-invalid @enderror form-control form-control-lg"
                                    placeholder="Name" name="name">
                                @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class= "mb-3">
                                <label for="" class="form-label h4">SKU:</label>
                                <input value="{{ old('sku', $product->sku)}}" type="text"
                                    class="@error('sku') is-invalid @enderror form-control form-control-lg"
                                    placeholder="SKU" name="sku">
                                @error('sku')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class= "mb-3">
                                <label for="" class="form-label h4">Price:</label>
                                <input value="{{ old('price', $product->price) }}" type="number"
                                    class="@error('price') is-invalid @enderror form-control form-control-lg"
                                    placeholder="Price" name="price">
                                @error('price')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class= "mb-3">
                                <label for="" class="form-label h4">Description:</label>
                                <textarea name="description" class="form-control" cols="30" rows="5">
                                    {{ old('description', $product->description) }}
                        </textarea>
                            </div>
                            <div class= "mb-3">
                                <label for="" class="form-label h4">Image:</label>
                                <input type="file" class="form-control form-control-lg" name="image">
                                @if ($product->image != '')
                                    <img class="w-50" src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="image">
                                @endif
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-lg btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
