<template>
    <div>
        <form class="flex space-x-2" @submit.prevent="storeComment">
            <crown-profile-image :src="user.profile_photo_path" />
            <crown-input
                type="text" class="w-full" 
                placeholder="Write a comment..."
                v-model="content"
            />
        </form>
        <div class="mt-3 space-y-2">
            <comment @triggerDelete="deleteComment" v-for="comment in slicedComments" :key="comment.id" :user="user" :comment="comment"> </comment>
            <button v-show="comments.length > seeMore" type="button" class="hover:underline" @click="seeMoreComments"> View more comments </button>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import CrownProfileImage from '@/Components/ProfileImage.vue'
import CrownInput from '@/Components/Input.vue'
import Comment from './Comment.vue';

export default defineComponent({
    components: {
        CrownProfileImage,
        CrownInput,
        Comment,
    },
    
    props: {
        user: Object,
        post: Object,
        comments: Array,
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

            axios.post('/comments', formData).then(response => {
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

            axios.delete(`/comments/${comment.id}`)
            .then(response => {
                console.log(response.data);
            });
        },
    }
})
</script>