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

Route::get('/home', 'HomeController@index')->name('Inicio');

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
Route::resource('budgets'		, 'BudgetController'		);
Route::resource('purchases'		, 'PurchaseController'	    );

Route::resource('payorders'		, 'PayorderController'	    );
Route::resource('receives'		, 'ReceiveController'	    );
Route::resource('payorders'		, 'PayorderController'	    );
Route::resource('paychecks'		, 'PaycheckController'	    );

Route::resource('remitosprov'	,  'RemitoprovController'	);
Route::resource('receptions'	,  'ReceptionController'	);


Route::get('paychecks/discount/{id}'	, 'PaycheckController@discount');
Route::get('remito','RemitoController@create')->defaults('slug', 'remito');
Route::get('factura','SaleController@create')->defaults('slug', 'factura');
Route::get('ctacte','CustomerController@ctacte')->defaults('slug', 'ctacte');
Route::get('customers/detallectacte/{id}', 'CustomerController@detallectacte')->defaults('slug','detallectacte');
Route::get('facturar/{id}', 'SaleController@facturarRemito');
Route::get('rechazarPresupuesto/{id}', 'BudgetController@rechazar');
Route::get('purchase', 'PurchaseController@create');
Route::get('budget'  , 'BudgetController@create' );

Route::get('increase', 'ProductController@increase');
Route::post('storeIncrease', 'ProductController@storeIncrease');

Route::get('remito_anular/{id}', 'RemitoController@remitoAnular');
Route::get('detail_purchase/{id}', 'PurchaseController@detailPurchase');
Route::get('customers/ctactepdf/{id}', 'CustomerController@ctactepdf');

//Impresiones
Route::get('remitopdf/{id}','RemitoController@remitoPDF');
Route::get('receivepdf/{id}','ReceiveController@reciboPDF');
Route::get('payorderpdf/{id}','PayorderController@ordenPDF');
Route::get('facturapdf/{id}','SaleController@salePDF');
Route::get('presupdf/{id}', 'BudgetController@presupuestoPDF');

Route::get('customerAutocomplete'	, array('as' => 'customerAutocomplete'	,'uses' => 'CustomerController@autocomplete'));
Route::get('productAutocomplete' 	, array('as' => 'productAutocomplete'	,'uses' => 'ProductController@autocomplete'));
Route::get('providerAutocomplete'	, array('as' => 'providerAutocomplete'	,'uses' => 'ProviderController@autocomplete'));


Route::get('nextNumber', array('as'=> 'nextNumber', 'uses' => 'OperationController@nextNumber'));
Route::get('nextSaleNumber', array('as'=> 'nextSaleNumber', 'uses' => 'OperationController@nextSaleNumber'));

Route::get('cityJson', 		array('as' => 'cityJson'		,	'uses' => 'CityController@json'));
Route::get('cylinderJson',	array('as' => 'cylinderJson'	, 	'uses' => 'CylinderController@json'));
Route::get('saleJson', 		array('as' => 'saleJson' 		, 	'uses' => 'SaleController@json'));
Route::get('purchaseJson', 	array('as' => 'purchaseJson' 	, 	'uses' => 'PurchaseController@json'));
Route::get('paycheckJson', 	array('as' => 'paycheckJson'	, 	'uses' => 'PaycheckController@json'));

