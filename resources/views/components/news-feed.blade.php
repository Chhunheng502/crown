

<div class="space-y-5">
    @foreach ($posts as $post)
        <x-post-card :post="$post" />
    @endforeach
</div>