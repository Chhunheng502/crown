<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChatController;
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

    // might need some change
    Route::get('/fetchPosts/{initialVal}/{endVal}', [PostController::class, 'getAllPosts']);
    Route::get('/fetchUserPosts/{user_id}', [PostController::class, 'getUserPosts']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    Route::get('/fetchCountShares/{post_id}', [ShareController::class, 'countShares']);
    Route::post('/shares', [ShareController::class, 'store']);
    Route::put('/shares/{id}', [ShareController::class, 'update']);
    Route::delete('/shares/{id}', [ShareController::class, 'delete']);

    Route::get('/chats', [ChatController::class, 'index'])->name('chat');
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/fetchMessages/{user_id}', [ChatController::class, 'getMessages']);
    Route::post('/sendMessage', [ChatController::class, 'sendMessage']);

    // need adjustment to the frontend design
    Route::post('/fetchLikes', [LikeController::class, 'getLikes']);
    Route::post('/isLiked', [LikeController::class, 'isLiked']);
    Route::post('/likePost', [LikeController::class, 'store']);
    Route::post('/unlikePost', [LikeController::class, 'destroy']);

    Route::post('/fetchComments', [CommentController::class, 'getComments']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'delete']);

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
