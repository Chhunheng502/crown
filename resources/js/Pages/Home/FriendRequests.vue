<template>
    <div :class="responsive ? 'space-y-2 h-64 overflow-auto' : 'space-y-2'">
        <div>
            <h1 class="text-xl font-bold"> <i class="fas fa-user-friends"></i> Friend Requests </h1>
        </div>
        <div class="space-y-2">
            <div v-for="request in requests" :key="request.id" class="px-2 py-3 rounded-lg shadow-lg bg-gray-300">
                <div class="flex space-x-2">
                    <!-- adding w-14 and h-14 won't overwrite the class with that w and h, but rather extending
                    these attributes to the end of class. Should configure default w and h instead -->
                    <crown-profile-image :src="request.requester.profile_photo_path" class="w-14 h-14" />
                    <div class="space-y-2">
                        <div class="leading-5">
                            <h1> <span class="font-bold"> {{ request.requester.name }} </span> sent you a friend request </h1>
                            <p class="text-sm"> {{ request.created_at }} </p>
                        </div>
                        <div class="flex space-x-2">
                            <crown-button class="px-2 py-1 bg-blue-400" @click="acceptRequest(request.id)"> Accept </crown-button>
                            <crown-button class="px-2 py-1 bg-red-400" @click="deleteRequest(request.id)"> Delete </crown-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import CrownProfileImage from '@/Components/ProfileImage.vue'
import CrownButton from '@/Components/Button.vue';

export default defineComponent({
    components: {
        CrownProfileImage,
        CrownButton,
    },

    props: {
        user: {
            type: Object,
        },
        responsive: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            requests: [],
        }
    },
    
    created() {
        this.fetchFriendRequests();
    },

    methods: {
        fetchFriendRequests() {
            axios.get('/fetchFriendRequests').then(response => {
                this.requests = response.data;
            })
        },

        acceptRequest(id) {
            axios.post('/acceptFriendRequest', {id: id}).then(response => {
                console.log(response.data);

                this.requests.splice(this.requests.findIndex(item => item.id == id), 1);
            })
        },

        deleteRequest(id) {
            axios.post('/deleteFriendRequest', {id: id}).then(response => {
                console.log(response.data);

                this.requests.splice(this.requests.findIndex(item => item.id == id), 1);
            })
        },

        // checkBreakPoint() {
        //     window.onresize = () => {
        //         if(window.innerWidth < 1024)
        //         {
        //             this.showComponent = false;
        //         }
        //         else
        //         {
        //             this.showComponent = true;
        //         }
        //     }
        // }
    },

    // mounted() {
    //     this.checkBreakPoint();
    // }
})
</script>
