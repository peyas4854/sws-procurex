<?php

use App\Http\Controllers\Api\MediaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RequisitionController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\RequisitionApprovalController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\GoodsReceivableNoteController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;

/*
|--------------------------------------------------------------------------
| Internal Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register internal api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    // Requisition
    Route::get('/requisition/create/info',[RequisitionController::class,'requisitionCreateInfo']);
    Route::get('/get/item/{type}',[ItemController::class,'getItem']);
    Route::post('/requisition/store',[RequisitionController::class,'store']);
    Route::get('/requisition/{requisition}',[RequisitionController::class,'show']);
    Route::get('/requisition/edit/{requisition}',[RequisitionController::class,'edit']);
    Route::post('/requisition-item',[RequisitionController::class,'requisitionDetailItem']);
    Route::post('/it-team/requisition/store',[RequisitionController::class,'itTeamStore']);


    // Requisition status change
    Route::post('/bu-head/change/{requisition}',[RequisitionApprovalController::class,'statusChangeByBuHead']);
    Route::post('/requisition/change/master/user/{requisition}',[RequisitionApprovalController::class,'statusChangeMasterUser']);
    Route::post('/requisition/reinitiate/{requisition}',[RequisitionApprovalController::class,'requisitionReInitiate']);

    // Requisition Forward
    Route::post('/requisition/forward/{requisition}',[RequisitionApprovalController::class,'requisitionForward']);
    // Purchase Order
    Route::get('/purchase-order/create/info',[PurchaseOrderController::class,'purchaseOrderCreateInfo']);
    Route::get('/purchase-order/item',[PurchaseOrderController::class,'getItem']);
    Route::post('/purchase-order/store',[PurchaseOrderController::class,'store']);
    Route::get('/purchase-order/edit/{purchaseOrder}',[PurchaseOrderController::class,'edit']);
    Route::get('/purchase-order/approved',[PurchaseOrderController::class,'getApprovedPurchaseOrder']);
    Route::get('/purchase-order-detail/{id}',[PurchaseOrderController::class,'getPurchaseOrderDetail']);
    // GRN routes
    Route::post('/grn-store',[GoodsReceivableNoteController::class,'store']);

    // company
    Route::get('/company/{id}',[CompanyController::class,'show']);
    // employee
    Route::get('/get-employee',[EmployeeController::class,'getEmployee']);
    // media
    Route::post('/file/delete', [MediaController::class,'delete']);

});
