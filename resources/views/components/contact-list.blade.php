

<div class="space-y-2">
    @foreach ($friends as $friend)
        <x-profile-card :user="$friend->profile" />
    @endforeach
</div>