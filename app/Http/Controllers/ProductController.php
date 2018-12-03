<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Model\Product;
use app\Model\Province;
use app\Model\Ivatype;
use app\Model\Producttype;
use app\Model\Unittype;
use app\Model\Trademark;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) 
        {
            $products = Product::where('product', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $products  = Product::latest()->paginate($perPage);
        }

        $title      = 'Listado de productos';
        $modelName  = 'Producto';
        $controller = 'products';

        return view('products.index',compact('products', 'title', 'modelName', 'controller'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title      = 'Editar un producto';
        $modelName  = 'Producto';
        $controller = 'products';
        $producttypes = Producttype::pluck('producttype','id');
        $unittypes = Unittype::pluck('unittype','id');
        $ivatypes = Ivatype::pluck('ivatype','id');
        $trademarks = Trademark::pluck('trademark','id');

        return view('products.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'unittypes',
            'producttypes',
            'ivatypes',
            'trademarks'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code'          => 'required|unique:products|max:32',
            'product'       => 'required|max:32',
            'ivatype_id'    => 'required',
            'producttype_id'=> 'required'
            ]);
    
        $requestData = $request->all();
        Product::create($requestData);

        return redirect('products')->with('flash_message', 'Producto creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un producto';
        $modelName  = 'Producto';
        $controller = 'products';

        $product = Product::findOrFail($id);
        return view('products.show', compact('product','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un producto';
        $modelName  = 'Producto';
        $controller = 'products';

        $product = Product::findOrFail($id);
        $producttypes = Producttype::pluck('producttype','id');
        $unittypes = Unittype::pluck('unittype','id');
        $ivatypes = Ivatype::pluck('ivatype','id');
        $trademarks = Trademark::pluck('trademark','id');

        return view('products.edit', compact(
            'product',
            'title', 
            'modelName', 
            'controller', 
            'unittypes',
            'producttypes',
            'ivatypes',
            'trademarks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        
        $product = Product::findOrFail($id);
        $product->update($requestData);

        return redirect('products')->with('flash_message', 'Producto actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return redirect('products')->with('flash_message', 'Producto eliminado!');
    }
}
