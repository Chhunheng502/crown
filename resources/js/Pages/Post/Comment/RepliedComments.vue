<template>
    <div class="flex space-x-2">
        <img v-bind:src="'storage/' + comment.replier.profile_photo_path" alt="profile" class="rounded-full w-12 h-12 object-cover">
        <div v-show="!viewEdit" class="w-full">
            <div class="flex items-center space-x-2">
                <div class="p-3 bg-gray-300 rounded-2xl">
                    <h5 class="font-bold"> {{ comment.replier.name }} </h5>
                    <p> <span class="font-extrabold"> {{ comment.commenter.name }} </span> {{ editedContent }} </p>
                </div>
                <div>
                    <!-- make this disable after enter -->
                    <popover v-show="user.id === comment.replier.id" popoverClass="rounded-full w-8 h-8 hover:bg-gray-300">
                        <template v-slot:btnText>
                            <i class="fas fa-ellipsis-h fa-sm"></i>
                        </template>

                        <template v-slot:items>
                            <!-- it's more flexible if generalizing class of button to be dynamic -->
                            <div>
                                <button type="button" v-on:click="viewEdit = true" class="w-full px-4 py-2 hover:bg-gray-300"> Edit </button>
                            </div>
                            <div>
                                <button type="button" v-on:click="deleteComment" class="w-full px-4 py-2 hover:bg-gray-100"> Delete </button>
                            </div>
                        </template>
                    </popover>
                </div>
            </div>
            <div class="flex ml-2 space-x-2 text-sm">
                <button class="hover:underline"> Like </button>
                <button v-on:click="replyClicked = true" class="hover:underline"> Reply </button>
                <p> 1d </p>
            </div>
            <form class="flex mt-2 space-x-2 items-center" v-show="replyClicked && (user.id !== comment.replier.id)" v-on:submit.prevent="replyComment">
                <img v-bind:src="'storage/' + user.profile_photo_path" class="rounded-full w-8 h-8 object-cover" alt="">
                <input type="text" class="w-full border-2 border-gray-300 rounded-lg bg-white" placeholder="Write a comment..." v-model="reply">
            </form>
        </div>
        <form v-show="viewEdit">
            <textarea v-on:keyup.enter="editComment" v-model="editedContent" class="border-2 border-gray-300 rounded-lg bg-white"> </textarea>
        </form>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import Popover from '@/Components/Popover.vue'

export default defineComponent({
    components: {
        Popover,
    },

    props: ['comment', 'user'],

    data() {
        return {
            reply: '',
            replyClicked: false,
            viewEdit: false,
            editedContent: this.comment.content,
        }
    },

    methods: {
        editComment() {
            axios.post('/editRepliedComment', {reply_id: this.comment.id, content: this.editedContent})
            .then(response => {
                console.log(response.data);
            });

            this.viewEdit = false;
        },

        deleteComment() {
            this.$emit('triggerDelete', {id: this.comment.id});
        },
        
        replyComment() {
            this.$emit('triggerReply', {
                replier: this.comment.replier,
                reply: this.reply,
            });

            this.replyClicked = false;
            this.reply = '';
        }
    }
})
</script>
