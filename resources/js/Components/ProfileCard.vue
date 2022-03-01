<template>
    <div class="flex items-center space-x-2">
        <img v-bind:src="'storage/' + user.profile_photo_path" class="rounded-full w-12 h-12 object-cover" alt="">
        <a :href="'profiles?' + 'search=' + user.name" class="font-bold"> {{ user.name }} </a>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['user']
})
</script>
