@props(['post'])

<div class="border border-gray-500 p-3 space-y-2">
    <div>
        <x-profile-card :user="$post->author" />
        <div>
            {{ $post->content }}
        </div>
    </div>
    <div>
        <img src={{ $post->photo }} alt="" width="100%" height="100%" class="object-cover">
    </div>
    <div class="flex justify-between">
        <div x-data="{ liked: false }">
            0
            <button x-on:click="liked = ! liked"> <i x-bind:class="liked ? 'fas fa-heart text-red-500' : 'far fa-heart'"></i> </button>
        </div>
        <div>
            0 comments
        </div>
        <div>
            0 shares
        </div>
    </div>
    <hr>
    <div class="flex justify-around">
        <div>
            <i class="fas fa-comments"></i> Comment
        </div>
        <div>
            <i class="fas fa-share"></i> Share
        </div>
    </div>
</div>