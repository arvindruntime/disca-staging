<?php

use App\Http\Controllers\Admin\CommentsController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ForumBoardController;
use App\Http\Controllers\Admin\ForumTopicsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebSitePageController;
use App\Http\Controllers\api\v1\BoardController;
use App\Http\Controllers\API\v1\ForumController as V1ForumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', function () {
    return view('index');
});



Route::get('check_email/{email}', [LoginController::class, 'check_email'])->name('check.email.user');
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('verifyOtp', [ForgotPasswordController::class, 'VerifyOtpForm'])->name('verifyOtp');

Route::get('reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('terms', [GeneralController::class, 'terms'])->name('terms');
Route::get('cookie_policy', [GeneralController::class, 'cookie_policy'])->name('cookie_policy');
Route::get('privacy_policy', [GeneralController::class, 'privacy_policy'])->name('privacy_policy');

Route::get('proffesional-care', [GeneralController::class, 'proffesional_care'])->name('proffesional-care');
Route::get('/refresh-data/{id}', [ForumTopicsController::class, 'getRefreshedData'])->name('forum.topics.refresh');

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
/* User Type 3 : normal*/
Route::middleware(['auth', 'user-access:3'])->prefix('forum')->group(function () {
  
    Route::get('home', [HomeController::class, 'index'])->name('forum-user.home');
    Route::get('profile', [HomeController::class, 'forumProfile'])->name('forum.profile');

    Route::controller(ForumController::class)->group(function() {
        Route::get('dashboard' ,'dashboard')->name('forum.user.dashboard');
        Route::get('chat_sample' ,'chat')->name('forum.user.chat_sample');
        Route::get('general-board-list' ,'generalUpdateBoardList')->name('forum.user.general-board-list');
        Route::get('board-topics/{slug}' ,'viewTopics')->name('forum.user.topics');
        Route::get('board-topics/list/{id}' ,'getTopics')->name('forum.user.topics.list');
        // Route::get('discussion' ,'discussion')->name('forum.user.discussion');
        Route::get('add-topic' ,'createTopic')->name('forum.user.add-topic');
        Route::get('board-topic/{id}' ,'forumTopicDetail')->name('forum.user.topic-detail');
    });       
    Route::controller(V1ForumController::class)->group(function() {
        Route::get('discussion' , 'list_forum_boards')->name('forum.user.discussion');
    }); 
    
    Route::controller(ChatController::class)->group(function() {
        Route::get('test_chat', 'testmsgsequence');
        Route::get('chat', 'index')->name('forum.user.chat');
        Route::post('chat/images', 'storeChatImage')->name('chat.storeMedia');
        Route::get('chat_message/{id}' ,'showChatMessage')->name('chat.message');
        Route::post('chat/encodestring',  'encodeString')->name('chat.encodestring');
        Route::post('chat/decodestring', 'decodeString')->name('chat.decodestring');
        Route::post('chat/creategroup', 'storeGroup')->name('chat.creategroup');
        Route::get('chat/getgroups', 'getGroups')->name('all.groups');
        Route::get('group/{id}/show', 'groupChat')->name('group.chat');
        Route::post('chat/deletegroup', 'deleteGroup')->name('chat.deletegroup');
        Route::post('chat/joinmember','JoinMember')->name('chat.joinmember');
        Route::post('chat/removemember', 'RemoveMember')->name('chat.removemember');
        Route::post('chat/updategroup', 'updateGroup')->name('chat.updategroup');
        Route::post('chat/leavegroup', 'leaveGroup')->name('chat.leavegroup');
     });
    
});



/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
/* User Type 1 : admin*/
Route::middleware(['web', 'user-access:1'])->prefix('admin')->group(function () {
  
    Route::get('home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('profile', [HomeController::class, 'adminProfile'])->name('admin.profile');

    Route::resource('users', UserController::class,[
        'names' => [
            'index' => 'admin.users',
        ]
    ]);
    Route::get('userList', [UserController::class, 'userList'])->name('user.userList');
    Route::prefix('forum')->group(function () {
        Route::prefix('boards')->group(function () {
            Route::get('/', [ForumBoardController::class, 'index'])->name('admin.forum.board');
            Route::get('/list', [ForumBoardController::class, 'getBoardList'])->name('admin.forum.board.list');
            Route::get('/members/list', [ForumBoardController::class, 'getMembersList'])->name('admin.forum.board.members.list');
            Route::get('/add', [ForumBoardController::class, 'addNewBoard'])->name('admin.forum.board.add');
            Route::get('/edit/{slug}', [ForumBoardController::class, 'editBoard'])->name('admin.forum.board.edit');
        });
        Route::prefix('topics')->group(function () {
            Route::get('/', [ForumTopicsController::class, 'index'])->name('admin.forum.topics');
            Route::get('/add', [ForumTopicsController::class, 'addNewTopic'])->name('admin.forum.topics.add');
            Route::get('/list', [ForumTopicsController::class, 'getTopicList'])->name('admin.forum.topics.list');
            Route::get('/view/{id}', [ForumTopicsController::class, 'viewTopic'])->name('admin.forum.topics.view');
            Route::get('/edit/{id}', [ForumTopicsController::class, 'editTopic'])->name('admin.forum.topics.edit');
            Route::get('/add', [ForumTopicsController::class, 'addTopic'])->name('admin.forum.topics.add');
        });
        Route::prefix('comments')->group(function () {
            Route::get('/', [CommentsController::class, 'index'])->name('admin.forum.comments');
            Route::get('/list', [CommentsController::class, 'list'])->name('admin.forum.comments.list');
            Route::get('/edit/{id}', [CommentsController::class, 'editComment'])->name('admin.forum.comments.edit');
       });
    });

    Route::prefix('pages')->group(function () {
        Route::get('/', [WebSitePageController::class, 'index'])->name('admin.pages');
        Route::get('/list', [WebSitePageController::class, 'getPages'])->name('admin.pages.list');
        Route::get('/add', [WebSitePageController::class, 'addPage'])->name('admin.pages.add');
        Route::get('/{slug}', [WebSitePageController::class, 'editPage'])->name('admin.forum.edit');
    });
    // Route::resource('admin/slote', SlotsController::class);
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
/* User Type 2 : provider*/
Route::middleware(['auth', 'user-access:2'])->prefix('provider')->group(function () {
  
    Route::get('home', [HomeController::class, 'providerHome'])->name('provider.home');
});

/*------------------------------------------
--------------------------------------------
All End Users Routes List
--------------------------------------------
--------------------------------------------*/
/* User Type 3 : normal*/
Route::middleware(['auth', 'user-access:3'])->prefix('user')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('home', [HomeController::class, 'index'])->name('user.home');
    Route::get('updateProfile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::post('storeProduct', [ProductController::class, 'store'])->name('user.storeProduct');
    Route::get('product', [ProductController::class, 'create'])->name('user.product');
});

Route::get('/{slug}', [GeneralController::class, 'getPage']);