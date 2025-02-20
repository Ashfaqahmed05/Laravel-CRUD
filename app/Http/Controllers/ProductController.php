<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class productController extends Controller {
    // This method will show products page

    public function index(Request $request) {
        $search = $request->input('search', '');
    
        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->orderBy('created_at', 'DESC')->get();
    
        return view('products.list', ['products' => $products]);
    }

    // This method will show create product page

    public function create() {
        return view( 'products.create' );
    }

    // THis method will show the store product in DB

    public function store( Request $request ) {
        $rules = [
            'name' => 'required|min:5',
            'sku'  => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ( $request->image != '' ) {
            $rules[ 'image' ] = 'image';
        }

        $validator = Validator::make( $request -> all(), $rules );

        if ( $validator->fails() ) {
            return redirect()->route( 'products.create' )->withInput()->withErrors( $validator );
        }
        // Now insert value in DB

        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ( $request->image != '' ) {
            // Here store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;  //unique image name

            // Save image to public directory
            $image->move( public_path( 'uploads/products' ), $imageName );

            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route( 'products.index' )->with( 'success', 'Product Added Successfully' );

    }

    // THis method will show the edit product page

    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }

    // THis method will show update the product in DB

    public function update($id, Request $request) {
        $product = Product::findOrFail($id);

        $rules = [
            'name' => 'required|min:5',
            'sku'  => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ( $request->image != '' ) {
            $rules[ 'image' ] = 'image';
        }

        $validator = Validator::make( $request -> all(), $rules );

        if ( $validator->fails() ) {
            return redirect()->route( 'products.edit', $product->id )->withInput()->withErrors( $validator );
        }
        // Now update value in DB

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->name = $request->name;
        $product->save();

        if ( $request->image != '' ) {
            // first delete image 
            File::delete(public_path('uploads/products/'.$product->image));
            // Here store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            //unique image name

            // Save image to public directory
            $image->move( public_path( 'uploads/products' ), $imageName );

            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route( 'products.index' )->with( 'success', 'Product Updated Successfully' );


    }
    // THis method will show delete the product in DB

    public function destroy($id) {
        $product = Product::findOrFail($id);

        // delete image
        File::delete(public_path('uploads/Products/'.$product->image));

        // delete product from data base
        $product->delete();

        return redirect()->route( 'products.index' )->with( 'success', 'Product Deleted Successfully' );

    }
}
