<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivateMsgController;
use App\Http\Controllers\ShareController;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/', function () {
        return Inertia::render('Home/Home', [
            'user' => Auth::user(),
        ]);
    })->name('home');
});

Route::get('/fetchFriends', [FriendshipController::class, 'fetchFriends']);
Route::post('/addFriend', [FriendshipController::class, 'addFriend']);
Route::post('/unfriend', [FriendshipController::class, 'unfriend']);
Route::post('/isFriend', [FriendshipController::class, 'isFriend']);
Route::get('/fetchFriendRequests', [FriendshipController::class, 'fetchFriendRequests']);
Route::post('/acceptFriendRequest', [FriendshipController::class, 'acceptFriendRequest']);
Route::post('/deleteFriendRequest', [FriendshipController::class, 'deleteFriendRequest']);

Route::get('/fetchPosts', [PostController::class, 'fetchPosts']);
Route::post('/fetchUserPosts', [PostController::class, 'fetchUserPosts']);
Route::post('/createPost', [PostController::class, 'createPost']);
Route::post('/editPost', [PostController::class, 'editPost']);
Route::post('/deletePost', [PostController::class, 'deletePost']);

Route::post('/getShares', [ShareController::class, 'getShares']);
Route::post('/sharePost', [ShareController::class, 'sharePost']);
Route::post('/editShare', [ShareController::class, 'editShare']);
Route::post('/deleteShare', [ShareController::class, 'deleteShare']);

Route::post('/updateProfile', [PostController::class, 'updateProfile']);
Route::post('/updateCover', [PostController::class, 'updateCover']);

Route::get('/chat', [PrivateMsgController::class, 'index'])->name('chat');
Route::post('/createChat', [PrivateMsgController::class, 'createChat']);
Route::post('/fetchMessages', [PrivateMsgController::class, 'fetchMessages']);
Route::post('/sendMessage', [PrivateMsgController::class, 'sendMessage']);

Route::post('/getLikes', [LikeController::class, 'getLikes']);
Route::post('/likePost', [LikeController::class, 'likePost']);
Route::post('/unlikePost', [LikeController::class, 'unlikePost']);
Route::post('/isLiked', [LikeController::class, 'isLiked']);

Route::post('fetchComments', [CommentController::class, 'fetchComments']);
Route::post('storeComment', [CommentController::class, 'storeComment']);
Route::post('deleteComment', [CommentController::class, 'deleteComment']);
Route::post('editComment', [CommentController::class, 'editComment']);

Route::post('/fetchRepliedComments', [CommentController::class, 'fetchRepliedComments']);
Route::post('/replyComment', [CommentController::class, 'replyComment']);
Route::post('/editRepliedComment', [CommentController::class, 'editRepliedComment']);
Route::post('/deleteRepliedComment', [CommentController::class, 'deleteRepliedComment']);

Route::get('/fetchSearchableData', function() {

    $users = App\Models\User::all();

    $posts = App\Models\Post::all();

    return [...$users, ...$posts];
});

Route::get('/profiles', function() {

    return Inertia::render('Profile/Profile', [
        'user' => Auth::user(),
        'friend' => User::latest()->filter(
            request(['search', 'posts'])
        )->get()[0]
    ]);
});

Route::post('updateUserDetail', function(Request $request) {

    $user_detail = UserDetail::find($request->id);

    $user_detail->work = $request->work;
    $user_detail->place_lived = $request->place_lived;
    $user_detail->birth_date = $request->birth_date;

    $user_detail->save();

    return ['status' => 'success'];
});