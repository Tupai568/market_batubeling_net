<?php

use Illuminate\Support\Facades\Route;
use Laravel\Telescope\Telescope;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\UnggulanController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\admin\GetAdminController;
use App\Http\Controllers\admin\PostAdminController;
use App\Http\Controllers\reseller\ResellerController;
use App\Http\Controllers\reseller\DataResellerController;
use App\Http\Controllers\reseller\MerchantResellerController;
use App\Http\Controllers\reseller\CreateProductResellerController;
use App\Http\Controllers\reseller\DeleteProductResellerController;
use App\Http\Controllers\reseller\UpdateProductResellerController;

Route::middleware('throttle:60,1')->group(function () {
    Route::middleware('headers')->group(function () {
        Route::get('/sitemap.xml', [SitemapController::class, "sitemap"])->name("sitemap");
        Route::get("/", [ProdukController::class, "index"])->name("home");
        Route::get("/tentang", [ProdukController::class, "tentang"]);
        Route::get("/caraBerjualan", [ProdukController::class, "caraBerjualan"]);
        Route::get("/store/profile/{profile}", [ProdukController::class, "merchant"])->name('store.products');;
        Route::get("/categorie/{name}", [ProdukController::class, "categories"])->name('categories');
        Route::get('/products/{name}/{id}/show', [ProdukController::class, 'show'])->name("detail-product");
        Route::get('/search', [ProdukController::class, 'search'])->name("search");
        Route::get('/about', [ProdukController::class, 'about'])->name('about');
        Route::get('/terms', [ProdukController::class, 'terms'])->name('terms');
        Route::get('/privacy', [ProdukController::class, 'privacy'])->name('privacy');
    
    
        Route::middleware('auth')->group(function () {
            Route::get("/Profil", [ResellerController::class, "profil"]);
            Route::get("/product/favorite", [ResellerController::class, "favorite"])->name('favorite');
            Route::get("/Setting", [DataResellerController::class, "setting"])->name('data');
            Route::post("/Setting/Data", [DataResellerController::class, "uploadData"]);
            Route::post("/logout", [AuthController::class, "logout"]);
            Route::post("/like", [LikeController::class, "index"]);
    
            //Route Kusus Reseller
            Route::middleware('is_reseller')->group(function () {
                //Method GET Member
                Route::get("/dashboard", [ResellerController::class, "index"])->name('dashboard');
                Route::get("/Reseller/{produk}/Show", [ResellerController::class, "show"]);
                Route::get("/Reseller/Product/Unggulan", [ResellerController::class, "unggulan"]);
                Route::get("/Reseller/Upload", [CreateProductResellerController::class, "create"]);
                Route::get("/Reseller/{produk}/edit", [UpdateProductResellerController::class, "edit"])->name("get-edit-product");
                Route::get("/upload/profil/store", [MerchantResellerController::class, "showProfilStore"]);
                Route::get("text/{notif}/notifReseller", [NotificationController::class, "indexReseller"]);
                Route::get("totalNotifReseller", [NotificationController::class, "totalNotifReseller"]);
    
                //Method Post Member
                Route::post("/add/banner", [BannerController::class, "sendNotifBanner"]);
                Route::post("/Promo", [PromoController::class, "store"]);
                Route::post("/Upload", [CreateProductResellerController::class, "store"]);
                Route::post("/Update/Profil", [ResellerController::class, "updateProfil"]);
                Route::post("/delete/product", [DeleteProductResellerController::class, "destroy"]);
                Route::post("/Reseller/{produk}/Update", [UpdateProductResellerController::class, "update"])->name("post-edit-product");;
                Route::post("/edit/store/{merchant}", [MerchantResellerController::class, "editProfilStore"]);
                Route::post("/upload/store/profil", [MerchantResellerController::class, "uploadProfilStore"]);
            });
    
            //Route Kusus Admin
            Route::middleware('is_admin')->group(function () {
                // Ini harus berfungsi jika semua sudah benar
                //Untuk Method Get Admin
                Route::get("/Admin", [GetAdminController::class, "index"])->name('dashboard.admin');
                Route::get("show/{user}/membership", [GetAdminController::class, "showMembership"]);
                Route::get("/Profil/Admin", [GetAdminController::class, "profil"])->name('profil.admin');
                Route::get("/Total/Product", [GetAdminController::class, "product"])->name('table-product.admin');
                Route::get("/Verified/Admin", [GetAdminController::class, "userConfirm"])->name('user-confirm.admin');
                Route::get("/Account/{user}/active", [GetAdminController::class, "UserVerified"])->name('data-verified.admin');
                Route::get("/Admin/Banner", [BannerController::class, "index"]);
                Route::get("totalNotif", [NotificationController::class, "totalNotif"]);
                Route::get("text/{notif}/notif", [NotificationController::class, "index"]);
                Route::get("/Admin/Product/Unggulan", [UnggulanController::class, "index"]);
    
                //Untuk Method Post Admin
                Route::post("/Verified", [PostAdminController::class, "verified"])->name('post-verified.admin');
                Route::post("/membership", [PostAdminController::class, "membership"])->name('post-membership.admin');
                Route::post("/revisi", [PostAdminController::class, "revisi"])->name('post-revisi.admin');
                Route::post("/change", [PostAdminController::class, "change"])->name('post-changeStatusUser.admin');
                Route::post("/destroyUser", [PostAdminController::class, "destroyUser"])->name('delete.admin');
                Route::post("/Update/Profil/Admin", [PostAdminController::class, "updatePasswordAdmin"])->name('post-updateProfile.admin');
                Route::post("/delete/product/admin", [PostAdminController::class, "deleteProduct"])->name('delete-product.admin');
                Route::post("/store/unggulan", [UnggulanController::class, "store"]);
                Route::post("/delete/notification", [NotificationController::class, "delete"]);
                Route::post("/confirm/banner", [BannerController::class, "store"]);
                Route::post("/delete/banner", [BannerController::class, "destroy"]);
            });
    
        });
    
        Route::middleware('guest')->group(function () {
            Route::get("/login", [AuthController::class, "index"])->name('login');
            Route::post("/login", [AuthController::class, "login"])->name('post-login');
            Route::get("/register", [AuthController::class, "register"])->name('register');
            Route::post("/register", [AuthController::class, "store"])->name('post-register');
            Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('emailVerified');
        });
    });
});



//pembuangan route post ke get
// Route::get("/Reseller/{produk}/Update", [IsAdmin::class, "pembuangan"]);
// Route::get("/Setting/Data", [IsAdmin::class, "pembuangan"]);
// Route::get("/Upload", [IsAdmin::class, "pembuangan"]);
// Route::get("/Update/Profil", [IsAdmin::class, "pembuangan"]);
// Route::get("/upload/store/profil", [IsAdmin::class, "pembuangan"]);
// Route::get("/edit/store/{merchant}", [IsAdmin::class, "pembuangan"]);
// Route::get("/logout", [IsAdmin::class, "pembuangan"]);
// Route::get("/Promo", [IsAdmin::class, "pembuangan"]);

// Route::get("/Verified", [IsAdmin::class, "pembuangan"]);
// Route::get("/membership", [IsAdmin::class, "pembuangan"]);
// Route::get("/change", [IsAdmin::class, "pembuangan"]);
// Route::get("/destroyUser", [IsAdmin::class, "pembuangan"]);
// Route::get("/Update/Profil/Admin", [IsAdmin::class, "pembuangan"]);
// Route::get("/store/unggulan", [IsAdmin::class, "pembuangan"]);
// Route::get("/delete/notification", [IsAdmin::class, "pembuangan"]);
