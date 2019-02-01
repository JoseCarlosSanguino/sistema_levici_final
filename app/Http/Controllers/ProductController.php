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
        $data = Product::select("id","code","product", "price","cost", "stock","ivatype_id", DB::raw('CONCAT(code," - ",  product) AS name'))
            ->with(['cylindertypes','ivatype', 'trademark'])
            ->orWhere("product","LIKE","%{$request->input('query')}%")
            ->orWhere("code","LIKE","%{$request->input('query')}%")
            ->get();
        return response()->json($data);
    }

    /*
    public function autocomplete(Request $request)
    {
        $keyword = $request->input('query');

        //productos
        $query = "SELECT p.id, p.code, p.product, p.price, p.stock, p.ivatype_id, i.percent, p.description,  ";
        $query.= "CONCAT(code, ' - ' , COALESCE(t.trademark,''), ' ', p.product) as name ";
        $query.= "FROM products p LEFT JOIN trademarks t on t.id = p.trademark_id JOIN ivatypes i on i.id = p.ivatype_id ";
        $query.= "WHERE (p.code like '%{$keyword}%' OR p.product like '%{$keyword}%' OR t.trademark like '%{$keyword}%') ";
     
        $rows = DB::select($query);

        //cilindros
        $query = "SELECT c.id, c.code, ct.cylindertype, ct.capacity, p.price ";
        $query.= " FROM cylinders c JOIN cylindertypes ct on ct.id = c.cylindertype_id ";
        $query.= " LEFT JOIN cylindertype_product cp ON cp.cylindertype_id = c.cylindertype_id ";
        $query.= " LEFT JOIN products p on p.id = cp.product_id ";
        $query.= " WHERE c.status_id = " . Cylinder::STATUS['DISPONIBLE'] . " ";
        $query.= " AND (c.code LIKE '%{$keyword}%' OR ct.cylindertype LIKE '%{$keyword}%' )";

        $cyls = DB::select($query);


        return response()->json($rows);
    }
    */
}
