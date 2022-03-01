@props(['user'])

<div class="flex items-center space-x-2">
    <div>
        <img src={{ $user->detail->picture ?? '' }} class="rounded-full w-12 h-12 object-cover" alt="">
    </div>
    <div>
        <h1> {{ $user->name ?? '' }} </h1>
    </div>
</div>