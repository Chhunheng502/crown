<template>
    <post-layout :post="share.post" :comments="comments" :user="user" :share_id="share.id">
        <div class="space-y-2">
            <div>
                <div class="flex justify-between">
                    <div class="flex items-center space-x-2">
                        <profile-card :user="share.user"> </profile-card>
                        <i class="text-gray-300"> shared this post </i>
                    </div>

                    <popover v-show="user.id === share.user.id" popoverClass="rounded-full w-8 h-8 hover:bg-gray-300">
                        <template v-slot:btnText>
                            <i class="fas fa-ellipsis-h fa-sm"></i>
                        </template>

                        <template v-slot:items>
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
                                        <textarea type="text" v-model="editedContent" class="w-full" rows="5" placeholder="Write something..." />
                                    </template>
                                    <template #footer>
                                        <button type="button" v-on:click="editShare" class="w-full py-2 bg-blue-500"> Edit </button>
                                    </template>
                                </jet-dialog-modal>
                            </div>
                        </template>
                    </popover>
                </div>
                <p> {{ editedContent }} </p>
            </div>
            <div class="w-full h-auto">
                <img v-show="share.post.photo !== null" :src="'storage/' + share.post.photo" alt="" class="w-full h-full object-contain">
            </div>
            <div class="px-2 py-1 mx-5 border border-t-0 border-gray-400">
                <a :href="'profiles?' + 'search=' + user.name" class="font-bold"> {{ user.name }} </a>
                <p> {{ share.post.content }} </p>
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
    
    props: ['share', 'user'],

    data() {
        return {
            comments: [],
            editedContent: this.share.content,

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
            axios.post('/editShare', {share_id: this.share.id, content: this.editedContent}).then(response => {
                console.log(response.data);

                this.showModal = false;
            });
        },

        deleteShare() {
            axios.post('/deleteShare', {share_id: this.share.id}).then(response => {
                console.log(response.data);

                window.location.reload();
            })
        }
    }
})
</script>