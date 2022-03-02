<template>
    <div id="newfeedsContainer">
        <post-input :user="user"> </post-input>
        <div class="my-3 space-y-5">
            <div v-for="post in getSortedPosts" :key="post.id">
                <post-card v-if="post.post_id == null" :user="user" :post="post"> </post-card>
                <share-card v-else :user="user" :share="post"> </share-card>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import PostInput from '../Post/PostInput.vue'
import PostCard from '../Post/PostCard.vue'
import ShareCard from '../Post/Share/ShareCard.vue'

export default defineComponent({
    components: {
        PostInput,
        PostCard,
        ShareCard,
    },

    props: ['user'],
    
    data() {
        return {
            posts: []
        }
    },

    created() {
        this.fetchInitialPosts();
    },

    // should use in the backend
    computed: {
        getSortedPosts() {
            return this.posts.sort(function(a,b){
                        return new Date(b.updated_at) - new Date(a.updated_at);
                    });;
        }
    },

    methods: {
        fetchInitialPosts() {
            axios.get(`/fetchPosts/1/5`).then(response => {
                this.posts = response.data;
            })
        },
        fetchNextPosts() {
            window.onscroll = () => {
                let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight - 100 >= document.getElementById("newfeedsContainer").offsetHeight;

                if (bottomOfWindow) {
                    axios.get(`/fetchPosts/${this.posts.length}/${5}`).then(response => {
                        this.posts = this.posts.concat(response.data);
                    })
                }
            }
        }
    },

    mounted() {
        this.fetchNextPosts();
    }
})
</script>
