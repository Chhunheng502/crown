

<div class="space-y-2">
    @foreach ($messages as $message)
        <x-profile-card :user="$message->sender" />
    @endforeach
</div>