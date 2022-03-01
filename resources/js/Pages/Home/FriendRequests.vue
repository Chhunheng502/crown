<template>
    <div class="space-y-2">
        <div>
            <h1 class="text-xl font-bold"> <i class="fas fa-user-friends"></i> Friend Requests </h1>
        </div>
        <div class="space-y-2">
            <div v-for="request in requests" :key="request.id" class="p-2 rounded-lg shadow-lg bg-gray-300">
                <div class="flex space-x-2">
                    <img v-bind:src="'storage/' + request.requester.profile_photo_path" class="rounded-full w-14 h-14 object-cover" alt="">
                    <div class="space-y-2">
                        <div class="leading-5">
                            <h1> <span class="font-bold"> {{ request.requester.name }} </span> sent you a friend request </h1>
                            <p> 1 day ago </p>
                            <p> 2 mutual friends </p>
                        </div>
                        <div class="flex space-x-2">
                            <button type="button" v-on:click="acceptRequest(request.id)" class="px-2 py-1 rounded-lg text-white bg-blue-400"> Accept </button>
                            <button type="button" v-on:click="deleteRequest(request.id)" class="px-2 py-1 rounded-lg text-white bg-red-400"> Delete </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['user'],

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
    }
})
</script>
