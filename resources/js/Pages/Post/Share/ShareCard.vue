<template>
    <post-layout :user="user" :post="share.post" :comments="comments" :share_id="share.id">
        <div class="space-y-2">
            <div>
                <div class="flex justify-between">
                    <div class="flex items-center space-x-2">
                        <profile-card :user="share.user">
                            <template #right>
                                <i class="text-gray-400"> shared this post </i>
                            </template>
                            <template #below>
                                {{ share.created_at }}
                            </template>
                        </profile-card>
                    </div>

                    <popover v-show="user.id === share.user.id" popoverClass="rounded-full w-8 h-8 hover:bg-gray-300">
                        <template #btnText>
                            <i class="fas fa-ellipsis-h fa-sm"></i>
                        </template>

                        <template #items>
                            <div class="flex flex-col">
                                <button v-on:click="showModal = true" type="button" class="w-full px-4 py-2 hover:bg-gray-100"> Edit </button>
                                <button v-on:click="deleteShare" type="button" class="w-full px-4 py-2 hover:bg-gray-100"> Delete </button>

                                <jet-dialog-modal :show="showModal" @close="showModal = false">
                                    <template #title>
                                        <div class="text-center">
                                            <h1 class="text-lg"> Edit share </h1>
                                        </div>
                                    </template>
                                    <template #content>
                                        <crown-textarea
                                            type="text" class="w-full" rows="5"
                                            placeholder="Write something..." v-model="content"
                                        />
                                    </template>
                                    <template #footer>
                                        <crown-button class="w-full py-2 bg-blue-400" @click="editShare"> Edit </crown-button>
                                    </template>
                                </jet-dialog-modal>
                            </div>
                        </template>
                    </popover>
                </div>
                <p> {{ content }} </p>
            </div>
            <div class="w-full h-auto">
                <crown-image v-show="share.post.photo !== null" :src="share.post.photo" alt="Share image" class="w-full h-full object-contain" />
            </div>
            <div class="px-2 py-1 mx-5 border-2 border-t-0 border-gray-300 rounded-b-lg">
                <a :href="'profiles?' + 'search=' + share.post.author.name" class="font-bold"> {{ share.post.author.name }} </a>
                <p> {{ share.post.content }} </p>
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
import JetDialogModal from '@/Breeze/DialogModal.vue'
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
    
    props: ['user', 'share'],

    data() {
        return {
            comments: [],
            content: this.share.content,

            showModal: false,
        }
    },

    created() {
        this.fetchComments();
    },

    methods: {
        fetchComments() {
            axios.post('/fetchComments', {share_id: this.share.id}).then(response => {
                this.comments = response.data;
            });
        },

        editShare() {
            axios.put(`/shares/${this.share.id}`, {content: this.content}).then(response => {
                console.log(response.data);

                this.showModal = false;
            });
        },

        deleteShare() {
            axios.delete(`/shares/${this.share.id}`).then(response => {
                console.log(response.data);

                window.location.reload();
            })
        }
    }
})
</script>