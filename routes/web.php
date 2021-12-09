<?php

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WarehousesController;
use App\Http\Controllers\Clients\ActivitiesController;
use App\Http\Controllers\Manager\ItemsController;
use App\Models\Category;
use App\Models\Province;
use App\Models\District;
use App\Models\Sector;
use App\Models\Cell;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::middleware('role:admin')->prefix('manager')->name('admin.')->group(function () {
        Route::view('/categories', 'admin.categories')->name('categories');
        Route::view('/unities', 'admin.unities')->name('unities');

        Route::view('warehouses', 'admin.warehouses')->name('warehouses');
        Route::get('warehouse/insert', function(){
            $categories = Category::select('name','id')->orderBy('name')->get();
            $provinces = Province::orderBy('name')->get();
            $districts = District::orderBy('name')->get();
            $sectors = Sector::orderBy('name')->get();
            $cells = Cell::orderBy('name')->get();
            return view('admin.create-edit-warehouse',compact('categories','provinces','districts',
            'sectors','cells'));
        })->name('warehouses.create');
        Route::post('warehouse/store', [WarehousesController::class, 'store'])->name('warehouses.store');
        Route::get('warehouse/{wh}/edit', [WarehousesController::class, 'edit'])->name('warehouses.edit');
        Route::get('warehouse/{wh}/view', [WarehousesController::class, 'show'])->name('warehouses.show');
        Route::put('warehouse/{wh}/update', [WarehousesController::class, 'update'])->name('warehouses.update');

        Route::view('warehouse-managers', 'admin.managers')->name('managers');
        Route::get('warehouse-managers/{user}/edit', [UsersController::class,'EditManagers'])->name('managers.single');
        Route::put('warehouse-managers/{user}/update',[UsersController::class,'UpdateManager'])->name('managers.update');

        Route::view('clients', 'admin.clients')->name('clients');
    });

    Route::middleware('role:manager')->prefix('warehouse-manager')->name('manager.')->group(function () {
      Route::get('products/items/{item}', [ItemsController::class,'show'])->name('items.show'); 
      Route::view('slots', 'manager.slots')->name('slots'); 
      Route::view('store', 'manager.storage')->name('store'); 
      Route::view('incoming-requests', 'manager.requests')->name('requests'); 
      Route::view('checkins', 'manager.checkins')->name('checkins'); 
      Route::view('checkouts', 'manager.checkouts')->name('checkouts'); 
      Route::view('transfers', 'manager.transfers')->name('transfers'); 
      Route::view('products', 'manager.products')->name('products'); 
      Route::get('items/insert', [ItemsController::class,'create'])->name('products.insert'); 
      Route::post('items/insert', [ItemsController::class,'store'])->name('products.store'); 
      Route::view('contacts', 'manager.clients')->name('clients'); 
    });

    Route::middleware('role:client')->name('client.')->group(function () {
        Route::view('all-items', 'client.items')->name('items');
        Route::view('new-request', 'client.new-request')->name('requests.new');
        Route::view('checkins', 'client.checkins')->name('checkins');
        Route::view('checkouts', 'client.checkouts')->name('checkouts');
        Route::view('transfers', 'client.transfer')->name('transfer');
        Route::view('adjustments', 'client.adjustments')->name('adjustment');

        Route::get('all-items/checkin/{item}', [ActivitiesController::class,'checkin'])->name('items.checkin');
        Route::post('all-items/checkin/{item}', [ActivitiesController::class,'insertCheckin'])->name('activity.checkin');
        Route::get('all-items/checkout/{item}', [ActivitiesController::class,'checkout'])->name('items.checkout');
        Route::post('all-items/checkout/{item}', [ActivitiesController::class,'insertCheckout'])->name('activity.checkout');
        Route::get('all-items/transfer/{item}', [ActivitiesController::class,'transfer'])->name('items.transfer');
    });
});
