<?php

use App\Http\Controllers\AdminSearchController;
use App\Http\Controllers\AllViewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommonWordsController;
use App\Http\Controllers\CreateAgentController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ShareListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilitiesController;
use App\Models\ShareList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::post('/password-update', [UserController::class, 'passwordUpdate'])->name('pass.update');

    Route::get('/add-property', [PropertiesController::class, 'index'])->name('add.property')->middleware('log.agent.activity');
    Route::post('/add-property-save', [PropertiesController::class, 'store'])->name('add.property.save');
    Route::get('property/{code}', [PropertiesController::class, 'show'])->name('property.show')->middleware('log.agent.activity');
    Route::post('/check-code', [PropertiesController::class, 'checkCode'])->name('check.code');
    Route::post('/search-building', [PropertiesController::class, 'searchBuilding'])->name('search.building');
    Route::post('/get-building-info', [PropertiesController::class, 'getBuildingInfo'])->name('get.building.info');

    Route::get('/properties-import', [PropertiesController::class, 'bulkImport'])->name('properties.import');
    Route::post('/import-properties', [PropertiesController::class, 'importBulkProperties'])->name('import.properties');

    Route::post('/images/duplicate', [PropertiesController::class, 'duplicateImages'])->name('images.duplicate');

    Route::post('/upload-images', [PropertiesController::class, 'uploadImage'])->name('upload.images');
    Route::delete('/delete-image', [PropertiesController::class, 'deleteImage'])->name('delete.image');

    Route::get('/admin-search', [AdminSearchController::class, 'index'])->name('admin.search.page')->middleware('log.agent.activity');
    Route::post('/admin/search/result', [AdminSearchController::class, 'search'])->name('admin.search.result');
    Route::post('/export-selected-columns', [AdminSearchController::class, 'exportSelectedColumns'])->name('export.selected.columns');

    Route::post('/share-property', [CreateAgentController::class, 'shareProperty'])->name('property.share');
    Route::post('/share-image', [CreateAgentController::class, 'shareImage'])->name('share.image');

    Route::get('/get-share-count', [UserController::class, 'getShareCount'])->name('getShareCount');

    Route::get('/property-list', [PropertiesController::class, 'propertyListPage'])->name('property.list')->middleware('log.agent.activity');
    Route::get('/property-table', [PropertiesController::class, 'propertyListTable'])->name('property.table');

    Route::post('/property/copy', [PropertiesController::class, 'copyProperty'])->name('property.copy');

    Route::post('/update-contact-order', [PropertiesController::class, 'updateOrder'])->name('contacts.updateOrder');

    Route::get('/photo-page/{code}', [PropertiesController::class, 'photoPage'])->name('view.photo');
    Route::get('/photos-table/{code}', [PropertiesController::class, 'photosTable'])->name('table.photos');
    Route::delete('/photo-delete/{id}', [PropertiesController::class, 'photoDelete'])->name('photo.delete');

    Route::delete('/property/{id}', [PropertiesController::class, 'destroy'])->name('property.destroy');

    Route::get('/create-staff', [CreateAgentController::class, 'index'])->name('create-agent')->middleware('log.agent.activity');
    Route::post('/create-staff/store', [CreateAgentController::class, 'store'])->name('create-agent.store');

    Route::get('/edit-code/{code}', [PropertiesController::class, 'editCode'])->name('edit.code')->middleware('log.agent.activity');
    Route::post('/update-code/{code}', [PropertiesController::class, 'updateCode'])->name('update.code');

    Route::post('/update-room', [PropertiesController::class, 'updateRoom']);
    Route::post('/photo-ytLink', [PropertiesController::class, 'ytLink'])->name('photo.ytLink');

    Route::get('/property-detail-edit/{code}', [PropertiesController::class, 'editProperty'])->name('edit.property.detail')->middleware('log.agent.activity');
    Route::get('/get-property-images/{code}', [PropertiesController::class, 'getPropertyImages'])->middleware('log.agent.activity');
    Route::post('/update-detail-edit/{code}', [PropertiesController::class, 'update'])->name('update.detail.edit');

    Route::get('/edit-buildinginfo/{code}', [PropertiesController::class, 'editBuildinginfo'])->name('edit.buildinginfo')->middleware('log.agent.activity');
    Route::post('/update-buildinginfo/{code}', [PropertiesController::class, 'updateBuildinginfo'])->name('update.buildinginfo');

    Route::get('/edit-landlord/{code}', [PropertiesController::class, 'editLandlord'])->name('edit.landlord')->middleware('log.agent.activity');
    Route::post('/update-landlord/{code}', [PropertiesController::class, 'updateLandlord'])->name('update.landlord');
    
    Route::get('/edit-ftod/{code}', [PropertiesController::class, 'editFtod'])->name('edit.ftod')->middleware('log.agent.activity');
    Route::post('/update-ftod/{code}', [PropertiesController::class, 'updateFtod'])->name('update.ftod');

    Route::post('/ftod-others/{id}', [propertiesController::class, 'ftodOthers'])->name('ftod.others');
    Route::post('/ftod-others-ro', [propertiesController::class, 'ftodOtherRO'])->name('ftod.others.ro');

    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/edit-sizePrice/{code}', [PropertiesController::class, 'editSizePrice'])->name('edit.size.price')->middleware('log.agent.activity');
    Route::post('/update-sizePrice/{code}', [PropertiesController::class, 'updatesizePrice'])->name('update.size.price');

    Route::post('/search-property', [PropertiesController::class, 'searchProperties'])->name('search.property');

    Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('log.agent.activity');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/update-permission', [UserController::class, 'updatePermission'])->name('users.update-permission');
    
    Route::get('/terms-conditions', function () {
        return view('term-condition');
    })->middleware('log.agent.activity');

    Route::get('/useful_words', [CommonWordsController::class, 'index'])->name('useful.words')->middleware('log.agent.activity');
    Route::post('/common_words_save', [CommonWordsController::class, 'store'])->name('common.words.save');
    Route::get('/fetch-words', [CommonWordsController::class, 'create'])->name('common.words.fetch');
    Route::delete('/delete-word/{id}', [CommonWordsController::class, 'destroy'])->name('common.words.delete');

    Route::get('/hyperlinks', function () {
        return view('online-form');
    })->middleware('log.agent.activity');
    Route::get('/password-reset', function () {
        return view('password-reset');
    })->middleware('log.agent.activity');

    Route::get('/share', [UserController::class, 'sharePage'])->name('share')->middleware('log.agent.activity');
    Route::get('/share-details', [UserController::class, 'shareDetails'])->name('share.details');
    Route::get('/fetch-usefultWords', [CommonWordsController::class, 'fetchWords'])->name('fetch.usefultWords');

    Route::post('/remove-shared-image', [UserController::class, 'removeSharedImage'])->name('remove.shared.image');
    Route::post('/remove-shared-property/{id}', [UserController::class, 'removeSharedProperty'])->name('remove.shared.property');
    Route::post('/swipe-properties', [UserController::class, 'savePropertyShareList'])->name('swipe.properties');
    Route::get('/clear-share-list', [UserController::class, 'clearShareList'])->name('clear.share.list');

    Route::post('/shared-image-order', [UserController::class, 'sharedImageOrder'])->name('shared.image.order');

    Route::post('/images-shared', [ShareListController::class, 'ImagesShared'])->name('images.shared');
    Route::post('/properties-shared', [ShareListController::class, 'PropertiesShared'])->name('properties.shared');
    Route::get('/share-list', [ShareListController::class, 'preShareList'])->name('pre.share.list')->middleware('log.agent.activity');
    Route::get('/preImgs-shares/delete', [ShareListController::class, 'delete'])->name('preImgs.shares.delete');
    Route::post('/pre-shared-imgs', [ShareListController::class, 'PreImagesShared'])->name('pre.shared.imgs');
    Route::post('/merge-share-data', [ShareListController::class, 'mergeShareData'])->name('merge.share.data');
    Route::post('/delete-old-share-records', [ShareListController::class, 'deleteOldShareRecords'])->name('deleteOldShareRecords');

    Route::get('/grid/{code}', [ShareListController::class, 'gridPage'])->name('grid');

    Route::get('/utilities', [UtilitiesController::class, 'index'])->name('utilities')->middleware('log.agent.activity');

    Route::get('/get-utility-values/{type}', [UtilitiesController::class, 'getValues'])->name('utility.values');
    Route::post('/utilities/value/add', [UtilitiesController::class, 'addValue'])->name('utilities.addValue');
    Route::post('/utilities/value/edit', [UtilitiesController::class, 'editValue'])->name('utilities.editValue');
    Route::post('/utilities/value/delete', [UtilitiesController::class, 'deleteValue'])->name('utilities.deleteValue');

    Route::get('/admin-views', [AllViewsController::class, 'index'])->name('admin.views')->middleware('log.agent.activity');
    Route::get('/get-agent-activity', [AllViewsController::class, 'getAgentActivity'])->name('get.agent.activity');
    // Route::get('/admin-views', function () {
    //     return view('all-views');
    // });

    // Route::get('/share', function () {
    //     return view('publish');
    // });
});
Route::get('/spms/sharedProperties/{link}', [ShareListController::class, 'propertySharePage'])->name('property.share.page');
Route::post('/fetch-property-details', [ShareListController::class, 'fetchPropertyDetails'])->name('fetch.property.details');
Route::get('/share/property/{code}/{link}', [ShareListController::class, 'propertyDetailsSharePage'])->name('share.property.details');
Route::get('/spms/sharedImgs/{link}', [ShareListController::class, 'ImageSharePage'])->name('Images.share.page');
Route::get('/spms/propertyImgs/{code}', [AdminSearchController::class, 'propertyImgsExcel'])->name('property.imgs.excel.page');

Route::get('/s-print/{link}', [ShareListController::class, 'pdfPage'])->name('pdf.page');
// Route::get('/s-print', function () {
//     return view('shared_pages.s-print');
// });
