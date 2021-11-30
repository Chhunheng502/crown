<template>
    <post-layout :user="user" :post="post" :comments="comments">
        <div class="space-y-2">
            <div class="flex justify-between">
                <profile-card :user="post.author">
                    <template #below>
                        {{ post.created_at }}
                    </template>
                </profile-card>

                <popover v-show="user.id === post.author.id" popoverClass="rounded-full w-8 h-8 hover:bg-gray-300">
                    <template #btnText>
                        <i class="fas fa-ellipsis-h fa-sm"></i>
                    </template>

                    <template #items>
                        <div class="flex flex-col">
                            <button type="button" class="w-full px-4 py-2 hover:bg-gray-100" @click="showModal = true"> Edit </button>
                            <button type="button" class="w-full px-4 py-2 hover:bg-gray-100" @click="deletePost"> Delete </button>

                            <jet-dialog-modal :show="showModal" @close="showModal = false">
                                <template #title>
                                    <div class="text-center">
                                        <h1 class="text-lg"> Edit post </h1>
                                    </div>
                                </template>
                                <template #content>
                                    <crown-textarea
                                        type="text" class="w-full" rows="5"
                                        placeholder="Write something..." v-model="content"
                                    />
                                    <div class="w-full h-auto">
                                        <crown-image v-show="post.photo !== null" :src="post.photo" class="w-full h-full object-contain" alt="Post image" />
                                    </div>
                                </template>
                                <template #footer>
                                    <crown-button class="w-full py-2 bg-blue-400" @click="editPost"> Edit </crown-button>
                                </template>
                            </jet-dialog-modal>
                        </div>
                    </template>
                </popover>
            </div>
            <p> {{ content }} </p>
            <div class="w-full h-auto">
                <crown-image v-show="post.photo !== null" :src="post.photo" class="w-full h-full object-contain" alt="Post image" />
            </div>
        </div>
    </post-layout>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import PostLayout from '@/Layouts/PostLayout.vue'
import ProfileCard from '@/Components/ProfileCard.vue'
import Popover from '@/Components/Popover.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import CrownTextarea from '@/Components/Textarea.vue'
import CrownImage from '@/Components/Image.vue'
import CrownButton from '@/Components/Button.vue';

export default defineComponent({
    components: {
        PostLayout,
        ProfileCard,
        Popover,
        JetDialogModal,
        CrownTextarea,
        CrownImage,
        CrownButton,
    },
    
    props: ['user', 'post'],

    data() {
        return {
            comments: [],

            numOfShares: 0,
            content: this.post.content,

            showModal: false,
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
            axios.post('/editPost', {post_id: this.post.id, content: this.content}).then(response => {
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