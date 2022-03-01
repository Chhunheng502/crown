<template>
    <post-input :user="user"> </post-input>
    <div class="my-3 space-y-5">
        <!-- use condition to filter between post card and share card here -->
        <div v-for="post in getSortedPosts" :key="post.id">
            <post-card v-if="post.post_id == null" :post="post" :user="user"> </post-card>
            <share-card v-if="post.post_id != null" :share="post" :user="user"> </share-card>
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
            posts: [],
        }
    },

    created() {
        this.fetchPosts();
    },

    computed: {
        getSortedPosts() {
            return this.posts.sort(function(a,b){
                        return new Date(b.updated_at) - new Date(a.updated_at);
                    });;
        }
    },

    methods: {
        fetchPosts() {
            axios.get('/fetchPosts').then(response => {
                this.posts = response.data;
            })
        }
    },
})
</script>
