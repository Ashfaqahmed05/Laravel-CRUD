@extends('layouts.app')

@section('content')

    <div class="bg-dark py-3 px-3 ">
        <h1 class="text-white text-center">Laravel Crud</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-8">
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <input class="form-control " type="text" name="search" id="search-bar" placeholder="Search"
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search text-light"></i>
                    </button>
                </form>
            </div>
            <div class="col-2 d-flex justify-content-end">
                <a href="{{ route('products.create') }}" class="btn btn-dark">Create</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
                <div class="col-md-10 my-3">
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                </div>
            @endif
            <div class="col-md-10">
                <div class="card my-4 border-0 shadow-lg ">
                    <div class="card-header bg-dark text-white">
                        <h3>Products</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @if ($product->image != '')
                                                <img width="50px" src="{{ asset('uploads/products/' . $product->image) }}"
                                                    alt="image">
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-dark">Edit</a>
                                            <a href="#" onclick="deleteProduct({{ $product->id }})"
                                                class="btn btn-danger">Delete</a>
                                            <form id="delete-product-form-{{ $product->id }}"
                                                action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </table>

                    </div>

                </div>
            </div>

        </div>

    </div>
    <script>
        function deleteProduct(id) {
            console.log(id);

            if (confirm("Are you sure you want to delete Product?")) {
                document.getElementById("delete-product-form-" + id).submit();
            }
        }
    </script>
@endsection
