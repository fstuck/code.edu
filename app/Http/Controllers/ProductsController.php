<?php

namespace CodeCommerce\Http\Controllers;

use Illuminate\Http\Request;
use CodeCommerce\product;
use CodeCommerce\category;

use CodeCommerce\Http\Requests;
use CodeCommerce\Http\Controllers\Controller;

class ProductsController extends Controller
{
    private $productModel;
    
    public function __construct(Product $productModel) 
    {
        $this->productModel = $productModel;
                
    }


    public function index()
    {
        $products = $this->productModel->paginate(10);
        $products->setPath('/laravel_commerce/public/admin/products');//resolver problema de document root
        return view('products.index',  compact('products'));
    }

    public function create(Category $category)
    {

        //$categories = $category->all();
        $categories = $category->lists('name','id');

        return view('products.create', compact('categories'));
    }
    
    public function store(Requests\ProductRequest $request)
    {
        $input = $request->all();
        $product = $this->productModel->fill($input);
        $product->save();
        return redirect('admin/products');
    }
    public function edit($id, Category $category)
    {
        $categories = $category->lists('name','id');
        $product = $this->productModel->find($id);
        return view('products.edit',compact('product','categories'));
        
    }
    public function update(Requests\ProductRequest $request, $id)
    {
        $this->productModel->find($id)->update($request->all());
        return redirect('admin/products');
    }
    public function destroy($id)
    {
        $this->productModel->find($id)->delete();
        return redirect('admin/products');
    }
    public function images($id){
        $product = $this->model->find($id);
        return view('products_images', compact('product'));
    }
}