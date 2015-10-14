<?php

namespace CodeCommerce\Http\Controllers;

use Illuminate\Http\Request;
use CodeCommerce\product;
use CodeCommerce\category;
use CodeCommerce\ProductImage;

use CodeCommerce\Http\Requests;
use CodeCommerce\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $product = $this->productModel->find($id);
        return view('products.image', compact('product'));
    }
    public function createImage($id){
        $product = $this->productModel->find($id);
        return view('products.create_image', compact('product'));
    }
    public function storeImage(Requests\ProductImageRequest $request, $id, ProductImage $productImage){
        $file = $request->file('image');//pega a imagem
        $extension = $file->getClientOriginalExtension();//pega a extensão
        $imagem = $productImage::create(['product_id'=>$id,'extension'=>$extension]);//cria a imagem no banco de dados
        Storage::disk('public_local')->put($imagem->id.'.'.$extension,File::get($file));//guarda a imagem no disco do servidor
        return redirect()->route('products.images',['id'=>$id]);
    }
    public function destroyImage(ProductImage $productImage, $id){
        $image = $productImage->find($id);
        if(file_exists(public_path().'/uploads/'.$image->id.'.'.$image->extension)){
            Storage::disk('public_local')->delete($image->id.'.'.$image->extension);
        }
        $product = $image->product;//para fazer o redirecionamento
        $image->delete();
        return redirect()->route('products.images',['id'=>$product->id]);
    }
}