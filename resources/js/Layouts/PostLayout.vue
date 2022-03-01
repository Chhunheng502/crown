<template>
    <!-- this html will need a clean-up. -->
    <div class="space-y-2 p-3 border-2 border-gray-300 rounded-lg shadow-lg">

        <slot> </slot>
        <!-- likes, comments, and shares must be live-update  -->
        <div class="flex justify-between">
            <div>
                {{ numOfLikes }}
                <button v-on:click="liked ? unlikePost() : likePost()"> <i v-bind:class="liked ? 'fas fa-heart text-red-500' : 'far fa-heart'"></i> </button>
            </div>
            <div>
                {{ comments.length }} comments
            </div>
            <div>
                {{ numOfShares }} shares
            </div>
        </div>
        <hr>
        <div class="flex justify-around">
            <button type="button" v-on:click="cmtClicked = true">
                <i class="fas fa-comments"></i> Comment
            </button>
            <button type="button" v-on:click="showModal = true" >
                <i class="fas fa-share"></i> Share
            </button>
            <share-modal :show="showModal" :post="post" @close="showModal = false"> </share-modal>
        </div>
        <comment-container v-show="cmtClicked" :post="post" :comments="comments" :user="user" :share_id="share_id"> </comment-container>
    </div>
</template>

<script>
import axios from 'axios'
import { defineComponent } from 'vue'
import CommentContainer from '@/Pages/Post/Comment/CommentContainer.vue'
import ShareModal from '@/Pages/Post/Share/ShareModal.vue';

export default defineComponent({
    components: {
        CommentContainer,
        ShareModal,
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
            numOfLikes: 0,
            numOfShares: 0,

            liked: false,
            cmtClicked: false,
            showModal: false,
        }
    },

    created() {
        this.getLikes();
        this.isLiked();
        this.getShares();
    },

    computed: {
        getFormData() {
            let formData = new FormData();

            if(this.share_id === 0)
            {
                formData.append('post_id', this.post.id);
            }
            else
            {
                formData.append('share_id', this.share_id);
            }

            return formData;
        }
    },

    // this will need to genralize
    methods: {
        getLikes() {
            let formData = new FormData();
            if(this.share_id === 0)
            {
                formData.append('post_id', this.post.id);
            }
            else
            {
                formData.append('share_id', this.share_id);
            }

            axios.post('/getLikes', formData).then(response => {
                this.numOfLikes = response.data.length;
            });
        },

        isLiked() {
            let formData = new FormData();
            if(this.share_id === 0)
            {
                formData.append('post_id', this.post.id);
            }
            else
            {
                formData.append('share_id', this.share_id);
            }

            axios.post('/isLiked', formData).then(response => {
                this.liked = response.data;
            });
        },

        likePost() {
            let formData = new FormData();
            if(this.share_id === 0)
            {
                formData.append('post_id', this.post.id);
            }
            else
            {
                formData.append('share_id', this.share_id);
            }

            this.numOfLikes++;
            this.liked = ! this.liked;

            axios.post('/likePost', formData).then(response => {
                console.log(response.data);
            });
        },

        unlikePost() {
            let formData = new FormData();
            if(this.share_id === 0)
            {
                formData.append('post_id', this.post.id);
            }
            else
            {
                formData.append('share_id', this.share_id);
            }

            this.numOfLikes--;
            this.liked = ! this.liked;

            axios.post('/unlikePost', formData).then(response => {
                console.log(response.data);
            });
        },

        getShares() {
            axios.post('/getShares', {post_id: this.post.id}).then(response => {
                this.numOfShares = response.data;
            });
        }
    }
})
</script>