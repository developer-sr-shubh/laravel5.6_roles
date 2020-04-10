<?php
Route::get('/', function () { return redirect('/admin/dashboard'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index');
    Route::get('/admin/home', 'HomeController@index');

    Route::resource('/admin/permissions', 'Admin\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);



    // BO : Ambulance
    Route::post("/admin/ambulance/deleteAll", [ 'as'=>'admin.ambulance.deleteAll','uses'=>'admin\AmbulanceController@deleteAll','middleware' => ['permission:item-delete']]);
    Route::get("/admin/ambulance", [ 'as'=>'admin.ambulance.index','uses'=>'admin\AmbulanceController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
    Route::get("/admin/ambulance/add", [ 'as'=>'admin.ambulance.add','uses'=>'admin\AmbulanceController@getAdd','middleware' => ['permission:item-create']]);
    Route::post("/admin/ambulance/add", [ 'as'=>'admin.ambulance.add','uses'=>'admin\AmbulanceController@postAdd','middleware' => ['permission:item-create']]);
    Route::get("/admin/ambulance/edit/{id}", [ 'as'=>'admin.ambulance.edit','uses'=>'admin\AmbulanceController@getEdit','middleware' => ['permission:item-edit']]);
    Route::get("/admin/ambulance/status/{field}/{id}", [ 'as'=>'admin.ambulance.edit','uses'=>'admin\AmbulanceController@status','middleware' => ['permission:item-edit']]);
    Route::get("/admin/ambulance/export/{type}", [ 'as'=>'admin.ambulance.edit','uses'=>'admin\AmbulanceController@getExport','middleware' => ['permission:item-list']]);
    Route::post("/admin/ambulance/edit", [ 'as'=>'admin.ambulance.edit','uses'=>'admin\AmbulanceController@postEdit','middleware' => ['permission:item-edit']]);
    Route::post("/admin/ambulance/delete", [ 'as'=>'admin.ambulance.delete','uses'=>'admin\AmbulanceController@delete','middleware' => ['permission:item-delete']]);
    Route::get("/admin/ambulance/view/{id}", [ 'as'=>'admin.ambulance.edit','uses'=>'admin\AmbulanceController@view','middleware' => ['permission:item-list']]);
    // EO : Ambulance



    // BO : Blood_type
    Route::post("/admin/blood_type/deleteAll", [ 'as'=>'admin.blood_type.deleteAll','uses'=>'admin\Blood_typeController@deleteAll','middleware' => ['permission:item-delete']]);
    Route::get("/admin/blood_type", [ 'as'=>'admin.blood_type.index','uses'=>'admin\Blood_typeController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
    Route::get("/admin/blood_type/add", [ 'as'=>'admin.blood_type.add','uses'=>'admin\Blood_typeController@getAdd','middleware' => ['permission:item-create']]);
    Route::post("/admin/blood_type/add", [ 'as'=>'admin.blood_type.add','uses'=>'admin\Blood_typeController@postAdd','middleware' => ['permission:item-create']]);
    Route::get("/admin/blood_type/edit/{id}", [ 'as'=>'admin.blood_type.edit','uses'=>'admin\Blood_typeController@getEdit','middleware' => ['permission:item-edit']]);
    Route::get("/admin/blood_type/status/{field}/{id}", [ 'as'=>'admin.blood_type.edit','uses'=>'admin\Blood_typeController@status','middleware' => ['permission:item-edit']]);
    Route::get("/admin/blood_type/export/{type}", [ 'as'=>'admin.blood_type.edit','uses'=>'admin\Blood_typeController@getExport','middleware' => ['permission:item-list']]);
    Route::post("/admin/blood_type/edit", [ 'as'=>'admin.blood_type.edit','uses'=>'admin\Blood_typeController@postEdit','middleware' => ['permission:item-edit']]);
    Route::post("/admin/blood_type/delete", [ 'as'=>'admin.blood_type.delete','uses'=>'admin\Blood_typeController@delete','middleware' => ['permission:item-delete']]);
    Route::get("/admin/blood_type/view/{id}", [ 'as'=>'admin.blood_type.edit','uses'=>'admin\Blood_typeController@view','middleware' => ['permission:item-list']]);
    // EO : Blood_type



    // BO : Pets
    Route::post("/admin/pets/deleteAll", [ 'as'=>'admin.pets.deleteAll','uses'=>'admin\PetsController@deleteAll','middleware' => ['permission:item-delete']]);
    Route::get("/admin/pets", [ 'as'=>'admin.pets.index','uses'=>'admin\PetsController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
    Route::get("/admin/pets/add", [ 'as'=>'admin.pets.add','uses'=>'admin\PetsController@getAdd','middleware' => ['permission:item-create']]);
    Route::post("/admin/pets/add", [ 'as'=>'admin.pets.add','uses'=>'admin\PetsController@postAdd','middleware' => ['permission:item-create']]);
    Route::get("/admin/pets/edit/{id}", [ 'as'=>'admin.pets.edit','uses'=>'admin\PetsController@getEdit','middleware' => ['permission:item-edit']]);
    Route::get("/admin/pets/status/{field}/{id}", [ 'as'=>'admin.pets.edit','uses'=>'admin\PetsController@status','middleware' => ['permission:item-edit']]);
    Route::get("/admin/pets/export/{type}", [ 'as'=>'admin.pets.edit','uses'=>'admin\PetsController@getExport','middleware' => ['permission:item-list']]);
    Route::post("/admin/pets/edit", [ 'as'=>'admin.pets.edit','uses'=>'admin\PetsController@postEdit','middleware' => ['permission:item-edit']]);
    Route::post("/admin/pets/delete", [ 'as'=>'admin.pets.delete','uses'=>'admin\PetsController@delete','middleware' => ['permission:item-delete']]);
    Route::get("/admin/pets/view/{id}", [ 'as'=>'admin.pets.edit','uses'=>'admin\PetsController@view','middleware' => ['permission:item-list']]);
    // EO : Pets



    // BO : Pet_types
    Route::post("/admin/pet_types/deleteAll", [ 'as'=>'admin.pet_types.deleteAll','uses'=>'admin\Pet_typesController@deleteAll','middleware' => ['permission:item-delete']]);
    Route::get("/admin/pet_types", [ 'as'=>'admin.pet_types.index','uses'=>'admin\Pet_typesController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
    Route::get("/admin/pet_types/add", [ 'as'=>'admin.pet_types.add','uses'=>'admin\Pet_typesController@getAdd','middleware' => ['permission:item-create']]);
    Route::post("/admin/pet_types/add", [ 'as'=>'admin.pet_types.add','uses'=>'admin\Pet_typesController@postAdd','middleware' => ['permission:item-create']]);
    Route::get("/admin/pet_types/edit/{id}", [ 'as'=>'admin.pet_types.edit','uses'=>'admin\Pet_typesController@getEdit','middleware' => ['permission:item-edit']]);
    Route::get("/admin/pet_types/status/{field}/{id}", [ 'as'=>'admin.pet_types.edit','uses'=>'admin\Pet_typesController@status','middleware' => ['permission:item-edit']]);
    Route::get("/admin/pet_types/export/{type}", [ 'as'=>'admin.pet_types.edit','uses'=>'admin\Pet_typesController@getExport','middleware' => ['permission:item-list']]);
    Route::post("/admin/pet_types/edit", [ 'as'=>'admin.pet_types.edit','uses'=>'admin\Pet_typesController@postEdit','middleware' => ['permission:item-edit']]);
    Route::post("/admin/pet_types/delete", [ 'as'=>'admin.pet_types.delete','uses'=>'admin\Pet_typesController@delete','middleware' => ['permission:item-delete']]);
    Route::get("/admin/pet_types/view/{id}", [ 'as'=>'admin.pet_types.edit','uses'=>'admin\Pet_typesController@view','middleware' => ['permission:item-list']]);
    // EO : Pet_types



    // BO : Vaccination
    Route::post("/admin/vaccination/deleteAll", [ 'as'=>'admin.vaccination.deleteAll','uses'=>'admin\VaccinationController@deleteAll','middleware' => ['permission:item-delete']]);
    Route::get("/admin/vaccination", [ 'as'=>'admin.vaccination.index','uses'=>'admin\VaccinationController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
    Route::get("/admin/vaccination/add", [ 'as'=>'admin.vaccination.add','uses'=>'admin\VaccinationController@getAdd','middleware' => ['permission:item-create']]);
    Route::post("/admin/vaccination/add", [ 'as'=>'admin.vaccination.add','uses'=>'admin\VaccinationController@postAdd','middleware' => ['permission:item-create']]);
    Route::get("/admin/vaccination/edit/{id}", [ 'as'=>'admin.vaccination.edit','uses'=>'admin\VaccinationController@getEdit','middleware' => ['permission:item-edit']]);
    Route::get("/admin/vaccination/status/{field}/{id}", [ 'as'=>'admin.vaccination.edit','uses'=>'admin\VaccinationController@status','middleware' => ['permission:item-edit']]);
    Route::get("/admin/vaccination/export/{type}", [ 'as'=>'admin.vaccination.edit','uses'=>'admin\VaccinationController@getExport','middleware' => ['permission:item-list']]);
    Route::post("/admin/vaccination/edit", [ 'as'=>'admin.vaccination.edit','uses'=>'admin\VaccinationController@postEdit','middleware' => ['permission:item-edit']]);
    Route::post("/admin/vaccination/delete", [ 'as'=>'admin.vaccination.delete','uses'=>'admin\VaccinationController@delete','middleware' => ['permission:item-delete']]);
    Route::get("/admin/vaccination/view/{id}", [ 'as'=>'admin.vaccination.edit','uses'=>'admin\VaccinationController@view','middleware' => ['permission:item-list']]);
    // EO : Vaccination



    // BO : Register_user
    Route::post("/admin/register_user/deleteAll", [ 'as'=>'admin.register_user.deleteAll','uses'=>'admin\Register_userController@deleteAll','middleware' => ['permission:item-delete']]);
    Route::get("/admin/register_user", [ 'as'=>'admin.register_user.index','uses'=>'admin\Register_userController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
    Route::get("/admin/register_user/add", [ 'as'=>'admin.register_user.add','uses'=>'admin\Register_userController@getAdd','middleware' => ['permission:item-create']]);
    Route::post("/admin/register_user/add", [ 'as'=>'admin.register_user.add','uses'=>'admin\Register_userController@postAdd','middleware' => ['permission:item-create']]);
    Route::get("/admin/register_user/edit/{id}", [ 'as'=>'admin.register_user.edit','uses'=>'admin\Register_userController@getEdit','middleware' => ['permission:item-edit']]);
    Route::get("/admin/register_user/status/{field}/{id}", [ 'as'=>'admin.register_user.edit','uses'=>'admin\Register_userController@status','middleware' => ['permission:item-edit']]);
    Route::get("/admin/register_user/export/{type}", [ 'as'=>'admin.register_user.edit','uses'=>'admin\Register_userController@getExport','middleware' => ['permission:item-list']]);
    Route::post("/admin/register_user/edit", [ 'as'=>'admin.register_user.edit','uses'=>'admin\Register_userController@postEdit','middleware' => ['permission:item-edit']]);
    Route::post("/admin/register_user/delete", [ 'as'=>'admin.register_user.delete','uses'=>'admin\Register_userController@delete','middleware' => ['permission:item-delete']]);
    Route::get("/admin/register_user/view/{id}", [ 'as'=>'admin.register_user.edit','uses'=>'admin\Register_userController@view','middleware' => ['permission:item-list']]);
    // EO : Register_user

    //BO :permissions
     Route::post("/admin/permissions/mass_destroy", [ 'as'=>'admin.permissions.deleteAll','uses'=>'admin\PermissionsController@massDestroy','middleware' => ['permission:item-delete']]);

    Route::get("/admin/permissions", [ 'as'=>'admin.permissions.index','uses'=>'admin\PermissionsController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);

    Route::get("/admin/permissions/create", [ 'as'=>'admin.permissions.create','uses'=>'admin\PermissionsController@create','middleware' => ['permission:item-create']]);

    Route::post("/admin/permissions/store", [ 'as'=>'admin.permissions.store','uses'=>'admin\PermissionsController@store','middleware' => ['permission:item-create']]);

    Route::get("/admin/permissions/edit/{id}", [ 'as'=>'admin.permissions.edit','uses'=>'admin\PermissionsController@edit','middleware' => ['permission:item-edit']]);

    Route::post("/admin/permissions/update/{id}", [ 'as'=>'admin.permissions.update','uses'=>'admin\PermissionsController@update','middleware' => ['permission:item-edit']]);

    Route::delete("/admin/permissions/destroy/{id}", [ 'as'=>'admin.permissions.delete','uses'=>'admin\PermissionsController@destroy','middleware' => ['permission:item-delete']]);
// EO:permissions

  //BO :users

     Route::post("/admin/users/mass_destroy", [ 'as'=>'admin.users.deleteAll','uses'=>'admin\UsersController@massDestroy','middleware' => ['permission:item-delete']]);

    Route::get("/admin/users", [ 'as'=>'admin.users.index','uses'=>'admin\UsersController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);

    Route::get("/admin/users/create", [ 'as'=>'admin.users.create','uses'=>'admin\UsersController@create','middleware' => ['permission:item-create']]);

    Route::post("/admin/users/store", [ 'as'=>'admin.users.store','uses'=>'admin\UsersController@store','middleware' => ['permission:item-create']]);

    Route::get("/admin/users/edit/{id}", [ 'as'=>'admin.users.edit','uses'=>'admin\UsersController@edit','middleware' => ['permission:item-edit']]);

    Route::post("/admin/users/update/{id}", [ 'as'=>'admin.users.update','uses'=>'admin\UsersController@update','middleware' => ['permission:item-edit']]);
    Route::delete("/admin/users/destroy/{id}", [ 'as'=>'admin.users.delete','uses'=>'admin\UsersController@destroy','middleware' => ['permission:item-delete']]);

// EO:users

//BO :roles
    Route::post("/admin/roles/mass_destroy", [ 'as'=>'admin.roles.deleteAll','uses'=>'admin\RolesController@massDestroy','middleware' => ['permission:item-delete']]);

    Route::get("/admin/roles", [ 'as'=>'admin.roles.index','uses'=>'admin\RolesController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);

    Route::get("/admin/roles/create", [ 'as'=>'admin.roles.create','uses'=>'admin\RolesController@create','middleware' => ['permission:item-create']]);

    Route::post("/admin/roles/store", [ 'as'=>'admin.roles.store','uses'=>'admin\RolesController@store','middleware' => ['permission:item-create']]);

    Route::get("/admin/roles/edit/{id}", [ 'as'=>'admin.roles.edit','uses'=>'admin\RolesController@edit','middleware' => ['permission:item-edit']]);
    Route::post("/admin/roles/update/{id}", [ 'as'=>'admin.roles.update','uses'=>'admin\RolesController@update','middleware' => ['permission:item-edit']]);
    Route::delete("/admin/roles/destroy/{id}", [ 'as'=>'admin.roles.delete','uses'=>'admin\RolesController@destroy','middleware' => ['permission:item-delete']]);
// EO:roles

});
