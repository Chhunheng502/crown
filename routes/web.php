<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivateMsgController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/', function () {
        return Inertia::render('Home/Home', [
            'user' => Auth::user(),
        ]);
    })->name('home');

    Route::get('/fetchFriends', [FriendshipController::class, 'fetchFriends']);
    Route::post('/addFriend', [FriendshipController::class, 'addFriend']);
    Route::post('/unfriend', [FriendshipController::class, 'unfriend']);
    Route::post('/isFriend', [FriendshipController::class, 'isFriend']);
    Route::get('/fetchFriendRequests', [FriendshipController::class, 'fetchFriendRequests']);
    Route::post('/acceptFriendRequest', [FriendshipController::class, 'acceptFriendRequest']);
    Route::post('/deleteFriendRequest', [FriendshipController::class, 'deleteFriendRequest']);

    Route::get('/fetchPosts/{initialVal}/{endVal}', [PostController::class, 'fetchPosts']);
    Route::post('/fetchUserPosts', [PostController::class, 'fetchUserPosts']);
    Route::post('/createPost', [PostController::class, 'createPost']);
    Route::post('/editPost', [PostController::class, 'editPost']);
    Route::post('/deletePost', [PostController::class, 'deletePost']);

    Route::post('/fetchShares', [ShareController::class, 'fetchShares']);
    Route::post('/sharePost', [ShareController::class, 'sharePost']);
    Route::post('/editShare', [ShareController::class, 'editShare']);
    Route::post('/deleteShare', [ShareController::class, 'deleteShare']);

    Route::get('/chat', [PrivateMsgController::class, 'index'])->name('chat');
    Route::post('/createChat', [PrivateMsgController::class, 'createChat']);
    Route::post('/fetchMessages', [PrivateMsgController::class, 'fetchMessages']);
    Route::post('/sendMessage', [PrivateMsgController::class, 'sendMessage']);

    Route::post('/fetchLikes', [LikeController::class, 'fetchLikes']);
    Route::post('/likePost', [LikeController::class, 'likePost']);
    Route::post('/unlikePost', [LikeController::class, 'unlikePost']);
    Route::post('/isLiked', [LikeController::class, 'isLiked']);

    Route::post('fetchComments', [CommentController::class, 'fetchComments']);
    Route::post('storeComment', [CommentController::class, 'storeComment']);
    Route::post('deleteComment', [CommentController::class, 'deleteComment']);
    Route::post('editComment', [CommentController::class, 'editComment']);

    Route::post('/fetchRepliedComments', [CommentReplyController::class, 'fetchRepliedComments']);
    Route::post('/replyComment', [CommentReplyController::class, 'replyComment']);
    Route::post('/editRepliedComment', [CommentReplyController::class, 'editRepliedComment']);
    Route::post('/deleteRepliedComment', [CommentReplyController::class, 'deleteRepliedComment']);

    Route::get('/profiles', [UserController::class, 'index']);
    Route::post('/updateProfile', [UserController::class, 'updateProfile']);
    Route::post('/updateCover', [UserController::class, 'updateCover']);
    Route::post('updateUserDetail', [UserController::class, 'updateDetail']);

    Route::get('/fetchSearchableData', function() {

        $users = App\Models\User::all();

        $posts = App\Models\Post::all();

        return [...$users, ...$posts];
    });

    Route::get('/fetchNotifications', function() {

        return [
            'notifications' => Auth::user()->notifications,
            'unreadNotifications' => Auth::user()->unreadNotifications,
        ];
    });

    Route::post('/markNotifications', function() {

        Auth::user()->unreadNotifications->markAsRead();

        return ['status' => 'success'];
    });
});

require __DIR__.'/auth.php';
