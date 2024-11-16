<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CatagoryController;

/*Route::get('/frontend/index', function () {
    return view('frontend.index');
});*/

Route::get('/', [UserController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
    

    



Route::middleware('auth')->group(function () {
    Route::post('user/profile/store', [UserController::class, 'userprofilestore'])->name('user.profile.store');
     Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
      Route::get('/change/password', [UserController::class, 'ChangePassword'])->name('change.password');
       Route::post('/change/password/submit', [UserController::class, 'ChangePasswordSubmit'])->name('change.password.submit');
  });

require __DIR__.'/auth.php';


 Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
 Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');
 Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
 Route::get('/admin/forget_password', [AdminController::class, 'Admin_forget_password'])->name('admin.forget_password');
  Route::post('/admin/password_submit', [AdminController::class, 'Admin_password_submit'])->name('admin.password_submit');
  Route::get('/admin/reset_password/{token}', [AdminController::class, 'Admin_reset_password']);
  Route::post('/admin/reset_password_submit', [AdminController::class, 'Admin_resetpassword_submit'])->name('admin.reset_password_submit');

  Route::middleware('admin')->group(function() {
   Route::get('/admin/admin_dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.admin_dashboard'); 
   Route::get('/admin/admin_profile', [AdminController::class, 'AdminProfile'])->name('admin.admin_profile'); 
   Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
   Route::get('/admin/change_password', [AdminController::class, 'AdminProfileChangePassword'])->name('admin.change_password'); 
   Route::post('/admin/change_password_submit', [AdminController::class, 'AdminProfileChangePasswordSubmit'])->name('admin.change_password_submit');

  
 });
 


  ///client

 Route::get('/client/client_login', [ClientController::class, 'ClientLogin'])->name('client.client_login');
 Route::post('/client/client_login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.client_login_submit');
  Route::get('/client/client_register', [ClientController::class, 'ClientRegister'])->name('client.client_register');
   Route::post('/client/client_register_submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.client_register_submit');
    Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');

    Route::middleware('client')->group(function() {
    Route::get('/client/client_dashboard', [ClientController::class, 'ClientDashboard'])->name('client.client_dashboard'); 
    Route::get('/client/client_profile', [ClientController::class, 'ClientProfile'])->name('client.client_profile'); 
    Route::post('/client/profile_store', [ClientController::class, 'ClientProfileStore'])->name('client.profile_store'); 
     });

    //admin catagory

   Route::middleware('admin')->group(function(){
           Route::controller(CatagoryController::class)->group(function(){
            Route::get('/all/catagory', 'AllCatagory')->name('all.catagory');
             Route::get('/add/catagory', 'AddCatagory')->name('add.catagory');
             Route::post('/catagory/store', 'CatagoryStore')->name('catagory.store');
             Route::get('/edit/catagory/{id}', 'EditCatagory')->name('edit.catagory');
              Route::post('/update/catagory', 'CatagoryUpddate')->name('update.catagory');
              Route::get('/delete/catagory/{id}', 'DeleteCatagory')->name('delete.catagory');

              Route::get('/all/city', 'AllCity')->name('all.city');
              Route::post('/city/store', 'CityStore')->name('city.store');
               Route::get('/edit/city/{id}', 'EditCity');
                Route::post('/city/update', 'CityUpdate')->name('update.city');
                Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');

           });
     
   });