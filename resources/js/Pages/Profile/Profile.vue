<template>
    <div>
        <div @mouseover="showUploadCover = true" @mouseleave="showUploadCover = false" class="relative w-full h-72">
            <!-- will need to adjust the cover -->
            <img :src="'storage/' + friend.detail.cover" alt="" class="w-full h-full object-cover">
            <label v-show="showUploadCover && (user.id === friend.id)" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-4 py-3 rounded-md text-center cursor-pointer bg-black" id="test">
                <p class="text-xs text-white whitespace-nowrap"> Upload Cover </p>
                <input type="file" v-on:change="getCoverUpload" class="hidden">
            </label>

            <jet-dialog-modal :show="showCoverModal" @close="showCoverModal = false">
                <template #title>
                    <div class="text-center">
                        <h1 class="text-lg"> Update Cover </h1>
                    </div>
                </template>
                <template #content>
                    <textarea type="text" v-model="coverContent" class="w-full border-2 border-gray-300 rounded-lg" rows="5" placeholder="Write something..." />
                    <img v-bind:src="getCoverImage" alt="">
                </template>
                <template #footer>
                    <button type="button" v-on:click="updateCover" class="w-full py-2 rounded-lg text-white bg-blue-400"> Update </button>
                </template>
            </jet-dialog-modal>
        </div>
        <div class="flex justify-between items-center px-6 py-3 bg-gray-300">
            <div class="flex items-center space-x-2">
                <div @mouseover="showUploadProfile = true" @mouseleave="showUploadProfile = false" class="relative w-28 h-28 rounded-full overflow-hidden">
                    <img v-bind:src="'storage/' + friend.profile_photo_path" class="w-full h-full object-cover" alt="">
                    <label v-show="showUploadProfile && (user.id === friend.id)" class="absolute top-3/4 w-full h-full text-center cursor-pointer bg-black" id="test">
                        <p class="text-xs text-white whitespace-nowrap"> Upload Profile </p>
                        <input type="file" v-on:change="getProfileUpload" class="hidden">
                    </label>

                    <jet-dialog-modal :show="showProfileModal" @close="showProfileModal = false">
                        <template #title>
                            <div class="text-center">
                                <h1 class="text-lg"> Update Profile </h1>
                            </div>
                        </template>
                        <template #content>
                            <textarea type="text" v-model="profileContent" class="w-full border-2 border-gray-300 rounded-lg" rows="5" placeholder="Write something..." />
                            <img v-bind:src="getProfileImage" alt="">
                        </template>
                        <template #footer>
                            <button type="button" v-on:click="updateProfile" class="w-full py-2 rounded-lg text-white bg-blue-400"> Update </button>
                        </template>
                    </jet-dialog-modal>
                </div>
                <div>
                    <h1 class="font-bold"> {{ friend.name }} </h1>
                    <p class="text-gray-400"> {{ friend.detail.work }} </p>
                </div>
            </div>
            <div v-if="user.id !== friend.id" class="flex space-x-2">
                <div>
                    <button v-if="!isFriend" v-on:click="addFriend" type="button" class="px-2 py-1 rounded-lg text-white bg-blue-400" v-text="!pending ? 'Add Friend' : 'Pending Request'"> </button>
                    <button v-else v-on:click="unfriend" type="button" class="px-2 py-1 rounded-lg text-white bg-red-400"> Unfriend </button>
                </div>
                <button v-on:click="gotoChat" type="button" class="px-2 py-1 rounded-lg text-white bg-blue-400"> Sent Message </button>
            </div>
        </div>
    </div>

    <section-layout>
        <template #section-left>
            <div class="space-y-2">
                <h1 class="text-xl font-bold"> Intro </h1>
                <ul class="space-y-2">
                    <li class="flex space-x-2 items-baseline">
                        <i class="fas fa-venus-mars"></i>
                        <p> {{ friend.detail.gender }} </p>
                    </li>
                    <li class="flex space-x-2 items-baseline">
                        <i class="fas fa-briefcase"></i>
                        <p> Work as {{ friend.detail.work }} </p>
                    </li>
                    <li class="flex space-x-2 items-baseline">
                        <i class="fas fa-house-user"></i>
                        <p> Live in {{ friend.detail.place_lived }} </p>
                    </li>
                    <li class="flex space-x-2 items-baseline">
                        <i class="fas fa-birthday-cake"></i>
                        <p> Was born on {{ formatDate(friend.detail.birth_date) }} </p>
                    </li>
                    <li class="flex space-x-2 items-baseline">
                        <i class="fas fa-clock"></i>
                        <p> Join {{ formatDate(friend.created_at) }} </p>
                    </li>
                </ul>
                <!-- condition here -->
                <!-- <button type="button" class="w-full px-2 py-1 rounded-md bg-gray-300"> View Detail </button> -->
                <button v-show="user.id === friend.id" v-on:click="showEditModal = true" type="button" class="w-full px-2 py-1 rounded-md bg-gray-300"> Edit Detail </button>
                <edit-modal :user_detail="friend.detail" :show="showEditModal" @close="showEditModal = false"> </edit-modal>
            </div>
        </template>
        <template #section-middle>
            <div class="my-3 space-y-5">
                <div v-for="post in getSortedPosts" :key="post.id">
                    <post-card v-if="post.post_id == null" :post="post" :user="friend"> </post-card>
                    <share-card v-if="post.post_id != null" :share="post" :user="friend"> </share-card>
                </div>
            </div>
        </template>
        <template #section-right>

        </template>
    </section-layout>
</template>

<script>
import { defineComponent } from 'vue'
import SectionLayout from '@/Layouts/SectionLayout.vue'
import PostCard from '../Post/PostCard.vue'
import ShareCard from '../Post/Share/ShareCard.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import EditModal from './EditModal.vue'
import axios from 'axios'

export default defineComponent({
    components: {
        SectionLayout,
        PostCard,
        ShareCard,
        JetDialogModal,
        EditModal,
    },

    props: ['user', 'friend'],

    data() {
        return {
            data: [],
            profileUpload: '',
            coverUpload: '',
            profileContent: '',
            coverContent: '',

            isFriend: false,
            pending: false,
            showEditModal: false,
            showProfileModal: false,
            showCoverModal: false,
            showUploadProfile: false,
            showUploadCover: false,
        }
    },

    created() {
        this.fetchUserPosts();
        this.isFriend_M();
    },

    computed: {
        getSortedPosts() {
            return this.data.sort(function(a,b){
                        return new Date(b.updated_at) - new Date(a.updated_at);
                    });;
        },

        getProfileImage() {
            return URL.createObjectURL(this.profileUpload);
        },

        getCoverImage() {
            return URL.createObjectURL(this.coverUpload);
        },
    },

    methods: {
        fetchUserPosts() {
            axios.post('/fetchUserPosts', {user_id: this.friend.id}).then(response => {
                this.data = response.data;
            })
        },

        addFriend() {
            axios.post('/addFriend', {to_user_id: this.friend.id}).then(response => {
                console.log(response.data);
            })

            this.pending = true;
        },

        unfriend() {
            axios.post('/unfriend', {user_id: this.friend.id}).then(response => {
                console.log(response.data);
            })

            this.isFriend = false;
        },

        isFriend_M() {
            axios.post('/isFriend', {user_id: this.friend.id}).then(response => {
                this.isFriend = response.data.isFriend;
                this.pending = response.data.pending;
            })
        },

        getProfileUpload(event) {
            this.profileUpload = event.target.files[0];

            this.showProfileModal = true;
        },

        getCoverUpload(event) {
            this.coverUpload = event.target.files[0];

            this.showCoverModal = true;
        },

        updateProfile() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            };

            let formData = new FormData();
            formData.append('user_id', this.user.id);
            formData.append('content', this.profileContent);
            formData.append('photo', this.profileUpload);

            axios.post('/updateProfile', formData, config)
            .then(response => {
                console.log(response.data);

                window.location.reload();
            })
        },

        updateCover() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            };

            let formData = new FormData();
            formData.append('id', this.user.detail.id);
            formData.append('content', this.coverContent);
            formData.append('photo', this.coverUpload);

            axios.post('/updateCover', formData, config)
            .then(response => {
                console.log(response.data);

                window.location.reload();
            })
        },

        gotoChat() {
            localStorage.setItem('chatKey', this.friend.id);

            window.location.href = '/chat';
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"});
        },
    },
})
</script>
