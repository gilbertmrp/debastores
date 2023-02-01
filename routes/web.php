<?php

use App\Models\Barang;
use App\Models\AboutUs;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DetailMenuController;

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

Route::get('/', function () {
    $dataAboutUs = AboutUs::all();
    $dataProduk = Barang::all();
    return view('user.home', compact('dataAboutUs','dataProduk'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/list-menu', [MenuController::class, 'menuUser'])->name('product.menu');

Route::get('pesan/{id}', [App\Http\Controllers\PesanController::class, 'index']);

Route::post('pesan-process/{id}', [App\Http\Controllers\PesanController::class, 'pesan']);

Route::get('checkout', [App\Http\Controllers\PesanController::class, 'check_out']);

Route::delete('check-out/{id}', [App\Http\Controllers\PesanController::class, 'delete']);

Route::get('konfirmasi-check-out', [App\Http\Controllers\PesanController::class, 'konfirmasi']);

Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index']);

Route::post('profile', [App\Http\Controllers\ProfileController::class, 'update']);

Route::get('pesanan', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.detail');

Route::get('pesanan/{id}', [App\Http\Controllers\HistoryController::class, 'detail']);

Route::get('/contact', [HomeController::class, 'contact'])->name('reservation');

Route::post('/reservation', [HomeController::class, 'reservation']);

Route::get('/upload/{id}', [HomeController::class, 'upload'])->name('upload');

Route::post('/upload-process/{id}', [HomeController::class, 'uploadProcess'])->name('upload.process');

Route::get('/aboutususer', [AboutUsController::class, 'indexuser']);

Route::get('/detailbandrek', function(){
    return view('user.detailmenu.bandrek');
});

Route::get('/hubungi-kami', [HomeController::class, 'contactus'])->name('contactus');
Route::post('/hubungi-kami', [HomeController::class, 'contactUsProcess'])->name('contactus.process');

Route::get('/history', [HistoryController::class, 'history'])->name('history');
Route::get('/history/{id}', [HistoryController::class, 'historyDetail'])->name('history');
// Route::get('/aboutususer', [AboutUsController::class, 'slideSatu']);
// Route::get('/aboutususer', [AboutUsController::class, 'slideSatu']);
Route::get('/review', [ReviewController::class, 'index'])->name('review');
Route::get('/berikan-ulasan/{id}', [ReviewController::class, 'store']);
Route::post('/berikan-ulasan-process/{id}', [ReviewController::class, 'storeReviewProcess']);
// Route::post('/berikan-ulasan-process/{id}', [ReviewController::class, 'storeProcess']);

Route::get('/image', [GalleryController::class, 'userGallery'])->name('user.gallery');

// For Admin
Route::get('/user-role', [HomeController::class, 'userManagement'])->name('user.role');

Route::get('/delete-role/{id}', [HomeController::class, 'delete'])->name('delete.user');

Route::get('/trash', [HomeController::class, 'trash'])->name('trash.user');

Route::get('/restore/{id}', [HomeController::class, 'restoreUser'])->name('restore.user');

Route::get('/restore-all', [HomeController::class, 'restoreAll'])->name('restore.all.user');

Route::get('/delete-role/{id}', [HomeController::class, 'delete'])->name('delete.user');

Route::get('/trash', [HomeController::class, 'trash'])->name('trash.user');

Route::get('/restore/{id}', [HomeController::class, 'restore'])->name('restore.user');

Route::get('/restore-all', [HomeController::class, 'restoreAll'])->name('restore.all.user');



// Restore for admin


Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/add-menu', [MenuController::class, 'menu'])->name('add.menu');

Route::post('/add-menu-process', [MenuController::class, 'store'])->name('add.menu.process');

Route::get('/edit-menu', [MenuController::class, 'getUpdate'])->name('edit.menu');

Route::get('/edit-menu/{id}', [MenuController::class, 'getUpdate'])->name('edit.menu');

Route::post('/edit-menu-process/{id}', [MenuController::class, 'update'])->name('edit.menu.process');

Route::get('/delete/{id}', [MenuController::class, 'delete'])->name('delete');
Route::get('/aboutus', [AboutUsController::class, 'index'])->name('aboutus');
Route::get('/addaboutus', [AboutUsController::class, 'create']);
Route::post('/add-aboutus-process', [AboutUsController::class, 'store'])->name('add.aboutus.process');
Route::delete('/delete/{id}', [AboutUsController::class, 'destroy'])->name('delete');
Route::get('/edit-aboutus/{id}', [AboutUsController::class, 'edit'])->name('edit.aboutus');
Route::post('/edit-aboutus-process/{id}', [AboutUsController::class, 'update'])->name('edit.aboutus.process');

Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/viewagen', [HomeController::class, 'viewagen']);

Route::post('/uploadagen', [HomeController::class, 'uploadagen']);

Route::get('/updateagen/{id}', [HomeController::class, 'updateagen']);

Route::post('/editagen/{id}', [HomeController::class, 'editagen']);

Route::get('/addagen', [HomeController::class, 'addagen']);

Route::get("/deleteagen/{id}",[HomeController::class,"deleteagen"]);

Route::get('/viewreservation', [HomeController::class, 'viewreservation']);

Route::get('/gallerys', [GalleryController::class, 'index'])->name('gallerys');
Route::get('/add-gallery', [GalleryController::class, 'getStore'])->name('add.gallery');
Route::post('/add-gallery-process', [GalleryController::class, 'store'])->name('add.gallery.process');
Route::get('/update-gallery/{id}', [GalleryController::class, 'getUpdate']);
Route::post('/update-gallery-process/{id}', [GalleryController::class, 'getUpdateProcess']);
Route::get('/delete-gallery/{id}', [GalleryController::class, 'deleteGallery']);

Route::get('/order-details', [PesanController::class, 'orderDetails'])->name('oder.deatail');
Route::get('/confirm-order-process/{id}', [PesanController::class, 'confirmOrdersProcess'])->name('oder.confirm.process');
Route::get('/order-finish', [PesanController::class, 'orderResult'])->name('oder.finish');
Route::get('/order-finish/{id}', [PesanController::class, 'orderResultUpload'])->name('oder.finish.upload');
Route::get('/result-file/{id}', [PesanController::class, 'resultFile'])->name('result.file');
// Route::post('/confirm-order/{id}', [PesanController::class, 'confirmOrders'])->name('confirm.order');
Route::get('/profile-admin', [ProfileController::class, 'profileAdmin'])->name('profile.admin');

Route::get('/setting', [ProfileController::class, 'setting'])->name('setting.admin');

Route::post('/setting-process', [ProfileController::class, 'updateProfileAdmin'])->name('setting.process');

Route::get('/contact-us', [HomeController::class, 'contactUsAdmin'])->name('contact.us');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/add-admin', [AdminController::class, 'store'])->name('add.admin');
Route::post('/add-admin-process', [AdminController::class, 'storeProcess'])->name('add.admin.process');
Route::get('/edit-admin/{id}', [AdminController::class, 'edit'])->name('edit.admin');
Route::post('/edit-admin-process/{id}', [AdminController::class, 'editProcess'])->name('edit.admin.process');

Route::get('/confirm-photo', [PesanController::class, 'confirmPhoto'])->name('confirm.photo');
Route::post('/confirm-photo-process/{id}', [PesanController::class, 'confirmPhotoProcess'])->name('confirm.photo.process');
Route::get('/tracking', [PesanController::class, 'tracking'])->name('order.tracking');
Route::get('/form-tracking/{id}', [PesanController::class, 'formTracking']);
Route::post('/form-tracking-process/{id}', [PesanController::class, 'formTrackingProcess']);

