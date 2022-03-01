<template>
    <div>
        <form class="flex space-x-2" v-on:submit.prevent="storeComment">
            <img v-bind:src="'storage/' + user.profile_photo_path" class="rounded-full w-12 h-12 object-cover" alt="">
            <input type="text" class="w-full border-2 border-gray-300 rounded-lg bg-white" placeholder="Write a comment..." v-model="content">
        </form>
        <div class="mt-3 space-y-2">
            <comment v-on:triggerDelete="deleteComment" v-for="comment in slicedComments" :key="comment.id" :comment="comment" :user="user"> </comment>
            <button type="button" v-show="comments.length > seeMore" v-on:click="seeMoreComments" class="hover:underline"> View more comments </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { defineComponent } from 'vue'
import Comment from './Comment.vue'

export default defineComponent({
    components: {
        Comment,
    },
    
    props: {
        post: Object,
        comments: Array,
        user: Object,
        share_id: {
            default: 0
        }
    },

    data() {
        return {
            content: '',
            seeMore: 3,
        }
    },

    computed: {
        slicedComments() {
            let array = this.comments;
            return array.slice(0, this.seeMore);
        }
    },

    methods: {
        // you might want to use this efficient method on other too (such as chat component)
        storeComment() {

            let formData = new FormData();
            formData.append('content', this.content);
            if(this.share_id == 0)
            {
                formData.append('post_id', this.post.id);
            }
            else
            {
                formData.append('share_id', this.share_id);
            }
            axios.post('/storeComment', formData).then(response => {
                this.comments.push(response.data[0]);
            });

            this.content = '';
        },

        seeMoreComments()
        {
            this.seeMore += 5;
        },

        deleteComment(comment) {
            this.comments.splice(this.comments.findIndex(item => item.id == comment.id), 1);
            axios.post('/deleteComment', {comment_id: comment.id})
            .then(response => {
                console.log(response.data);
            });
        },
    }
})
</script>