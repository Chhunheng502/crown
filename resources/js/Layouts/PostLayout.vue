<template>
    <div class="space-y-2 p-3 border-2 border-gray-300 rounded-lg shadow-lg">
        <slot> </slot>
        <!-- likes, comments, and shares must be live-update  -->
        <div class="flex justify-between">
            <div>
                {{ numOfLikes }}
                <button @click="liked ? unlikePost() : likePost()"> <i :class="liked ? 'fas fa-heart text-red-500' : 'far fa-heart'"></i> </button>
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
            <button type="button" @click="cmtClicked = true">
                <i class="fas fa-comments"></i> Comment
            </button>
            <button type="button" @click="showModal = true" >
                <i class="fas fa-share"></i> Share
            </button>
            <share-modal :show="showModal" :post="post" @close="showModal = false"> </share-modal>
        </div>
        <comment-container v-show="cmtClicked" :user="user" :post="post" :comments="comments" :share_id="share_id"> </comment-container>
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
        user: Object,
        post: Object,
        comments: Array,
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
        this.fetchLikes();
        this.isLiked();
        this.fetchCountShares();
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

    methods: {
        fetchLikes() {
            axios.post('/fetchLikes', this.getFormData).then(response => {
                this.numOfLikes = response.data.length;
            });
        },

        isLiked() {
            axios.post('/isLiked', this.getFormData).then(response => {
                this.liked = response.data;
            });
        },

        likePost() {
            this.numOfLikes++;
            this.liked = !this.liked;

            axios.post('/likePost', this.getFormData).then(response => {
                console.log(response.data);
            });
        },

        unlikePost() {
            this.numOfLikes--;
            this.liked = !this.liked;

            axios.post('/unlikePost', this.getFormData).then(response => {
                console.log(response.data);
            });
        },

        fetchCountShares() {
            axios.get(`/fetchCountShares/${this.post.id}`).then(response => {
                this.numOfShares = response.data;
            });
        }
    }
})
</script>