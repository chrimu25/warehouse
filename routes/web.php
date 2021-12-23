<?php

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WarehousesController;
use App\Http\Controllers\Clients\ActivitiesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Manager\ItemsController;
use App\Models\Category;
use App\Models\Province;
use App\Models\District;
use App\Models\Sector;
use App\Models\Cell;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/request', function () {
    return view('request');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::middleware('role:admin')->prefix('manager')->name('admin.')->group(function () {
        Route::get('/dashboard',[DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('clients/{user}/view',[UsersController::class, 'viewSingleClient'])->name('client');
        Route::view('/categories', 'admin.categories')->name('categories');
        Route::view('/unities', 'admin.unities')->name('unities');

        Route::view('warehouses', 'admin.warehouses')->name('warehouses');
        Route::get('warehouse/insert', function(){
            $categories = Category::select('name','id')->orderBy('name')->get();

            return view('admin.create-edit-warehouse',compact('categories'));
        })->name('warehouses.create');
        Route::post('warehouse/store', [WarehousesController::class, 'store'])->name('warehouses.store');
        Route::get('warehouse/{wh}/edit', [WarehousesController::class, 'edit'])->name('warehouses.edit');
        Route::get('warehouse/{wh}/view', [WarehousesController::class, 'show'])->name('warehouses.show');
        Route::put('warehouse/{wh}/update', [WarehousesController::class, 'update'])->name('warehouses.update');

        Route::view('warehouse-managers', 'admin.managers')->name('managers');
        Route::get('warehouse-managers/{user}/edit', [UsersController::class,'EditManagers'])->name('managers.single');
        Route::put('warehouse-managers/{user}/update',[UsersController::class,'UpdateManager'])->name('managers.update');

        Route::view('clients', 'admin.clients')->name('clients');
        Route::view('checkouts', 'admin.checkouts')->name('checkouts');
        Route::view('checkins', 'admin.checkins')->name('checkins');
        Route::view('transfers', 'admin.transfers')->name('transfers');
        Route::view('items', 'admin.items')->name('items');
        Route::view('store', 'admin.store')->name('store');
        Route::view('invoices', 'admin.invoices')->name('invoices');

        // Export
        Route::get('monthly-checkins',[ExportController::class,'MOnthlyCheckins'])->name('export.checkins');
        Route::get('monthly-checkouts',[ExportController::class,'MOnthlyCheckouts'])->name('export.checkouts');
        Route::get('yearly-checkins',[ExportController::class,'AllYearlyCheckins'])->name('export.checkins.yearly');
        Route::get('yearly-checkouts',[ExportController::class,'AllYearlyCheckouts'])->name('export.checkouts.yearly');
        Route::get('monthly-transfers',[ExportController::class,'MOnthlyTransfers'])->name('export.transfers');
        Route::get('yearly-transfers',[ExportController::class,'AllYearlyTransfers'])->name('export.transfers.yearly');
        Route::get('monthly-store',[ExportController::class,'MOnthlyStore'])->name('export.store');
        Route::get('yearly-store',[ExportController::class,'AllYearlyStore'])->name('export.store.yearly');
    });

    Route::middleware('role:manager')->prefix('warehouse-manager')->name('manager.')->group(function () {
      Route::get('/dashboard',[DashboardController::class, 'manager'])->name('dashboard');
      Route::get('clients/{user}/view',[UsersController::class, 'viewSingleClient'])->name('client');
      Route::get('products/items/{item}', [ItemsController::class,'show'])->name('items.show');
      Route::view('slots', 'manager.slots')->name('slots');
      Route::view('store', 'manager.storage')->name('store');
      Route::view('incoming-requests', 'manager.requests')->name('requests');
      Route::view('checkins', 'manager.checkins')->name('checkins');
      Route::view('checkouts', 'manager.checkouts')->name('checkouts');
      Route::view('invoices', 'manager.invoices')->name('invoices');
      Route::view('transfers', 'manager.transfers')->name('transfers');
      Route::view('outgoing-transfers', 'manager.outgoings')->name('outgoings');
      Route::view('products', 'manager.products')->name('products');
      Route::get('items/insert', [ItemsController::class,'create'])->name('products.insert');
      Route::post('items/insert', [ItemsController::class,'store'])->name('products.store');
      Route::view('contacts', 'manager.clients')->name('clients');

    //   Exports
    Route::get('monthlyrequests',[ExportController::class,'warehouseMonthlyRequests'])->name('export.requests');
    Route::get('monthlychekouts',[ExportController::class,'warehouseMonthlyCheckouts'])->name('export.checkouts');
    Route::get('monthlychekins',[ExportController::class,'warehouseMonthlyCheckins'])->name('export.checkins');
    Route::get('monthlyoutgoings',[ExportController::class,'warehouseMonthlyOutgoings'])->name('export.outgoings');
    Route::get('monthlytransfers',[ExportController::class,'warehouseMonthlyTransfer'])->name('export.transfers');
    Route::get('yearlycheckins',[ExportController::class,'YearlyCheckins'])->name('export.checkins.yearly');
    Route::get('yearlycheckouts',[ExportController::class,'YearlyCheckouts'])->name('export.checkouts.yearly');
    Route::get('yearlytransfers',[ExportController::class,'YearlyTransfers'])->name('export.transfers.yearly');
    Route::get('yearlyoutgoing',[ExportController::class,'YearlyOutgoings'])->name('export.outgoing.yearly');
    Route::get('yearlyrequests',[ExportController::class,'YearlyRequests'])->name('export.requests.yearly');
    });

    Route::middleware('role:client')->name('client.')->group(function () {
        Route::view('all-items', 'client.items')->name('items');
        Route::view('new-request', 'client.new-request')->name('requests.new');
        Route::view('checkins', 'client.checkins')->name('checkins');
        Route::view('checkouts', 'client.checkouts')->name('checkouts');
        Route::view('transfers', 'client.transfer')->name('transfer');
        Route::view('invoices', 'client.invoices')->name('invoices');
        Route::view('adjustments', 'client.adjustments')->name('adjustment');

        Route::get('all-items/checkin/{item}', [ActivitiesController::class,'checkin'])->name('items.checkin');
        Route::post('all-items/checkin/{item}', [ActivitiesController::class,'insertCheckin'])->name('activity.checkin');
        Route::get('all-items/checkout/{item}', [ActivitiesController::class,'checkout'])->name('items.checkout');
        Route::post('all-items/checkout/{item}', [ActivitiesController::class,'insertCheckout'])->name('activity.checkout');
        Route::get('all-items/transfer/{item}', [ActivitiesController::class,'transfer'])->name('items.transfer');
    });
});
