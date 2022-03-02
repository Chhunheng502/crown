<template>
    <img :src="'storage/' + src" v-bind:class="['w-12 h-12 rounded-full object-cover', isOnline ? 'border-2 border-green-500' : '']" alt="Profile image">
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        src: {
            type: String
        },
        isOnline: {
            type: Boolean,
        }
    },

    data() {
        return {
            defaultStyle: "w-12 h-12 rounded-full object-cover",
            onlineStyle: "border-2 border-green-500"
        }
    }
})
</script>
