<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*get requests*/
Route::get('/', 'ViewController@dashboard');

Route::get('/dashboard', 'ViewController@dashboard');
    
Route::get('/customers', 'ViewController@customers');

Route::get('/vehicles', 'ViewController@vehicles');

Route::get('/drivers', 'ViewController@drivers');

Route::get('/companies', 'ViewController@companies');

Route::get('/products', 'ViewController@products');

Route::get('/addOrder', 'ViewController@addOrder');

Route::get('/customerZones', 'ViewController@customerZones');

Route::get('/vehicleZones', 'ViewController@vehicleZones');

Route::get('/register', 'ViewController@register');
   
Route::get('/login', function () {
    return view('login',['message' => '']);
});

/*place an order*/
Route::get('/placeOrder', 'OrderController@placeOrder');

/*place an order*/
Route::get('/test', 'OrderController@test');

/*get product in order*/
Route::get('/getProduct/{product_id}', 'ProductController@getProduct');

/*get order details*/
Route::get('/getOrderDetails/{order_code}', 'OrderController@getOrderDetails');

/*authenticates an user*/
Route::get('/doLogout','UserController@doLogout');

/*generating invoice for order id*/
Route::get('/invoice/{order_code}','OrderController@generateInvoice');

/*view all orders*/
Route::get('/allOrders/{option}/{active_tab}','OrderController@getAllOrders');

/*get delivered Orders*/
Route::get('/deliverdOrders/{option}/{active_tab}','OrderController@getDeliverdOrders');

/*get not yet delivered Orders*/
Route::get('/notDeliveredOrders/{option}/{active_tab}','OrderController@getNotDeliveredOrders');

/*view damaged orders*/
Route::get('/damagedProducts','ViewController@damagedProducts');

/*get customer zone vehicles*/
Route::get('/getCustomerZoneVehicles/{customer_id}','VehicleController@getCustomerZoneVehicles');

/*get payments for a order*/
Route::get('/getOrderPayments/{order_code}','OrderController@getOrderPayments');

/*reset all vehicles*/
Route::get('/resetAllVehicles','VehicleController@resetAllVehicles');

/*assign vehicle to a customer zone*/
Route::get('/assignVehicleToCustomerZone/{vehicle_id}/{customer_zone_id}','VehicleController@assignVehicleToCustomerZone');

/*get orders of a product*/
Route::get('/getProductOrders/{product_id}','OrderController@getProductOrders');

/*get filtered orders of a product*/
Route::get('/getProductOrders/{start_date}/{end_date}/{product_id}','OrderController@getFilteredProductOrders');

/*get stock ins of a product*/
Route::get('/getStockInReports/{product_id}','ProductController@getStockInReports');

/*get filtered stock ins of a product*/
Route::get('/getStockInReports/{start_date}/{end_date}/{product_id}','ProductController@getFilteredStockInReports');

/*add damaged Product*/
Route::get('/addNewDamagedProducts','ProductController@addNewDamagedProducts');

/*get Customer Orders*/
Route::get('/getCustomerOrders/{customer}','OrderController@getCustomerOrders');

/*get details for view Orders*/
Route::get('/viewOrder/{order_code}','OrderController@viewOrder');

/*reset password*/
Route::get('/resetPassword','UserController@resetPassword');

/*view recent orders*/
Route::get('/viewRecentOrders','OrderController@viewRecentOrders');

/*update seen by cashier*/
Route::get('/updateSeenByCashier','OrderController@updateSeenByCashier');

/*view reports*/
Route::get('/reports/{option}','OrderController@reports');

/*driver_tracking*/
Route::get('/driver_tracking/{start_date}/{end_date}','OrderController@driver_tracking');

/*view users*/
Route::get('/users','UserController@viewUsers');

/*delete customer*/
Route::get('/delete_customer','CustomerController@deleteCustomer');

/*delete vehicle*/
Route::get('/delete_vehicle','VehicleController@deleteVehicle');

/*delete driver*/
Route::get('/delete_driver','DriverController@deleteDriver');

/*delete product*/
Route::get('/delete_product','ProductController@deleteProduct');

/*delete Company*/
Route::get('/delete_company','CompanyController@deleteCompany');

/*delete Customer Zone*/
Route::get('/delete_customer_zone','ZoneController@deleteCustomerZone');

/*delete Vehicle Zone*/
Route::get('/delete_vehicle_zone','ZoneController@deleteVehicleZone');

/*delete user*/
Route::get('/delete_user','UserController@deleteUser');

/*delete damaged product*/
Route::get('/deleteDamagedProduct','ProductController@deleteDamagedProduct');

/*get customer by id*/
Route::get('/getCustomerById/{customer_id}','CustomerController@getCustomerById');

/*get vehicle by id*/
Route::get('/getVehicleById/{vehicle_id}','VehicleController@getVehicleById');

/*get driver by id*/
Route::get('/getDriverById/{driver_id}','DriverController@getDriverById');

/*get product by id*/
Route::get('/getProductById/{product_id}','ProductController@getProductById');

/*get Company by id*/
Route::get('/getCompanyById/{company_id}','CompanyController@getCompanyById');

/*get User by id*/
Route::get('/getUserById/{user_id}','UserController@getUserById');

/*get Damaged Product by id*/
Route::get('/getDamagedProductById/{product_id}','ProductController@getDamagedProductById');

/*test customer zone*/
Route::get('/customerZones1','ViewController@customerZones1');

/*get products on order*/
Route::get('/productsOnOrder/{order_code}','OrderController@productsOnOrder');

/*get product deliveries*/
Route::get('/getProductDeliveries/{order_code}','OrderController@getProductDeliveries');

Route::get('/{any}', function () {
	 return Redirect::to('/login');
});

/*post requests*/
/*adding customer zone*/
Route::post('/addCustomerZone','ZoneController@addCustomerZone');

/*adding vehicle zone*/
Route::post('/addVehicleZone','ZoneController@addVehicleZone');

/*register an user*/
Route::post('/doRegister','UserController@doRegister');

/*authenticates an user*/
Route::post('/doLogin','UserController@doLogin');

/*add a customer*/
Route::post('/addCustomer','CustomerController@addCustomer');

/*add a driver*/
Route::post('/addDriver','DriverController@addDriver');

/*add a vehicle*/
Route::post('/addVehicle','VehicleController@addVehicle');

/*add a company*/
Route::post('/addCompany','CompanyController@addCompany');

/*add a company*/
Route::post('/addProduct','ProductController@addProduct');

/*submit delivery*/
Route::post('/addDelivery','OrderController@addDelivery');

/*submit payment*/
Route::post('/addPayment','OrderController@addPayment');

/*add Stock for Existing Product*/
Route::post('/addStockExistingProduct','ProductController@addStockExistingProduct');

/*add existing product damages*/
Route::post('/addExistingDamaged','ProductController@addExistingDamaged');

/*add new product damages*/
Route::post('/addNewDamagedProducts','ProductController@addNewDamagedProducts');

/*check password*/
Route::post('/checkPassword','UserController@checkPassword');

/*set new password*/
Route::post('/setNewPassword','UserController@setNewPassword');

/*edit customer*/
Route::post('/editCustomer','CustomerController@editCustomer');

/*edit vehicle*/
Route::post('/editVehicle','VehicleController@editVehicle');

/*edit driver*/
Route::post('/editDriver','DriverController@editDriver');

/*edit Product*/
Route::post('/editProduct','ProductController@editProduct');

/*edit Company*/
Route::post('/editCompany','CompanyController@editCompany');

/*edit Customer ZOne*/
Route::post('/editCustomerZone','ZoneController@editCustomerZone');

/*edit Vehicle ZOne*/
Route::post('/editVehicleZone','ZoneController@editVehicleZone');

/*edit User*/
Route::post('/editUser','UserController@editUser');

/*edit damaged product*/
Route::post('/editDamagedProduct','ProductController@editDamagedProduct');











