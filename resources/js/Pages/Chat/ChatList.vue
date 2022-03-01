<template>
    <div class="space-y-2">
        <div v-for="chat in chats" :key="chat.id" @click="sendReceiverId(isReceiver(chat.user2_id) ? chat.user2_id : chat.user_id)" class="hover:bg-gray-400 cursor-pointer">
            <div class="flex items-center space-x-2">
                <img v-bind:src="'storage/' + (isReceiver(chat.user2_id) ? chat.receiver.profile_photo_path : chat.sender.profile_photo_path)" class="rounded-full w-12 h-12 object-cover" alt="">
                <h1> {{ isReceiver(chat.user2_id) ? chat.receiver.name : chat.sender.name }} </h1>
            </div>
            <!-- <profile-card :user="isReceiver(chat.user2_id) ? chat.receiver : chat.sender"> </profile-card> -->
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import ProfileCard from '@/Components/ProfileCard.vue'

export default defineComponent({
    components: {
        ProfileCard,
    },
    
    props: ['from_user', 'chats'],

    methods: {
        sendReceiverId(receiverId) {
            this.$emit('chatClicked', receiverId);
        },

        isReceiver(id)
        {
            return this.from_user.id !== id;
        }
    },
})
</script>
