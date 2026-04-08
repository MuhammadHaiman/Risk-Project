<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RiskManagementController as AdminRiskController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\DataManagementController as AdminDataController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Agency\DashboardController as AgencyDashboardController;
use App\Http\Controllers\Agency\RiskManagementController as AgencyRiskController;
use App\Http\Controllers\Agency\ReportController as AgencyReportController;
use App\Http\Controllers\Agency\DataManagementController as AgencyDataController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Api\DataController as ApiDataController;

// Root route redirects to login
Route::get('/', function () {
    return auth()->check() ? redirect()->route(auth()->user()->role . '.dashboard') : redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Risk Management
        Route::prefix('risks')->name('risks.')->group(function () {
            Route::get('/', [AdminRiskController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminRiskController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminRiskController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminRiskController::class, 'update'])->name('update');
        });

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
        });

        // Data Management
        Route::prefix('data')->name('data.')->group(function () {
            // Risk Categories
            Route::get('/risk-categories', [AdminDataController::class, 'riskCategories'])->name('risk-categories');
            Route::get('/risk-categories/create', [AdminDataController::class, 'createRiskCategory'])->name('create-risk-category');
            Route::post('/risk-categories', [AdminDataController::class, 'storeRiskCategory'])->name('store-risk-category');
            Route::delete('/risk-categories/{id}', [AdminDataController::class, 'destroyRiskCategory'])->name('destroy-risk-category');

            // Sub-Categories
            Route::get('/sub-categories', [AdminDataController::class, 'subCategories'])->name('sub-categories');
            Route::get('/sub-categories/create', [AdminDataController::class, 'createSubCategory'])->name('create-sub-category');
            Route::post('/sub-categories', [AdminDataController::class, 'storeSubCategory'])->name('store-sub-category');
            Route::delete('/sub-categories/{id}', [AdminDataController::class, 'destroySubCategory'])->name('destroy-sub-category');

            // Risks
            Route::get('/risks', [AdminDataController::class, 'risks'])->name('risks');
            Route::get('/risks/create', [AdminDataController::class, 'createRisk'])->name('create-risk');
            Route::post('/risks', [AdminDataController::class, 'storeRisk'])->name('store-risk');
            Route::delete('/risks/{id}', [AdminDataController::class, 'destroyRisk'])->name('destroy-risk');

            // Causes
            Route::get('/causes', [AdminDataController::class, 'causes'])->name('causes');
            Route::get('/causes/create', [AdminDataController::class, 'createCause'])->name('create-cause');
            Route::post('/causes', [AdminDataController::class, 'storeCause'])->name('store-cause');
            Route::delete('/causes/{id}', [AdminDataController::class, 'destroyCause'])->name('destroy-cause');

            // Asset Types
            Route::get('/asset-types', [AdminDataController::class, 'assetTypes'])->name('asset-types');
            Route::get('/asset-types/create', [AdminDataController::class, 'createAssetType'])->name('create-asset-type');
            Route::post('/asset-types', [AdminDataController::class, 'storeAssetType'])->name('store-asset-type');
            Route::delete('/asset-types/{id}', [AdminDataController::class, 'destroyAssetType'])->name('destroy-asset-type');

            // Sectors
            Route::get('/sectors', [AdminDataController::class, 'sectors'])->name('sectors');
            Route::get('/sectors/create', [AdminDataController::class, 'createSector'])->name('create-sector');
            Route::post('/sectors', [AdminDataController::class, 'storeSector'])->name('store-sector');
            Route::delete('/sectors/{id}', [AdminDataController::class, 'destroySector'])->name('destroy-sector');

            // Agencies
            Route::get('/agencies', [AdminDataController::class, 'agencies'])->name('agencies');
            Route::get('/agencies/create', [AdminDataController::class, 'createAgency'])->name('create-agency');
            Route::post('/agencies', [AdminDataController::class, 'storeAgency'])->name('store-agency');
            Route::get('/agencies/{id}/edit', [AdminDataController::class, 'editAgency'])->name('edit-agency');
            Route::put('/agencies/{id}', [AdminDataController::class, 'updateAgency'])->name('update-agency');
            Route::delete('/agencies/{id}', [AdminDataController::class, 'destroyAgency'])->name('destroy-agency');
        });

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [AdminReportController::class, 'index'])->name('index');
            Route::get('/agency/{agencyId}', [AdminReportController::class, 'byAgency'])->name('by-agency');
            Route::get('/level/{level}', [AdminReportController::class, 'byRiskLevel'])->name('by-level');
            Route::get('/highest-risk', [AdminReportController::class, 'highestRiskReport'])->name('highest-risk');
            Route::get('/asset-highest-risks', [AdminReportController::class, 'assetWithHighestRisksReport'])->name('asset-highest-risks');

            // Export routes
            Route::get('/highest-risk/export/pdf', [AdminReportController::class, 'exportHighestRiskPdf'])->name('highest-risk-pdf');
            Route::get('/highest-risk/export/excel', [AdminReportController::class, 'exportHighestRiskExcel'])->name('highest-risk-excel');
            Route::get('/asset-highest-risks/export/pdf', [AdminReportController::class, 'exportAssetHighestRisksPdf'])->name('asset-highest-risks-pdf');
            Route::get('/asset-highest-risks/export/excel', [AdminReportController::class, 'exportAssetHighestRisksExcel'])->name('asset-highest-risks-excel');
        });
    });

    // Shared Report Routes (Admin & Agency)
    Route::prefix('agency')->name('agency.')->group(function () {
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [AgencyReportController::class, 'index'])->name('index');
            Route::get('/asset/{assetId}', [AgencyReportController::class, 'byAsset'])->name('by-asset');
            Route::get('/highest-risk', [AgencyReportController::class, 'highestRiskReport'])->name('highest-risk');
            Route::get('/asset-highest-risks', [AgencyReportController::class, 'assetWithHighestRisksReport'])->name('asset-highest-risks');

            // Export routes
            Route::get('/highest-risk/export/pdf', [AgencyReportController::class, 'exportHighestRiskPdf'])->name('highest-risk-pdf');
            Route::get('/highest-risk/export/excel', [AgencyReportController::class, 'exportHighestRiskExcel'])->name('highest-risk-excel');
            Route::get('/asset-highest-risks/export/pdf', [AgencyReportController::class, 'exportAssetHighestRisksPdf'])->name('asset-highest-risks-pdf');
            Route::get('/asset-highest-risks/export/excel', [AgencyReportController::class, 'exportAssetHighestRisksExcel'])->name('asset-highest-risks-excel');
        });
    });

    // Agency Routes
    Route::prefix('agency')->name('agency.')->middleware('agency')->group(function () {
        Route::get('/dashboard', [AgencyDashboardController::class, 'index'])->name('dashboard');

        // Risk Management
        Route::prefix('risks')->name('risks.')->group(function () {
            Route::get('/', [AgencyRiskController::class, 'index'])->name('index');
            Route::get('/create', [AgencyRiskController::class, 'create'])->name('create');
            Route::post('/', [AgencyRiskController::class, 'store'])->name('store');
            Route::get('/{id}', [AgencyRiskController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AgencyRiskController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AgencyRiskController::class, 'update'])->name('update');
        });

        // Data Management
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/assets', [AgencyDataController::class, 'assets'])->name('assets');
            Route::get('/assets/create', [AgencyDataController::class, 'createAsset'])->name('create-asset');
            Route::post('/assets', [AgencyDataController::class, 'storeAsset'])->name('store-asset');

            // Agency Management (for users within same sector)
            Route::get('/agencies', [AgencyDataController::class, 'agencies'])->name('agencies');
            Route::get('/agencies/create', [AgencyDataController::class, 'createAgency'])->name('create-agency');
            Route::post('/agencies', [AgencyDataController::class, 'storeAgency'])->name('store-agency');
        });
    });
});

// API Routes for cascading dropdowns (biasanya asingkan)
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/subcategories/{kategoriId}', [ApiDataController::class, 'getSubCategories']);
    Route::get('/risks/{subCategoryId}', [ApiDataController::class, 'getRisks']);
    Route::get('/causes/{kategoriId}', [ApiDataController::class, 'getCauses']);
});
