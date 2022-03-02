<template>
    <div class="flex items-center space-x-2">
        <crown-profile-image :src="user.profile_photo_path" :isOnline="isOnline" />
        <div>
            <div class="flex space-x-2">
                <a v-if="enableLink" :href="'profiles?' + 'search=' + user.name" class="font-bold"> {{ user.name }} </a>
                <p v-else> {{ user.name }} </p>
                <slot name="right"> </slot>
            </div>
            <p class="text-sm text-gray-400"> <slot name="below"> </slot> </p>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import CrownProfileImage from './ProfileImage.vue';

export default defineComponent({
    components: {
        CrownProfileImage,
    },

    props: {
        user: {
            type: Object
        },
        isOnline: {
            type: Boolean,
            default: false
        },
        enableLink: {
            type: Boolean,
            default: true
        },
    },

    created() {
        Echo.private('test')
            .listen('UserOnlineStatus', (e) => {
                this.isOnline = e.isOnline
            });
    },
})
</script>
