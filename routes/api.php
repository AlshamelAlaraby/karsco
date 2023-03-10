<?php

use App\Http\Controllers\Branch\BranchController;
use App\Http\Controllers\City\CityController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Currency\CurrencyController;
use App\Http\Controllers\GeneralCustomer\GeneralCustomerController;
use App\Http\Controllers\InternalSalesman\InternalSalesmanController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\RoleType\RoleTypeController;
use App\Http\Controllers\RoleWorkflow\RoleWorkflowController;
use App\Http\Controllers\ScreenTreeProperty\ScreenTreePropertyController;
use App\Http\Controllers\Serials\SerialController;
use App\Http\Controllers\TreeProperty\TreePropertyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::controller(\App\Http\Controllers\MainController::class)->group(function () {
    Route::post("/media", "media");
    Route::get("statices", "statices");
    Route::get("data-types", 'dataTypes');
    Route::put("/setting", "setting");
    Route::get("/setting/{user_id}/{screen_id}", "getSetting");
    Route::post("/send-email", "sendEmail");
});
Route::middleware('auth:sanctum')->group(function () {

    // start Notification
    Route::controller(\App\Http\Controllers\MainController::class)->group(function () {
        Route::get('getAllNot', 'getAllNot');
        Route::get('getNotNotRead', 'getNotNotRead');
        Route::post('clearItem/{id}', 'clearItem');
        Route::post('getNotNotRead', 'clearAll');
    });
    // end Notification

    Route::group(['prefix' => 'companies'], function () {
        Route::get('', [CompanyController::class, "index"]);
        Route::get('/{id}', [CompanyController::class, "show"]);
        Route::post('', [CompanyController::class, "store"]);
        Route::post('/{id}', [CompanyController::class, "update"]);
        Route::delete('/{id}', [CompanyController::class, "destroy"]);
    });
    Route::group(['prefix' => 'users'], function () {
        Route::get('profile', [\App\Http\Controllers\User\UserController::class, 'profile']);
    });
});

Route::group(['prefix' => 'modules'], function () {
    Route::controller(\App\Http\Controllers\Module\ModuleController::class)->group(function () {
        Route::get('/', 'all')->name('modules.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('modules.create');
        Route::put('/{id}', 'update')->name('modules.update');
        Route::delete('/{id}', 'delete')->name('modules.destroy');
        // Route::post('/{module_id}/company/{company_id}', 'addModuleToCompany')->name('modules.company.add');
        // Route::delete('/{module_id}/company/{company_id}', 'removeModuleFromCompany')->name('modules.company.remove');
        Route::post("bulk-delete", "bulkDelete");
        Route::post('/moduleDisable', 'moduleDisable');

    });
});

Route::group(['prefix' => 'stores'], function () {
    Route::controller(\App\Http\Controllers\Store\StoreController::class)->group(function () {
        Route::get('/', 'all')->name('stores.index');
        Route::get('logs/{id}', 'logs')->name('stores.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('stores.create');
        Route::put('/{id}', 'update')->name('stores.update');
        Route::delete('/{id}', 'delete')->name('stores.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'countries'], function () {
    Route::controller(\App\Http\Controllers\Country\CountryController::class)->group(function () {
        Route::get('/', 'all')->name('countries.index');
        Route::get('seeder', 'getCountrySeeder');
        Route::get('logs/{id}', 'logs')->name('countries.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('countries.create');
        Route::put('/{id}', 'update')->name('countries.update');
        Route::delete('/{id}', 'delete')->name('countries.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'governorates'], function () {
    Route::controller(\App\Http\Controllers\Governorate\GovernorateController::class)->group(function () {
        Route::get('/', 'all')->name('governorates.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('governorates.create');
        Route::put('/{id}', 'update')->name('governorates.update');
        Route::delete('/{id}', 'delete')->name('governorates.destroy');
        Route::get('logs/{id}', 'logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'streets'], function () {
    Route::controller(\App\Http\Controllers\StreetController::class)->group(function () {
        Route::get('/', 'all')->name('streets.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('streets.create');
        Route::put('/{id}', 'update')->name('streets.update');
        Route::delete('/{id}', 'delete')->name('streets.destroy');
        Route::get('logs/{id}', 'logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

// customer branches
Route::group(['prefix' => 'customer-branches'], function () {
    Route::controller(\App\Http\Controllers\CustomerBranchController::class)->group(function () {
        Route::get('/', 'all')->name('customer-branches.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('customer-branches.create');
        Route::put('/{id}', 'update')->name('customer-branches.update');
        Route::delete('/{id}', 'delete')->name('customer-branches.destroy');
        Route::get('logs/{id}', 'logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

// contacts routes
Route::group(['prefix' => 'contacts'], function () {
    Route::controller(\App\Http\Controllers\ContactController::class)->group(function () {
        Route::get('/', 'all')->name('contacts.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('contacts.create');
        Route::put('/{id}', 'update')->name('contacts.update');
        Route::delete('/{id}', 'delete')->name('contacts.destroy');
        Route::get('logs/{id}', 'logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'employees'], function () {
    Route::controller(\App\Http\Controllers\Employee\EmployeeController::class)->group(function () {
        Route::get('logs/{id}', 'logs')->name('employees.logs');
        Route::get('/', 'all')->name('employees.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('employees.create');
        Route::put('/{id}', 'update')->name('employees.update');
        Route::delete('/{id}', 'delete')->name('employees.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });

});

Route::group(['prefix' => 'customTable'], function () {
    Route::controller(\App\Http\Controllers\CustomTable\GeneralCustomTableController::class)->group(function () {
        Route::get('/', 'all')->name('customTable.index');
        Route::get('/table-columns/{tableName}', 'getCustomTableFields');
        Route::get('logs/{id}', 'logs')->name('customTable.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('customTable.create');
        Route::put('/update', 'update')->name('customTable.update');
        Route::delete('/{id}', 'delete')->name('customTable.destroy');
        Route::post("bulk-delete", "bulkDelete");

    });
});

Route::group(['prefix' => 'document'], function () {
    Route::controller(\App\Http\Controllers\Document\DocumentController::class)->group(function () {
        Route::get('/', 'all')->name('document.index');
        Route::get('logs/{id}', 'logs')->name('document.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('document.create');
        Route::put('/{id}', 'update')->name('document.update');
        Route::delete('/{id}', 'delete')->name('document.destroy');
        Route::post("bulk-delete", "bulkDelete");

        Route::post('from_admin', 'createFromAdmin')->name('document.create_from_admin');
    });
});

Route::group(['prefix' => 'financial-years'], function () {
    Route::controller(\App\Http\Controllers\FinancialYear\FinancialYearController::class)->group(function () {
        Route::get('/', 'all')->name('financial-years.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('financial-years.create');
        Route::put('/{id}', 'update')->name('financial-years.update');
        Route::delete('/{id}', 'delete')->name('financial-years.destroy');
        Route::get('logs/{id}', 'logs')->name('financial-years.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'units'], function () {
    Route::controller(\App\Http\Controllers\Unit\UnitController::class)->group(function () {
        Route::get('/', 'all')->name('units.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('units.create');
        Route::put('/{id}', 'update')->name('units.update');
        Route::delete('/{id}', 'delete')->name('units.destroy');
        Route::get('logs/{id}', 'logs')->name('units.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'role-workflows'], function () {
    Route::controller(RoleWorkflowController::class)->group(function () {
        Route::get('/', 'index')->name('role-workflows.index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store')->name('role-workflows.store');
        Route::put('/{id}', 'update')->name('role-workflows.update');
        Route::delete('/{id}', 'destroy')->name('role-workflows.destroy');
        Route::get('logs/{id}', 'logs')->name('role-workflows.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'avenues'], function () {
    Route::controller(\App\Http\Controllers\Avenue\AvenueController::class)->group(function () {
        Route::get('/', 'all')->name('avenues.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('avenues.create');
        Route::put('/{id}', 'update')->name('avenues.update');
        Route::delete('/{id}', 'delete')->name('avenues.destroy');
        Route::get('logs/{id}', 'logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'colors'], function () {
    Route::controller(\App\Http\Controllers\Color\ColorController::class)->group(function () {
        Route::get('/', 'all')->name('colors.index');
        Route::get('logs/{id}', 'logs')->name('colors.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('colors.create');
        Route::put('/{id}', 'update')->name('colors.update');
        Route::delete('/{id}', 'delete')->name('colors.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'salesmen-types'], function () {
    Route::controller(\App\Http\Controllers\SalesmenType\SalesmenTypeController::class)->group(function () {
        Route::get('/', 'all')->name('salesmen-types.index');
        Route::get('logs/{id}', 'logs')->name('salesmen-types.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('salesmen-types.create');
        Route::post("bulk-delete", "bulkDelete");
        Route::put('/{id}', 'update')->name('salesmen-types.update');
        Route::delete('/{id}', 'delete')->name('salesmen-types.destroy');
    });
});

Route::group(['prefix' => 'external-salesmen'], function () {
    Route::controller(\App\Http\Controllers\ExternalSalesmen\ExternalSalesmenController::class)->group(function () {
        Route::get('/', 'all')->name('external-salesmen.index');
        Route::get('logs/{id}', 'logs')->name('external-salesmen.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('external-salesmen.create');
        Route::put('/{id}', 'update')->name('external-salesmen.update');
        Route::delete('/{id}', 'delete')->name('external-salesmen.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'payment-types'], function () {
    Route::controller(\App\Http\Controllers\PaymentType\PaymentTypeController::class)->group(function () {
        Route::get('/', 'all')->name('payment-types.index');
        Route::get('logs/{id}', 'logs')->name('payment-types.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('payment-types.create');
        Route::put('/{id}', 'update')->name('payment-types.update');
        Route::delete('/{id}', 'delete')->name('payment-types.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'users'], function () {
    Route::controller(\App\Http\Controllers\User\UserController::class)->group(function () {
        Route::post("login", 'login');
        Route::get('/', 'all')->name('users.index');
        Route::get('logs/{id}', 'logs')->name('users.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('users.create');
        Route::put('/{id}', 'update')->name('users.update');
        Route::delete('/{id}', 'delete')->name('users.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'user-role'], function () {
    Route::controller(\App\Http\Controllers\UserRole\UserRoleController::class)->group(function () {
        Route::get('/', 'all')->name('user.role.index');
        Route::get('logs/{id}', 'logs')->name('user.role.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('user.role.create');
        Route::put('/{id}', 'update')->name('user.role.update');
        Route::delete('/{id}', 'delete')->name('user.role.destroy');
        Route::post("bulk-delete", "bulkDelete");
        Route::get("user-count/{roleId}", "getRoleUsersCount");

    });
});

Route::group(['prefix' => 'banks'], function () {
    Route::controller(\App\Http\Controllers\Bank\BankController::class)->group(function () {
        Route::get('/', 'all')->name('banks.index');
        Route::get('logs/{id}', 'logs')->name('banks.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('banks.create');
        Route::put('/{id}', 'update')->name('banks.update');
        Route::delete('/{id}', 'delete')->name('banks.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'bank-accounts'], function () {
    Route::controller(\App\Http\Controllers\BankAccount\BankAccountController::class)->group(function () {
        Route::get('/', 'all')->name('bank-accounts.index');
        Route::get('logs/{id}', 'logs')->name('bank-accounts.logs');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('bank-accounts.create');
        Route::put('/{id}', 'update')->name('bank-accounts.update');
        Route::delete('/{id}', 'delete')->name('bank-accounts.destroy');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'role-screen-hotfield'], function () {
    Route::controller(\App\Http\Controllers\RoleScreenHotfield\RoleScreenHotfieldController::class)->group(function () {
        Route::get('/', 'all')->name('role-screen-hotfield.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('role-screen-hotfield.create');
        Route::post("bulk-delete", "bulkDelete");
        Route::post('/{id}', 'update')->name('role-screen-hotfield.update');
        Route::delete('/{id}', 'delete')->name('role-screen-hotfield.destroy');
        Route::get('logs/{id}', 'logs')->name('role-screen-hotfield.logs');
    });
});

Route::group(['prefix' => 'role-screen-hotfield'], function () {
    Route::controller(\App\Http\Controllers\RoleScreenHotfield\RoleScreenHotfieldController::class)->group(function () {
        Route::get('/', 'all')->name('role-screen-hotfield.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('role-screen-hotfield.create');
        Route::post('/{id}', 'update')->name('role-screen-hotfield.update');
        Route::delete('/{id}', 'delete')->name('role-screen-hotfield.destroy');
        Route::get('logs/{id}', 'logs')->name('role-screen-hotfield.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'role-workflow-button'], function () {
    Route::controller(\App\Http\Controllers\RoleWorkflowButton\RoleWorkflowButtonController::class)->group(function () {
        Route::get('/', 'all')->name('role-workflow-button.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('role-workflow-button.create');
        Route::post("bulk-delete", "bulkDelete");
        Route::post('/{id}', 'update')->name('role-workflow-button.update');
        Route::delete('/{id}', 'delete')->name('role-workflow-button.destroy');
        Route::get('logs/{id}', 'logs')->name('role-workflow-button.logs');
    });
});

Route::group(['prefix' => 'workflow-hotfield'], function () {
    Route::controller(\App\Http\Controllers\WorkflowHotfield\WorkflowHotfieldController::class)->group(function () {
        Route::get('/', 'all')->name('workflow-hotfield.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('workflow-hotfield.create');
        Route::post("bulk-delete", "bulkDelete");
        Route::post('/{id}', 'update')->name('workflow-hotfield.update');
        Route::delete('/{id}', 'delete')->name('workflow-hotfield.destroy');
        Route::get('logs/{id}', 'logs')->name('workflow-hotfield.logs');
    });
});

Route::group(['prefix' => 'salesmen'], function () {
    Route::controller(\App\Http\Controllers\Salesman\SalesmanController::class)->group(function () {
        Route::get('/', 'all')->name('salesmen.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('salesmen.create');
        Route::put('/{id}', 'update')->name('salesmen.update');
        Route::delete('/{id}', 'delete')->name('salesmen.destroy');
        Route::get('logs/{id}', 'logs')->name('salesmen.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'internal-salesmen'], function () {
    Route::controller(\App\Http\Controllers\InternalSalesman\InternalSalesmanController::class)->group(function () {
        Route::get('/', 'all')->name('internal-salesmen.index');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('internal-salesmen.create');
        Route::post("bulk-delete", "bulkDelete");
        Route::post('/{id}', 'update')->name('internal-salesmen.update');
        Route::delete('/{id}', 'delete')->name('internal-salesmen.destroy');
        Route::get('logs/{id}', 'logs')->name('internal-salesmen.logs');
    });
});

Route::group(['prefix' => 'branches'], function () {
    Route::controller(BranchController::class)->group(function () {
        Route::get('logs/{id}', 'logs')->name('branches.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'roles'], function () {
    Route::controller(RoleController::class)->group(function () {
        Route::get('logs/{id}', 'logs')->name('roles.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'role_types'], function () {
    Route::controller(RoleTypeController::class)->group(function () {
        Route::get('logs/{id}', 'logs')->name('role_types.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

Route::group(['prefix' => 'serials'], function () {
    Route::controller(SerialController::class)->group(function () {
        Route::get('logs/{id}', 'logs')->name('serials.logs');
        Route::post("bulk-delete", "bulkDelete");
    });
});

//---------------------milad routes---------------------

Route::resource('branches', BranchController::class)->except('create', 'edit');
Route::resource('serials', SerialController::class)->except('create', 'edit');
Route::resource('cities', CityController::class)->except('create', 'edit');
Route::get('cities/logs/{id}', [CityController::class, 'logs']);
Route::post('cities/bulk-delete', [CityController::class, 'bulkDelete']);
Route::resource('currencies', CurrencyController::class)->except('create', 'edit');
Route::get('currencies/logs/{id}', [CurrencyController::class, 'logs']);
Route::post('currencies/bulk-delete', [CurrencyController::class, 'bulkDelete']);
Route::resource('roles', RoleController::class)->except('create', 'edit');
Route::resource('role_types', RoleTypeController::class)->except('create', 'edit');
Route::group(['prefix' => 'tree-properties'], function () {
    Route::controller(TreePropertyController::class)->group(function () {
        Route::get('root-nodes', 'getRootNodes');
        Route::get('/child-nodes/{parentId}', 'getChildNodes');
    });
});
Route::resource('tree-properties', TreePropertyController::class)->except('create', 'edit');
Route::get('tree-properties/logs/{id}', [TreePropertyController::class, 'logs']);
Route::post('tree-properties/bulk-delete', [TreePropertyController::class, 'bulkDelete']);

Route::resource('screen-tree-properties', ScreenTreePropertyController::class)->except('create', 'edit');
Route::get('screen-tree-properties/logs/{id}', [ScreenTreePropertyController::class, 'logs']);
Route::post('screen-tree-properties/bulk-delete', [ScreenTreePropertyController::class, 'bulkDelete']);

Route::resource('internal-salesman', InternalSalesmanController::class)->except('create', 'edit');

Route::get('internal-salesman/logs/{id}', [InternalSalesmanController::class, 'logs']);
Route::post('internal-salesman/bulk-delete', [InternalSalesmanController::class, 'bulkDelete']);
Route::get('internal-salesman/logs/{id}', [InternalSalesmanController::class, 'logs']);

Route::resource('general-customer', GeneralCustomerController::class)->except('create', 'edit');
Route::get('general-customer/logs/{id}', [GeneralCustomerController::class, 'logs']);
Route::post('general-customer/bulk-delete', [GeneralCustomerController::class, 'bulkDelete']);

Route::post('translation-update', [\App\Http\Controllers\TranslationController::class, 'update']);
Route::post('translation-delete', [\App\Http\Controllers\TranslationController::class, 'delete']);
//------------------------------------------------------

Route::post('/ocr/upload', [\App\Http\Controllers\OcrController::class, 'upload']); //https://packagist.org/packages/thiagoalessio/tesseract_ocr //sudo port install tesseract-<langcode>
