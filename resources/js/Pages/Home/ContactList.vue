<template>
    <div class="space-y-2">
        <div>
            <h1 class="text-xl font-bold"> <i class="fas fa-address-book"></i> Contacts </h1>
        </div>
        <div class="space-y-2">
            <div v-for="friend in friends" :key="friend.id" class="flex items-center space-x-2">
                <profile-card :user="identifiedData(friend)" :enableLink="false"> </profile-card>

                <popover popoverClass="rounded-full w-8 h-8 hover:bg-gray-300">
                    <template v-slot:btnText>
                        <i class="fas fa-ellipsis-h fa-sm"></i>
                    </template>

                    <template v-slot:items>
                        <div class="flex flex-col">
                            <a :href="'profiles?' + 'search=' + identifiedData(friend).name" class="w-full px-4 py-2 hover:bg-gray-100"> View Profile </a>
                            <button v-on:click="gotoChat(identifiedData(friend).id)" type="button" class="w-full px-4 py-2 hover:bg-gray-100"> Go to Chat </button>
                        </div>
                    </template>
                </popover>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import ProfileCard from '@/Components/ProfileCard.vue'
import Popover from '@/Components/Popover.vue'

export default defineComponent({
    components: {
        ProfileCard,
        Popover,
    },

    props: ['user'],
    
    data() {
        return {
            friends: [],
        }
    },

    created() {
        this.fetchFriends();
    },

    methods: {
        fetchFriends() {
            axios.get('/fetchFriends').then(response => {
                this.friends = response.data;
            })
        },

        identifiedData(friend) {
            return this.user.id !== friend.profile1.id ? friend.profile1 : friend.profile2;
        },

        gotoChat(friend_id) {
            localStorage.setItem('chatKey', friend_id);

            window.location.href = '/chat';
        }
    },
})
</script>
