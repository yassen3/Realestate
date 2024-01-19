<?php

use App\Models\PropertyType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\frontend\WishListController;
use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\PropertyTypeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class,'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/user/profile', [UserController::class,'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store',[UserController::class,'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout',[UserController::class,'UserLogout'])->name('user.logout');
    Route::get('user/change/password',[UserController::class,'UserChangePassword'])->name('user.change.password');
    Route::post('user/password/update',[UserController::class,'UserPasswordUpdate'])->name('user.password.update');

    Route::get('user/schedule/request',[UserController::class,'UserScheduleRequest'])->name('user.schedule.request');


    // user wishlist all routes
    Route::controller(WishListController::class)->group(function(){
        Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
        Route::get('/get-wishlist-property', 'GetWishlistProperty');
        Route::get('/wishlist-remove/{id}', 'WishlistRemove');


    });
    // user Compare all routes
    Route::controller(CompareController::class)->group(function(){
        Route::get('/user/compare', 'UserCompare')->name('user.compare');
        Route::get('/get-compare-property', 'GetCompareProperty');
        Route::get('/compare-remove/{id}', 'compareRemove');

    });
});

require __DIR__.'/auth.php';
// Admin Group Middleware
Route::middleware(['auth','roles:admin'])->group(function(){
Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('AdminDashboard');

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');




}); //End Group Admin
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::get('/agent/login',[AgentController::class,'AgentLogin'])->name('agent.login');

Route::post('/agent/register',[AgentController::class,'AgentRegister'])->name('agent.register');


// Agent Group Middleware
Route::middleware(['auth','roles:agent'])->group(function(){
Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('AgentDashboard');
Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');
Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');
Route::get('/agent/change/password', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
Route::post('/agent/update/password', [AgentController::class, 'AgentUpdatePassword'])->name('agent.update.password');

});  //End Group Agent


Route::middleware(['auth','roles:admin'])->group(function(){

    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/type', 'AllType')->name('all.type')->middleware('permission:all.type');
        Route::get('/add/type', 'AddType')->name('add.type')->middleware('permission:add.type');
        Route::post('/store/type', 'StoreType')->name('store.type');
        Route::get('/edit/type/{id}', 'EditType')->name('edit.type')->middleware('permission:edit.type');
        Route::post('/update/type', 'UpdateType')->name('update.type');
        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type')->middleware('permission:delete.type');

    });
      //Amenities Routes
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/amenities', 'AllAmenities')->name('all.amenities')->middleware('permission:all.amenities');
        Route::get('/add/amenities', 'AddAmenities')->name('add.amenities')->middleware('permission:add.amenities');
        Route::post('/store/amenities', 'StoreAmenities')->name('store.amenities');
        Route::get('/edit/amenities/{id}', 'EditAmenities')->name('edit.amenities')->middleware('permission:edit.amenities');
        Route::post('/update/amenities', 'UpdateAmenities')->name('update.amenities');
        Route::get('/delete/amenities/{id}', 'DeleteAmenities')->name('delete.amenities')->middleware('permission:delete.amenities');

    });

     // Property All Routes
    Route::controller(PropertyController::class)->group(function(){
        Route::get('/all/property', 'AllProperty')->name('all.properties')->middleware('permission:all.property');
        Route::get('/add/properties', 'AddProperties')->name('add.properties')->middleware('permission:add.property');
        Route::post('/store/properties', 'StoreProperties')->name('store.properties');
        Route::get('/edit/properties/{id}', 'EditProperties')->name('edit.properties')->middleware('permission:edit.property');
        Route::post('/update/properties', 'UpdateProperties')->name('update.properties');
        Route::post('/update/properties/thambnail', 'UpdatePropertiesThambnail')->name('update.properties.thambnail');
        Route::post('/update/properties/multiimage', 'UpdatePropertiesMultiimage')->name('update.properties.multiimage');
        Route::get('/delete/properties/multiimage/{id}', 'DeletePropertiesMultiimage')->name('delete.properties.multiimage')->middleware('permission:delete.property');
        Route::post('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');
        Route::post('/update/properties/facilities', 'UpdatePropertyFacilities')->name('update.properties.facilities');
        Route::get('/delete/properties/{id}', 'DeleteProperties')->name('delete.properties')->middleware('permission:delete.property');
        Route::get('/details/properties/{id}', 'DetailsProperties')->name('details.properties');
        Route::post('/inactive/properties','InactiveProperties')->name('inactive.properties');
        Route::post('/active/properties','activeProperties')->name('active.properties');
        Route::get('/admin/package/history','AdminPackageHistory')->name('admin.package.history');
        Route::get('/package/invoice/{id}','PackageInvoice')->name('package.invoice');
        Route::get('/admin/property/message','AdminPropertyMessage')->name('admin.property.message');
        Route::get('/admin/message/details/{id}','AdminMessageDetails')->name('admin.message.details');



        // Route::get('/delete/amenities/{id}', 'DeleteAmenities')->name('delete.amenities');

    });
    // Agent All Routes From Admin
    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/agent', 'AllAgent')->name('all.agent')->middleware('permission:all.agent');
        Route::get('/add/agent', 'AddAgent')->name('add.agent')->middleware('permission:add.agent');
        Route::post('/store/agent', 'StoreAgent')->name('store.agent');
        Route::get('/edit/agent,{id}', 'EditAgent')->name('edit.agent')->middleware('permission:edit.agent');
        Route::post('/update/agent', 'UpdateAgent')->name('update.agent');
        Route::get('/delete/agent/{id}', 'DeleteAgent')->name('delete.agent')->middleware('permission:delete.agent');
        Route::get('/changeStatus', 'changeStatus');
    });

    // State All Controller
Route::controller(StateController::class)->group(function(){
    Route::get('/all/state', 'AllState')->name('all.state')->middleware('permission:state.all');
    Route::get('/add/state', 'AddState')->name('add.state')->middleware('permission:state.add');
    Route::post('/store/state', 'StoreState')->name('store.state');
    Route::get('/edit/state/{id}', 'EditState')->name('edit.state')->middleware('permission:state.edit');
    Route::post('/update/state', 'UpdateState')->name('update.state');
    Route::get('/delete/tystatepe/{id}', 'DeleteState')->name('delete.state')->middleware('permission:state.delete');

});
  //Testimonials All Routes
Route::controller(TestimonialController::class)->group(function(){
    Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials')->middleware('permission:all.testimonial');
    Route::get('/add/testimonials', 'AddTestimonials')->name('add.testimonials')->middleware('permission:add.testimonial');
    Route::post('/store/testimonials', 'StoreTestimonials')->name('store.testimonials');
    Route::get('/edit/testimonials/{id}', 'EditTestimonials')->name('edit.testimonials')->middleware('permission:edit.testimonial');
    Route::post('/update/testimonials', 'UpdateTestimonials')->name('update.testimonials');
    Route::get('/delete/testimonials/{id}', 'DeleteTestimonials')->name('delete.testimonials')->middleware('permission:delete.testimonial');

});

  //Blog Category All Routes
  Route::controller(BlogController::class)->group(function(){
    Route::get('/all/blog/category', 'AllBlogCategory')->name('all.blog.category');
    Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
    Route::get('/blog/category/{id}', 'EditBlogCategory');
    Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');

});
// Blog Posts All Routes
Route::controller(BlogController::class)->group(function(){
    Route::get('/all/post', 'AllPost')->name('all.post')->middleware('permission:all.post');
    Route::get('/add/post', 'AddPost')->name('add.post')->middleware('permission:add.post');
    Route::post('/store/post', 'StorePost')->name('store.post');
    Route::get('/edit/post/{id}', 'EditPost')->name('edit.post')->middleware('permission:edit.post');
    Route::post('/update/post', 'UpdatePost')->name('update.post');
    Route::get('/delete/post/{id}', 'DeletePost')->name('delete.post')->middleware('permission:delete.post');

});

Route::controller(SettingController::class)->group(function(){
    Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting')->middleware('permission:smtp.menu');
    Route::post('/update/smpt/setting', 'UpdateSmtpSetting')->name('update.smpt.setting');


});

Route::controller(SettingController::class)->group(function(){
    Route::get('/site/setting', 'SiteSetting')->name('site.setting')->middleware('permission:site.menu');
    Route::post('/update/site/setting', 'UpdateSiteSetting')->name('update.site.setting');


});
  // Permission All Routes
  Route::controller(RoleController::class)->group(function(){

    Route::get('/all/permission', 'AllPermission')->name('all.permission')->middleware('permission:all.permission');
    Route::get('/add/permission', 'AddPermission')->name('add.permission')->middleware('permission:add.permission');
    Route::post('/store/permission', 'StorePermission')->name('store.permission');
    Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission')->middleware('permission:edit.permission');
    Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
    Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission')->middleware('permission:delete.permission');


    Route::get('/import/permission', 'ImportPermission')->name('import.permission');
     Route::get('/export', 'Export')->name('export');
     Route::post('/import', 'Import')->name('import');

    Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission')->middleware('permission:add.roles.permission');
    Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
    Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('permission:all.roles.permission');
    Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles')->middleware('permission:edit.roles.permission');
    Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
    Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles')->middleware('permission:delete.roles.permission');

});

// Roles All Routes
Route::controller(RoleController::class)->group(function(){
    Route::get('/all/role', 'AllRole')->name('all.role')->middleware('permission:all.role');
    Route::get('/add/role', 'AddRole')->name('add.role')->middleware('permission:add.role');
    Route::post('/store/role', 'StoreRole')->name('store.role');
    Route::get('/edit/role/{id}', 'EditRole')->name('edit.role')->middleware('permission:edit.role');
    Route::post('/update/role', 'UpdateRole')->name('update.role');
    Route::get('/delete/role/{id}', 'DeleteRole')->name('delete.role')->middleware('permission:delete.role');



});

// Admin User All Route
Route::controller(AdminController::class)->group(function(){

    Route::get('/all/admin', 'AllAdmin')->name('all.admin')->middleware('permission:all.admin');
    Route::get('/add/admin', 'AddAdmin')->name('add.admin')->middleware('permission:add.admin');
    Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
    Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin')->middleware('permission:edit.admin');
    Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
    Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin')->middleware('permission:delete.admin');
});

});  // End Group Admin Middleware

Route::middleware(['auth','roles:agent'])->group(function(){
Route::controller(AgentPropertyController::class)->group((function(){
   Route::get('/agent/all/properties','AgentAllProperties')->name('agent.all.properties');
   Route::get('/agent/add/properties','AgentAddProperties')->name('agent.add.properties');
   Route::post('/agent/store/properties','AgentStoreProperties')->name('agent.store.properties');
   Route::get('/agent/edit/properties/{id}','AgentEditProperties')->name('agent.edit.properties');
   Route::post('/agent/update/properties','AgentUpdateProperties')->name('agent.update.properties');
   Route::post('/agent/update/properties/thambnail','AgentUpdatePropertiesThambnail')->name('agent.update.properties.thambnail');
   Route::post('/agent/update/properties/multiimage','AgentUpdatePropertiesMultiimage')->name('agent.update.properties.multiimage');
   Route::get('/agent/delete/properties/multiimage/{id}','AgentDeletePropertiesMultiimage')->name('agent.delete.properties.multiimage');
   Route::post('/agent/store/new/multiimage','AgentStoreNewMultiimage')->name('agent.store.new.multiimage');
   Route::post('/agent/update/properties/facilities','AgentUpdatePropertiesFacilities')->name('agent.update.properties.facilities');
   Route::get('/agent/details/properties/{id}','AgentDetailsProperties')->name('agent.details.properties');
   Route::get('/agent/delete/properties/{id}','AgentDeleteProperties')->name('agent.delete.properties');
   Route::get('/agent/property/message','AgentPropertyMessage')->name('agent.property.message');
   Route::get('/agent/message/details/{id}', 'AgentMessageDetails')->name('agent.message.details');
   // Schedule Request
   Route::get('/agent/schedule/request','AgentScheduleRequest')->name('agent.schedule.request');
   // Agent schedule details page
   Route::get('/agent/details/schedule/{id}','AgentDetailsSchedule')->name('agent.details.schedule');
   // Agent Update Page
   Route::post('/agent/update/schedule','AgentUpdateSchedule')->name('agent.update.schedule');



}));
Route::controller(AgentPropertyController::class)->group(function(){
    Route::get('/buy/package', 'BuyPackage')->name('buy.package');
    Route::get('/buy/buisness/plan', 'BuyBuisnessPlan')->name('buy.buisness.plan');
    Route::post('/store/buisness/plan', 'StoreBuisnessPlan')->name('store.buisness.plan');

    Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
    Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');
    Route::get('/history/package', 'HistoryPackage')->name('history.package');
    Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');



});

    });  //End Group Agent

  // Frontend Property Details All Routes
 Route::get('/property/details/{id}/{slug}',[IndexController::class,'PropertyDetails']);
 // Wishlist Add Route
 Route::post('/add-to-wishList/{property_id}',[WishListController::class,'AddToWishList']);
// Wishlist Add Route
Route::post('/add-to-compare/{property_id}',[CompareController::class,'AddToCompare']);
// Send Message from Property Details Page
Route::post('/property/message',[IndexController::class,'PropertyMessage'])->name('property.message');
// Agent Details in Frontend
Route::get('/agent/details/{id}',[IndexController::class,'AgentDetails'])->name('agent.details');
// Send Message From Agent Details Page to Agent
Route::post('/agent/details/message',[IndexController::class,'AgentDetailsMessage'])->name('agent.details.message');
// Get All Rent Property From Agent Details
Route::get('rent/property',[IndexController::class,'RentProperty'])->name('rent.property');
// Get All Buy Property From Agent Details
Route::get('buy/property',[IndexController::class,'BuyProperty'])->name('buy.property');
// Get All  Property Type Data From Home Page
Route::get('property/type/{id}',[IndexController::class,'PropertyType'])->name('property.type');
// Get State Details
Route::get('state/details/{id}',[IndexController::class,'StateDetails'])->name('state.details');
//  Home Page Buy Property Search
Route::post('buy/property/search',[IndexController::class,'BuyPropertySearch'])->name('buy.property.search');
//  Home Page Rent Property Search
Route::post('rent/property/search',[IndexController::class,'RentPropertySearch'])->name('rent.property.search');
// All Property Search
Route::post('all/property/search',[IndexController::class,'AllPropertySearch'])->name('all.property.search');
// Get Blog Details
Route::get('blog/details/{slug}',[BlogController::class, 'BlogDetails']);
// Get Blog cat list
Route::get('blog/cat/list/{id}',[BlogController::class, 'BlogCatList']);
Route::get('blog',[BlogController::class, 'BlogList'])->name('blog.list');
// blog store comment
Route::post('store/comment',[BlogController::class, 'StoreComment'])->name('store.comment');
// admin blog comment
Route::get('admin/blog/comment',[BlogController::class, 'AdminBlogComment'])->name('admin.blog.comment');
//admin blog comment replay page
Route::get('admin/comment/replay/{id}',[BlogController::class, 'AdminCommentReplay'])->name('admin.comment.replay');
//store replay message
Route::post('/replay/message/',[BlogController::class, 'ReplayMessage'])->name('replay.message');
// send Schedule Message
Route::post('/store/schedule/',[IndexController::class, 'StoreSchedule'])->name('store.schedule');