<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        if(Gate::allows('view','products')) {
            $products = Product::paginate();

            return ProductResource::collection($products);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function show($id)
    {
        if(Gate::allows('view','products')) {
            return new ProductResource(Product::find($id));
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function store(ProductCreateRequest $request)
    {
        if(Gate::allows('edit','products')) {
            $product = Product::create($request->only('title','description','image','price'));

            return response($product, Response::HTTP_CREATED);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function update(Request $request, $id)
    {
        if(Gate::allows('edit','products')) {

            $product = Product::find($id);

            $product->update($request->only('title','description','image','price'));

            return response($product, Response::HTTP_ACCEPTED);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function destroy($id)
    {
        if(Gate::allows('edit','products')) {

            Product::destroy($id);
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }
}
