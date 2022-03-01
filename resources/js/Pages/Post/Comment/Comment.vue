<template>
    <div class="flex space-x-2">
        <img v-bind:src="'storage/' + comment.user.profile_photo_path" alt="profile" class="rounded-full w-12 h-12 object-cover">
        <div v-show="!viewEdit" class="w-full">
            <div class="flex items-center space-x-2">
                <div class="p-3 bg-gray-300 rounded-2xl">
                    <h5 class="font-bold"> {{ comment.user.name }} </h5>
                    <p> {{ editedContent }} </p>
                </div>
                <div>
                    <popover v-show="user.id === comment.user.id" popoverClass="rounded-full w-8 h-8 hover:bg-gray-300">
                        <template v-slot:btnText>
                            <i class="fas fa-ellipsis-h fa-sm"></i>
                        </template>

                        <template v-slot:items>
                            <!-- it's more flexible if generalizing class of button to be dynamic -->
                            <div>
                                <button type="button" v-on:click="viewEdit = true" class="w-full px-4 py-2 hover:bg-gray-100"> Edit </button>
                            </div>
                            <div>
                                <button type="button" v-on:click="deleteUserComment" class="w-full px-4 py-2 hover:bg-gray-100"> Delete </button>
                            </div>
                        </template>
                    </popover>
                </div>
            </div>
            <div class="flex ml-2 space-x-2 text-sm">
                <button class="hover:underline"> Like </button>
                <button  v-on:click="replyClicked = true" class="hover:underline"> Reply </button>
                <p> 1d </p>
            </div>
            <form class="flex mt-2 space-x-2 items-center" v-show="replyClicked && (user.id !== comment.user.id)" v-on:submit.prevent="replyUserComment">
                <img v-bind:src="'storage/' + user.profile_photo_path" class="rounded-full w-8 h-8 object-cover" alt="">
                <input type="text" class="w-full border-2 border-gray-300 rounded-lg bg-white" placeholder="Write a comment..." v-model="reply">
            </form>
            <!-- replied comments container -->
            <div v-show="viewReply" class="mt-3 space-y-2">
                <replied-comments v-on:triggerReply="replyOtherComment" v-on:triggerDelete="deleteOtherComment" v-for="comment in repliedComments" :key="comment.id" :comment="comment" :user="user"> </replied-comments>
            </div>
            <button type="button" v-show="showRepliedCmtBtn()" v-on:click="viewReply = true" class="ml-2 text-sm hover:underline"> <i class="fas fa-reply rotate-180 mr-2"></i> {{ repliedComments.length }} Reply </button>
        </div>
        <form v-show="viewEdit">
            <textarea v-on:keyup.enter="editComment" v-model="editedContent" class="border-2 border-gray-300 rounded-lg bg-white"> </textarea>
        </form>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import Popover from '@/Components/Popover.vue'
import axios from 'axios'
import RepliedComments from './RepliedComments.vue'

export default defineComponent({
    components: {
        Popover,
        RepliedComments,
    },

    props: ['comment', 'user'],

    data() {
        return {
            repliedComments: [],
            reply: '',
            replyClicked: false,
            viewReply: false,
            viewEdit: false,
            editedContent: this.comment.content,
        }
    },

    created() {
        this.fetchRepliedComments()
    },

    methods: {
        editComment() {
            axios.post('/editComment', {comment_id: this.comment.id, content: this.editedContent})
            .then(response => {
                console.log(response.data);
            });

            this.viewEdit = false;
        },

        deleteUserComment() {
            this.$emit('triggerDelete', {id: this.comment.id});
        },

        deleteOtherComment(comment) {
            this.repliedComments.splice(this.repliedComments.findIndex(item => item.id == comment.id), 1);
            axios.post('/deleteRepliedComment', {reply_id: comment.id})
            .then(response => {
                console.log(response.data);
            });
        },

        fetchRepliedComments() {
            axios.post('/fetchRepliedComments', {comment_id: this.comment.id})
            .then(response => {
                this.repliedComments = response.data;
            });
        },

        replyUserComment() {
            axios.post('/replyComment', {comment_id: this.comment.id, to_user_id: this.comment.user.id, content: this.reply})
            .then(response => {
                this.repliedComments.push(response.data[0]);
            });

            this.replyClicked = false;
            this.viewReply = true;
        },

        replyOtherComment(comment) {
            axios.post('/replyComment', {comment_id: this.comment.id, to_user_id: comment.replier.id, content: comment.reply})
            .then(response => {
                this.repliedComments.push(response.data[0]);
            });
        },

        showRepliedCmtBtn() {
            if(this.replyClicked || this.viewReply || this.repliedComments.length === 0) {
                return false;
            }

            return true;
        }
    }
})
</script>
