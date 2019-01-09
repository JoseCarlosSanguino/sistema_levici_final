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

Route::resource('sales'         , 'SaleController'          );

Route::get('remito','SaleController@create');
Route::get('remitos','SaleController@index');
Route::get('remitopdf/{id}','SaleController@remitoPDF');

Route::get('customerAutocomplete',array('as'=>'customerAutocomplete','uses'=>'CustomerController@autocomplete'));
Route::get('productAutocomplete',array('as'=>'productAutocomplete','uses'=>'ProductController@autocomplete'));
Route::get('nextSaleNumber', array('as'=> 'nextSaleNumber', 'uses' => 'SaleController@nextNumber'));
Route::get('cityJson', array('as'=>'cityJson','uses'=>'CityController@json'));
Route::get('cylinderJson',array('as'=> 'cylinderJson', 'uses' => 'CylinderController@json'));

