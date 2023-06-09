<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use app\Models\Product;
use app\Models\Province;
use app\Models\Provider;
use app\Models\Ivatype;
use app\Models\Producttype;
use app\Models\Unittype;
use app\Models\Trademark;
use app\Models\Cylindertype;
use app\Models\Cylinder;

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
        $providers = Provider::where('persontype_id',2)->pluck('name','id');
        $cylindertypes = Cylindertype::pluck('cylindertype','id');
        $role = [];

        foreach(\Auth::user()->roles as $rol)
        {
            array_push($role, $rol->id);
        }

        return view('products.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'unittypes',
            'producttypes',
            'ivatypes',
            'trademarks',
            'providers',
            'cylindertypes',
            'role'
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
            'product'       => 'required|max:128',
            'ivatype_id'    => 'required',
            'producttype_id'=> 'required'
            ]);
    
        $requestData = $request->all();
        $product = Product::create($requestData);

        $product->providers()->detach();

        if ($request->has('providers')) {
            foreach ($request->providers as $provider_name) {
                $provider = Provider::findOrFail($provider_name);
                $product->giveProviderTo($provider);
            }
        }
        if($request->has('cylindertypes')){
            foreach ($request->cylindertypes as $cylindertype_name){
                $cylindertype = CylinderType::findOrFail($cylindertype_name);
                $product->giveCylindertypeTo($cylindertype);
            }
        }

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
        $providers = Provider::where('persontype_id',2)->pluck('name','id');
        $cylindertypes = Cylindertype::pluck('cylindertype','id');
        $role = [];

        foreach(\Auth::user()->roles as $rol)
        {
            array_push($role, $rol->id);
        }

        return view('products.edit', compact(
            'product',
            'title', 
            'modelName', 
            'controller', 
            'unittypes',
            'producttypes',
            'ivatypes',
            'trademarks',
            'providers',
            'cylindertypes',
            'role'));
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
        
        $product->providers()->detach();

        if ($request->has('providers')) {
            foreach ($request->providers as $provider_name) {
                $provider = Provider::findOrFail($provider_name);
                $product->giveProviderTo($provider);
            }
        }

        $product->cylindertypes()->detach();
        
        if($request->has('cylindertypes')){
            foreach ($request->cylindertypes as $cylindertype_name){
                $cylindertype = CylinderType::findOrFail($cylindertype_name);
                $product->giveCylindertypeTo($cylindertype);
            }
        }
        //return redirect()->back()->with('success', 'Producto actualizado! '); 
        $url = $request->only('redirects_to');
        return redirect()->to($url['redirects_to'])->with('flash_message', 'Producto actualizado!');
        //return redirect('products')->with('flash_message', 'Producto actualizado!');
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function autocomplete(Request $request)
    {
        if(!is_null($request->input('only_cylinder')))
        {
            $data = Product::has('cylindertypes')
                ->select("id","code","product", "price","cost", "stock","ivatype_id", DB::raw('CONCAT(code," - ",  product) AS name'))
                ->with(['cylindertypes','ivatype','trademark'])
                ->Where("product","LIKE","%{$request->input('query')}%")
                //->orWhere("code","LIKE","%{$request->input('query')}%")
                ->get();
        }
        else
        {
            $data = Product::select("id","code","product", "price","cost", "stock","ivatype_id", DB::raw('CONCAT(code," - ",  product) AS name'))
                ->with(['cylindertypes','ivatype', 'trademark'])
                ->orWhere("product","LIKE","%{$request->input('query')}%")
                ->orWhere("code","LIKE","%{$request->input('query')}%")
                ->get();
        }

        return response()->json($data);
    }


    /**
     * Aumento de precios por proveedor o categoria
     * 
     * @return \Illuminate\View\View
     */
    public function increase(Request $request)
    {

        $provider_id    = $request->get('provider_id');
        $producttype_id = $request->get('producttype_id');
        $perPage = 25;

        $products = [];
        if (!empty($provider_id) || !empty($producttype_id)) 
        {
            $products = Product::when($provider_id, function ($q) use ($provider_id) {
                            $q->WhereHas("providers", function($q) use ($provider_id){
                                $q->where('provider_id','=', $provider_id);
                            });
                        })
                        ->when($producttype_id, function ($q) use ($producttype_id) {
                                return $q->Where("producttype_id","=", $producttype_id );
                            })
                        ->latest()->paginate($perPage);
        }

        $title      = 'Aumento masivo de precios';
        $modelName  = 'Producto';
        $controller = 'products';

        $providers  = Provider::all()->pluck('name','id');
        $producttypes = Producttype::all()->pluck('producttype','id');

        return view('products.increase',compact('providers','producttypes','products', 'title', 'modelName', 'controller'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeIncrease(Request $request)
    {

        try{
        DB::beginTransaction();

            foreach($request->input('product_id') as $product_id)
            {
                $product = Product::find($product_id);
                if(!is_null($product) && $product->price > 0)
                {
                    $product->last_price = $product->price;
                    $product->price = round($product->price + (($product->price * $request->input('percent')) / 100), 2);
                    $product->save();
                }
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return redirect('increase')->with('flash_message', 'Error al actualizar!');
        }

        return redirect('increase')->with('flash_message', 'Actualización exitosa!');
    }


}
