<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Dashboard\StoreProductRequest;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:super|admin');
    }

    public function productIndex(Request $request): \Inertia\Response
    {

        return Inertia::render('products/product_index',[
            'products' => Product::query()->when($request->input('search'),
                function ($query, $search){
                    $query->where('id','like','%'.$search.'%')
                    ->OrWhere('name','like','%'.$search.'%')
                    ->OrWhere('quantity','like','%'.$search.'%')
                    ->OrWhere('brand','like','%'.$search.'%')
                    ->OrWhere('model','like','%'.$search.'%')
                    ->OrWhere('category','like','%'.$search.'%')
                    ->OrWhere('stock','like','%'.$search.'%')
                    ->OrWhere('price','like','%'.$search.'%');
                })->orderBy('id', 'desc')->paginate(8)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);

    }

    public function productCreateShow(): \Inertia\Response
    {
       return Inertia::render('products/product_create_form');
    }


    public function productStore(StoreProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        $product=Product::create($request->validated());
        $image=Storage::disk('products')->put($product->id, $request->file('image'));
        $product->forceFill([
            'image_url'=>$image
        ])->save();
        sleep(1);
        return to_route('dashboard.products');

    }

    public function productEditShow(int $id): \Inertia\Response
    {
       session()->put('product_id', $id);
       return Inertia::render('products/product_edit_form',[
            'product'=> Product::findOrFail($id)
       ]);
    }


    public function productUpdate(StoreProductRequest $request):  \Illuminate\Http\RedirectResponse
    {
        $id=session()->get('product_id');
        $product=Product::findOrFail($id);
        $product->update($request->validated());
        if(!empty($request->file('image'))){
            $image=Storage::disk('products')->put($product->id, $request->file('image'));
            $product->forceFill([
                'image_url '=> $image
           ])->save();
        }
        session()->forget('product_id');
        sleep(1);
        return to_route('dashboard.products');
    }




}
