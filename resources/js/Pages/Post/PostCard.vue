<template>
    <post-layout :post="post" :comments="comments" :user="user">
        <div class="space-y-2">
            <div class="flex justify-between">
                <profile-card :user="post.author"> </profile-card>

                <popover v-show="user.id === post.author.id" popoverClass="rounded-full w-8 h-8 hover:bg-gray-300">
                    <template v-slot:btnText>
                        <i class="fas fa-ellipsis-h fa-sm"></i>
                    </template>

                    <template v-slot:items>
                        <div class="flex flex-col">
                            <button v-on:click="showModal = true" type="button" class="w-full px-4 py-2 hover:bg-gray-100"> Edit </button>
                            <button v-on:click="deletePost" type="button" class="w-full px-4 py-2 hover:bg-gray-100"> Delete </button>

                            <jet-dialog-modal :show="showModal" @close="showModal = false">
                                <template #title>
                                    <div class="text-center">
                                        <h1 class="text-lg"> Edit post </h1>
                                    </div>
                                </template>
                                <template #content>
                                    <textarea type="text" v-model="editedContent" class="w-full border-2 border-gray-300 rounded-lg" rows="5" placeholder="Write something..." />
                                    <img v-show="post.photo !== null" :src="'storage/' + post.photo" alt="">
                                </template>
                                <template #footer>
                                    <button type="button" v-on:click="editPost" class="w-full py-2 rounded-lg text-white bg-blue-400"> Edit </button>
                                </template>
                            </jet-dialog-modal>
                        </div>
                    </template>
                </popover>
            </div>
            <p> {{ editedContent }} </p>
            <div class="w-full h-auto">
                <img v-show="post.photo !== null" :src="'storage/' + post.photo" alt="" class="w-full h-full object-contain">
            </div>
        </div>
    </post-layout>
</template>

<script>
import axios from 'axios'
import { defineComponent } from 'vue'
import PostLayout from '@/Layouts/PostLayout.vue'
import ProfileCard from '@/Components/ProfileCard.vue'
import Popover from '@/Components/Popover.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'

export default defineComponent({
    components: {
        PostLayout,
        ProfileCard,
        Popover,
        JetDialogModal,
    },
    
    props: ['post', 'user'],

    data() {
        return {
            comments: [],
            numOfShares: 0,
            showModal: false,

            editedContent: this.post.content,
        }
    },

    created() {
        this.fetchComments();
    },

    methods: {
        fetchComments() {
            axios.post('/fetchComments', {post_id: this.post.id}).then(response => {
                this.comments = response.data;
            });
        },

        editPost() {
            axios.post('/editPost', {post_id: this.post.id, content: this.editedContent}).then(response => {
                console.log(response.data);

                this.showModal = false;
            });
        },

        deletePost() {
            axios.post('/deletePost', {post_id: this.post.id}).then(response => {
                console.log(response.data);

                window.location.reload();
            })
        }
    }
})
</script>