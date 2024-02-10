<?php

use App\Models\ForumLikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\CareController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\BoardController;
use App\Http\Controllers\API\v1\ForumController;
use App\Http\Controllers\API\v1\ReplyController;
use App\Http\Controllers\API\v1\CmsPageController;
use App\Http\Controllers\API\v1\CountryController;
use App\Http\Controllers\API\v1\RegisterController;
use App\Http\Controllers\API\v1\ForumLikesController;
use App\Http\Controllers\API\v1\ForumTopicController;
use App\Http\Controllers\api\v1\ApplyForCareController;
use App\Http\Controllers\api\v1\NotificationController;
use App\Http\Controllers\api\v1\RelationshipController;
use App\Http\Controllers\API\v1\WebsitePagesController;
use App\Http\Controllers\API\v1\ForumCommentsController;
use App\Http\Controllers\API\v1\TopicCommentsController;
use App\Http\Controllers\API\v1\NotificationDetailController;

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
Route::group(['namespace' => 'API/v1'], function() {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [RegisterController::class, 'login'])->name('auth.login');

    /** Forgot Password API */
    Route::any('request_otp', [AuthController::class, 'requestOtp']);
    Route::any('resend_otp', [AuthController::class, 'resendOtp']);
    Route::post('verify_otp', [AuthController::class, 'verifyOtp']);
    Route::post('forgot_password',  [UserController::class, 'forgotPassword'])->name('auth.forgotPassword');

     /** Reset Password API */
    Route::post('reset_password', [UserController::class, 'resetPassword'])->name('auth.resetPassword');
    
     /*microsoft_2fa*/
     Route::post('match_password',[UserController::class, 'match_password']);
     Route::post('microsoft_change_status',[UserController::class, 'change_microsoft_2fa_status']);
     Route::get('check_microsoft_2fa_status/{user_id}',[UserController::class, 'check_microsoft_2fa_status']);

     // Cms Page API
    Route::get('cms_pages', [CmsPageController::class, 'cmsPages']);
});
    
Route::group(['middleware' => ['auth:api'], ['namespace' => 'API/v1']], function() {
    
    // User Profile Route
    Route::post('update_profile', [UserController::class, 'update_profile'])->name('auth.UpdateProfile');;
    Route::post('update_admin_profile', [UserController::class, 'update_admin_profile'])->name('auth.adimn.UpdateProfile');;
    Route::post('profile', [UserController::class, 'profile'])->name('auth.profile');
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('change_notification_status', [UserController::class, 'change_notification_status']);
    Route::post('change_email_status', [UserController::class, 'change_email_status']);
    Route::post('change_password', [UserController::class, 'resetPassword'])->name('auth.resetPassword');
    Route::get('profile_forum_board/{id}', [UserController::class, 'profile_forum_board']);
    Route::get('profile_image_delete/{id}', [UserController::class, 'profile_image_delete'])->name('profile_image_delete');

    // Forum Route
    Route::get('list_forum_boards', [ForumController::class, 'list_forum_boards']);
    // Route::post('store_forum', [ForumController::class, 'store_forum']);
    // Route::get('edit_forum/{id}', [ForumController::class, 'edit_forum']);
    // Route::post('update_forum/{id}', [ForumController::class, 'update_forum']);
    // Route::delete('delete_forum/{id}', [ForumController::class, 'delete_forum']);

    // Forum Topic Route
    Route::get('list_topic', [ForumTopicController::class, 'list_topic']);
    Route::get('topic_show/{id}', [ForumTopicController::class, 'show']);
    Route::post('store_topic', [ForumTopicController::class, 'store_topic']);
    Route::post('edit_topic/{id}', [ForumTopicController::class, 'edit_topic']);
    Route::post('update_topic/{id}', [ForumTopicController::class, 'update_topic']);
    Route::get('delete_topic/{id}', [ForumTopicController::class, 'delete_topic']);
    Route::get('following_topic_list', [ForumTopicController::class, 'followingTopicList']);

    //Topic Comments Route
    // Route::get('list_comment', [TopicCommentsController::class, 'list_comment']);
    // Route::post('store_comment', [TopicCommentsController::class, 'store_comment']);
    // Route::get('edit_comment/{id}', [TopicCommentsController::class, 'edit_comment']);
    // Route::post('update_comment/{id}', [TopicCommentsController::class, 'update_comment']);
    // Route::delete('delete_comment/{id}', [TopicCommentsController::class, 'delete_comment']);

    Route::controller(TopicCommentsController::class)->group(function() {
        Route::get('topic/{topic}/topic_comments', 'index');
        Route::post('topic/{topic}/topic_comment', 'store');
        Route::delete('topic/{topic}/topic_comment/{topicComment}', 'destroy');
        Route::delete('attechment/{id}', 'delteAttechment');
    });

    // Forum Topic Comments Reply Route
    Route::get('list_reply', [ReplyController::class, 'list_reply']);
    Route::post('store_reply', [ReplyController::class, 'store_reply']);
    Route::get('edit_reply/{id}', [ReplyController::class, 'edit_reply']);
    Route::post('update_reply/{id}', [ReplyController::class, 'update_reply']);
    Route::delete('delete_reply/{id}', [ReplyController::class, 'delete_reply']);

    // Forum Topic Like Route
    Route::controller(ForumLikesController::class)->group(function(){
        Route::get('list_like', 'list_like');
        Route::post('topic_comment_like', 'TopicCommentLike');
    });

    //Get All Masters

    //Forum board
    Route::controller(BoardController::class)->group(function(){
        Route::get('get_board', 'index'); 
        Route::get('board_name_list', 'forumBoardNameList');
        Route::get('board/{id}', 'show'); 
        Route::post('board', 'store');
        Route::delete('board/{id}', 'destroy');
        Route::post('board/{id}', 'update');
        Route::get('forum_board_topic/{id?}', 'forumBoardtopic');
        Route::post('follow_topic','followTopic');
        Route::post('unfollow_topic','unfollowTopic');
        Route::post('follow_board','followBoard')->name('follow.board');
        Route::post('unfollow_board', 'unfollowBoard')->name('unfollow.board');
    });

    //Relationship API
    Route::controller(RelationshipController::class)->group(function(){
        Route::get('get_relationship', 'index');
        Route::get('relationship/{id}', 'show');
        Route::post('relationship', 'store');
        Route::post('relationship/{id}', 'update');
        Route::delete('relationship/{id}', 'destroy');
    });

    //Country API
    Route::controller(CountryController::class)->group(function(){
        Route::get('countries', 'index');
    });

    //Required Care API
    Route::controller(CareController::class)->group(function(){
        Route::get('get_care', 'index');
        Route::get('care/{id}', 'show');
        Route::post('care', 'store');
        Route::post('care/{id}', 'update');
        Route::delete('care/{id}', 'destroy');
    });

    //Notification Api
    Route::controller(NotificationController::class)->group(function(){
        Route::get('notifications', 'index');
        Route::post('notification', 'store');
        Route::get('notification/{id}', 'show');
        Route::post('notification/{id}', 'update');
        Route::delete('notification/{id}', 'destroy');
    });

    /** Notification Detail API */
    Route::controller(NotificationDetailController::class)->group(function() {
        Route::get('notification_details', 'index');
        Route::post('notification_detail', 'store');
        Route::get('notification_detail/{id}', 'show');
        Route::post('notification_detail/{id}', 'update');
        Route::delete('notification_detail/{id}', 'destroy');
        Route::get('change_status', 'changeStatus');
        Route::get('edit_notification_setting', 'notificationSetting');
    });

    // Apply For care API
    Route::controller(ApplyForCareController::class)->group(function () {
        Route::post('applye_for_care', 'store');
    });

    // Web pages API
    Route::controller(WebsitePagesController::class)->group(function () {
        Route::get('get_pages', 'index');
        Route::get('pages/{slug}', 'show');
        Route::post('pages', 'store');
        Route::delete('pages/{slug}', 'destroy');
        Route::post('pages/{slug}', 'store');
    });
    
    
    //// Chat Routes
    Route::controller(ChatController::class)->group(function() {
        Route::get('chat', 'index');
        Route::post('chat/images', 'storeChatImage');
        Route::get('chat_message/{id}' ,'showChatMessage');
        Route::post('store_message', 'storeMessage');
        Route::post('update_message_status', 'updateMessageStatus');
        Route::post('find_vendor_user_sockets' ,'findVendorUserSockets');
        Route::get('find_user_socket/{user_id}' ,'findUserSocket');
        
        Route::post('user_onnection', 'userConnection');
        Route::get('delete_connection/{socket_id}' ,'deleteConnection');
        
        
    });
});
