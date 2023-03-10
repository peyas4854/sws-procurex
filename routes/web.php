<?php

use App\Models\CsDetail;
use App\Models\Requisition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginWithHrmController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\ApprovalTeamController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CsDetailController;
use App\Http\Controllers\CsDetailApprovalController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderApprovalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrandImportExportController;
use App\Http\Controllers\PurchaseOrderReportController;
use App\Http\Controllers\RequisitionReportController;
use App\Http\Controllers\ItemImportExportController;
use App\Http\Controllers\GoodsReceivableNoteController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryExportImportController;
use App\Http\Controllers\ProcessInfoController;
use App\Http\Controllers\ProfileController;



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
Route::get('/test', function () {

   $user = auth()->user()->employee;
   dd($user);
});


Auth::routes(['register' => false]);
Route::post('authenticate', [LoginController::class,'authenticate']);

// hrm login
Route::get('/hrm', [LoginWithHrmController::class, 'showLoginForm']);
Route::post('/hrm/login', [LoginWithHrmController::class, 'login'])->name('hrm.login');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    // Setting Routes
    Route::get("settings", [SettingController::class, 'index']);
    Route::post("setting/save", [SettingController::class, 'save']);
    //Brand
    Route::resource("brands", BrandController::class);
    Route::get('brand/upload', [BrandImportExportController::class, 'upload'])->name('upload.brands');
    Route::post('brand/upload', [BrandImportExportController::class, 'store'])->name('store.uploaded.brands');
    Route::get('brand/reload', [BrandImportExportController::class, 'reload'])->name('reload.upload.brands');
    Route::get("brand/export", [BrandImportExportController::class, 'export']);
    // Roles
    Route::resource('roles', RoleController::class);
    //uoms
    Route::resource('uoms', UomController::class);
    //items
    Route::resource('items', ItemController::class);
    // Category Routes
    Route::resource("categories", CategoryController::class);
    Route::get("category/export", [CategoryExportImportController::class, 'export']);
    Route::get("category/import", [CategoryExportImportController::class, 'index']);
    Route::post("category/import/upload", [CategoryExportImportController::class, 'import'])->name('category.import');
    // Department Routes
    Route::resource('departments', DepartmentController::class);
    // Cost Center
    Route::resource('cost-center', CostCenterController::class);
    //Employee
    Route::resource('employee', EmployeeController::class);
    // Designation Routes
    Route::resource('designations', DesignationController::class);
    // Vendor Routes
    Route::resource('vendors', VendorController::class);
    Route::get('import/vendor', [VendorController::class,'import']);
    Route::post('import/vendor', [VendorController::class,'uploadVendors']);
    Route::get('export/vendor', [VendorController::class,'exportVendors']);
    Route::get('vendor/reload', [VendorController::class,'reload']);
    // Contact Routes
    Route::resource('contacts', ContactController::class);
    // Requisition
    Route::resource('requisitions', RequisitionController::class);
    Route::get('/requisition/withdraw/{requisition}', [RequisitionController::class, 'withdraw']);
    Route::get('/requisitions/{id}/print', [RequisitionController::class, 'print'])->name('print.pr');
    Route::get('/requisition-report', [RequisitionReportController::class, 'create']);
    Route::any('/requisition/show', [RequisitionReportController::class, 'show']);
    Route::get('/requisitions/export/{requisition}', [RequisitionController::class, 'export']);
    // Approval Teams
    Route::resource('approval-teams', ApprovalTeamController::class);
    Route::get("item/upload", [ItemImportExportController::class, 'import']);
    Route::post("item/upload/store", [ItemImportExportController::class, 'importStore']);
    Route::get("item/reload", [ItemImportExportController::class, 'reload']);
    Route::get("item/export", [ItemImportExportController::class, 'export']);
    //notification
    Route::get("mark-as-read", [NotificationController::class, 'markAsRead']);
    Route::get("my-notification", [NotificationController::class, 'index']);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('user.notifications');
    //users
    Route::any("users", [UserController::class, 'index']);
    Route::get("users/edit/{id}", [UserController::class,'edit']);
    Route::post("users/update", [UserController::class,'update']);
    Route::any("mass/role", [UserController::class,'massRole']);
    Route::post("mass/role/assign", [UserController::class,'massRoleAssign']);
    //profile
    Route::get("change-password", [ProfileController::class,'changePassword']);
    Route::post("change-password", [ProfileController::class,'updatePassword']);
    // CSDetail Routes
    Route::any("cs-details", [CsDetailController::class,'index']);
    Route::get("cs-detail/create/{id?}", [CsDetailController::class,'create']);
    Route::post("cs-detail/save", [CsDetailController::class,'save']);
    Route::get("/cs-detail/{id}", [CsDetailController::class,'view']);
    Route::get("cs-detail/edit/{cs_detail}", [CsDetailController::class,'edit']);
    Route::get('/cs-detail/{id}/print', [CsDetailController::class, 'print'])->name('print.cs');
    Route::get('/cs-detail/withdraw/{cs_detail}', [CsDetailController::class, 'withdraw']);
    Route::delete('/cs-detail/delete/{cs_detail}', [CsDetailController::class, 'destroy'])->name('cs-detail.destroy');

    // CS detail status change
    Route::post("cs-detail/status/change", [CsDetailApprovalController::class,'statusChange']);
    Route::post("master/user/cs-detail/status/change", [CsDetailApprovalController::class,'masterUserStatusChange']);

    // Select2 remote data:
    Route::get("/approval-team-select", [EmployeeController::class,'selectApprovalTeam']);

    //Purchase Order
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::get('purchase-orders/print/{id}', [PurchaseOrderController::class,'printPO'])->name('purchase.order.print');
    Route::get('purchaseOrder/withdraw/{purchase_order}', [PurchaseOrderController::class,'withdraw']);
    //Purchase Order status change
    Route::post("purchase-orders/status/change", [PurchaseOrderApprovalController::class,'statusChange']);
    Route::post("master/user/purchase-orders/status/change", [PurchaseOrderApprovalController::class,'masterUserStatusChange']);
    // Purchase Order Reports
    Route::get('/purchase-order-report', [PurchaseOrderReportController::class, 'create']);
    Route::get('/purchase-order/show', [PurchaseOrderReportController::class, 'show']);
    Route::get('/purchase-order/excel-report', [PurchaseOrderReportController::class, 'show']);
    Route::get('/purchase-order/pdf-report', [PurchaseOrderReportController::class, 'show']);

    // GRN routes
    Route::resource('grn', GoodsReceivableNoteController::class);
    //companies
    Route::resource('companies', CompanyController::class);
    Route::get("/cost-center-select", [CompanyController::class,'selectConstCenter']);

    Route::get("/process-info", [ProcessInfoController::class,'index']);

    Route::get('/phpinfo', function () {
        phpinfo();
    });

});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
