<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('products'      , 'ProductController'       );
Route::resource('providers'     , 'ProviderController'      );
Route::resource('customers'     , 'CustomerController'      );
Route::resource('provinces'     , 'ProvinceController'      );
Route::resource('cities'        , 'CityController'          );
Route::resource('ivatypes'      , 'IvatypeController'       );

Route::resource('producttypes'  , 'ProducttypeController'   );
Route::resource('users'         , 'UserController'          );
Route::resource('roles'         , 'RoleController'          );
Route::resource('unittypes'     , 'UnittypeController'      );
Route::resource('trademarks'    , 'TrademarkController'     );
Route::resource('cylindertypes' , 'CylindertypeController'  );
Route::resource('cylinders'     , 'CylinderController'      );
Route::resource('permissions'   , 'PermissionController'    );

Route::resource('remitos'       , 'RemitoController'        );
Route::resource('facturas'		, 'SaleController'			);

/*
Route::get('remito','RemitoController@create')->defaults('slug', 'remito');
Route::get('remitos','SaleController@index')->defaults('type', 'remito');
Route::get('remitopdf/{id}','SaleController@remitoPDF');
*/
Route::get('remito','RemitoController@create')->defaults('slug', 'remito');
Route::get('factura','SaleController@create')->defaults('slug', 'factura');
Route::get('ctacte','CustomerController@ctacte')->defaults('slug', 'ctacte');
Route::get('customers/detallectacte/{id}', 'CustomerController@detallectacte')->defaults('slug','detallectacte');
Route::get('facturar/{id}', 'SaleController@facturarRemito');

//Impresiones
Route::get('remitopdf/{id}','RemitoController@remitoPDF');
Route::get('facturapdf/{id}','SaleController@salePDF');

Route::get('customerAutocomplete',array('as'=>'customerAutocomplete','uses'=>'CustomerController@autocomplete'));
Route::get('productAutocomplete',array('as'=>'productAutocomplete','uses'=>'ProductController@autocomplete'));

Route::get('nextNumber', array('as'=> 'nextNumber', 'uses' => 'OperationController@nextNumber'));
Route::get('nextSaleNumber', array('as'=> 'nextSaleNumber', 'uses' => 'OperationController@nextSaleNumber'));


Route::get('cityJson', array('as'=>'cityJson','uses'=>'CityController@json'));
Route::get('cylinderJson',array('as'=> 'cylinderJson', 'uses' => 'CylinderController@json'));

