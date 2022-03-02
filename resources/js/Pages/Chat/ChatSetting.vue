<template>
    <div class="space-y-3">
        <a :href="'profiles?' + 'search=' + user.name"> View profile </a>
        <div class="flex justify-between items-center">
            <p> Notifications </p>
            <label 
                for="toggleNotif"
                class="flex items-center cursor-pointer"
            >
                <!-- toggle -->
                <div class="relative">
                    <!-- input -->
                    <input id="toggleNotif" type="checkbox" class="sr-only" />
                    <!-- line -->
                    <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                    <!-- dot -->
                    <div class="dot absolute w-6 h-6 bg-red-500 rounded-full shadow -left-1 -top-1 transition"></div>
                </div>
            </label>
        </div>
        <button type="button" class="block"> Ignore messages </button>
        <button type="button" class="block"> Block </button>
        <button type="button" class="block"> Delete conversation </button>
    </div>
</template>

<style>
    input:checked ~ .dot {
        transform: translateX(100%);
        background-color: rgb(30, 213, 30);
    }
</style>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['user'],
})
</script>
