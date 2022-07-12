<template>
    <Head title="Profile" />

    <div>
        <div @mouseover="showUploadCover = true" @mouseleave="showUploadCover = false" class="relative w-full h-72">
            <!-- will need to adjust the cover -->
            <crown-image :src="friend.detail.cover" class="w-full h-full object-cover" alt="Cover image" />
            <transition name="fade">
                <crown-file-input
                    v-show="showUploadCover && (user.id === friend.id)"
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-4 py-3 rounded-md text-center cursor-pointer bg-black"
                    @change="getCoverUpload"
                >
                    <p class="text-xs text-white whitespace-nowrap"> Upload Cover </p>
                </crown-file-input>
            </transition>

            <jet-dialog-modal :show="showCoverModal" @close="showCoverModal = false">
                <template #title>
                    <div class="text-center">
                        <h1 class="text-lg"> Update Cover </h1>
                    </div>
                </template>
                <template #content>
                    <crown-textarea
                        type="text" class="w-full" rows="5"
                        placeholder="Write a something..." v-model="coverContent"
                    />
                    <img :src="getCoverImage" alt="Cover image">
                </template>
                <template #footer>
                    <crown-button class="w-full py-2 bg-blue-400" @click="updateCover"> Update </crown-button>
                </template>
            </jet-dialog-modal>
        </div>
        <div class="flex justify-between items-center px-6 py-3 bg-gray-300">
            <div class="flex items-center space-x-2">
                <div @mouseover="showUploadProfile = true" @mouseleave="showUploadProfile = false" class="relative w-28 h-28 rounded-full overflow-hidden">
                    <crown-image :src="friend.profile_photo_path" class="w-full h-full object-cover" alt="Profile image" />
                    <transition name="fade">
                        <crown-file-input
                            v-show="showUploadProfile && (user.id === friend.id)"
                            class="absolute top-3/4 w-full h-full text-center cursor-pointer bg-black"
                            @change="getProfileUpload"
                        >
                            <p class="text-xs text-white whitespace-nowrap"> Upload Profile </p>
                        </crown-file-input>
                    </transition>

                    <jet-dialog-modal :show="showProfileModal" @close="showProfileModal = false">
                        <template #title>
                            <div class="text-center">
                                <h1 class="text-lg"> Update Profile </h1>
                            </div>
                        </template>
                        <template #content>
                            <crown-textarea
                                type="text" class="w-full" rows="5"
                                placeholder="Write a something..." v-model="profileContent"
                            />
                            <img :src="getProfileImage" alt="Profile image">
                        </template>
                        <template #footer>
                            <crown-button class="w-full py-2 bg-blue-400" @click="updateProfile"> Update </crown-button>
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
                    <crown-button
                        v-if="!isFriend" class="px-2 py-1 bg-blue-400"
                        @click="addFriend" v-text="!pending ? 'Add Friend' : 'Pending Request'">
                    </crown-button>
                    <crown-button v-else class="px-2 py-1 bg-red-400" @click="unfriend"> Unfriend </crown-button>
                </div>
                <crown-button class="px-2 py-1 bg-blue-400" @click="gotoChat"> Sent Message </crown-button>
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
                <crown-button v-show="user.id === friend.id" class="w-full px-2 py-1 bg-gray-400" @click="showEditModal = true"> Edit Detail </crown-button>
                <edit-modal :user_detail="friend.detail" :show="showEditModal" @close="showEditModal = false"> </edit-modal>
            </div>
        </template>
        <template #section-middle>
            <div class="my-3 space-y-5">
                <div v-for="post in getSortedPosts" :key="post.id">
                    <post-card v-if="post.post_id == null" :user="friend" :post="post"> </post-card>
                    <share-card v-else :user="friend" :share="post"> </share-card>
                </div>
            </div>
        </template>
        <template #section-right>

        </template>
    </section-layout>
</template>

<style>
    .fade-enter-active {
        transition: opacity .3s;
    }

    .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import { Head } from '@inertiajs/inertia-vue3';
import CrownImage from '@/Components/Image.vue'
import CrownFileInput from '@/Components/FileInput.vue'
import CrownTextarea from '@/Components/Textarea.vue'
import CrownButton from '@/Components/Button.vue'
import SectionLayout from '@/Layouts/SectionLayout.vue'
import PostCard from '../Post/PostCard.vue'
import ShareCard from '../Post/Share/ShareCard.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import EditModal from './EditModal.vue'

export default defineComponent({
    components: {
        Head,
        CrownImage,
        CrownFileInput,
        CrownTextarea,
        CrownButton,
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

            searchPost_ID: new URL(location.href).searchParams.get('post'),
            searchShare_ID: new URL(location.href).searchParams.get('share'),
            
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
        this.verifyFriend();
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
            axios.get(`/fetchUserPosts/${this.friend.id}`).then(response => {
                this.data = response.data;

                if(this.searchPost_ID !== null)
                {
                    this.data = this.data.filter(item => item.post_id == null && item.id == this.searchPost_ID);
                }
                else if(this.searchShare_ID !== null)
                {
                    this.data = this.data.filter(item => item.share_id == null && item.id == this.searchShare_ID);
                }
            })
        },

        verifyFriend() {
            axios.post('/isFriend', {user_id: this.friend.id}).then(response => {
                this.isFriend = response.data.isFriend;
                this.pending = response.data.pending;
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
