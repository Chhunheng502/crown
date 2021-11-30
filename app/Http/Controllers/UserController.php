<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{    
    public function index() {
        return Inertia::render('Profile/Profile', [
            'user' => Auth::user(),
            'friend' => User::latest()->filter(
                request(['search', 'post', 'share'])
            )->get()[0]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->user_id);

        $user->profile_photo_path = $request->file('photo')->store('images', ['disk' => 'public']);

        $user->save();

        $post = new Post();

        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->photo = $user->profile_photo_path;

        $post->save();

        return ['status' => 'success'];
    }

    public function updateCover(Request $request)
    {
        $user_detail = UserDetail::find($request->id);

        $user_detail->cover = $request->file('photo')->store('images', ['disk' => 'public']);

        $user_detail->save();

        $post = new Post();

        $post->user_id = $user_detail->user_id;
        $post->content = $request->content;
        $post->photo = $user_detail->cover;

        $post->save();

        return ['status' => 'success'];
    }

    public function updateDetail(Request $request) {

        $user_detail = UserDetail::find($request->id);
    
        $user_detail->work = $request->work;
        $user_detail->place_lived = $request->place_lived;
        $user_detail->birth_date = $request->birth_date;
    
        $user_detail->save();
    
        return ['status' => 'success'];
    }
}
