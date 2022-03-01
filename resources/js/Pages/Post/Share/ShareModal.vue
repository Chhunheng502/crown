<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            <div class="text-center">
                <h1 class="text-lg"> Share this post? </h1>
            </div>
        </template>
        <template #content>
            <textarea type="text" v-model="shareContent" class="w-full border-2 border-gray-300 rounded-lg" placeholder="Write something..." />
            <!-- need to align with the post card -->
            <div class="px-2 py-1 border-2 border-gray-300 rounded-lg">
                <div class="space-y-2">
                    <profile-card :user="post.author"> </profile-card>
                    <p> {{ post.content }} </p>
                    <div class="w-full h-auto">
                        <img v-show="post.photo !== null" :src="'storage/' + post.photo" alt="" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button" v-on:click="sharePost" class="w-full py-2 rounded-lg text-white bg-blue-400"> Share </button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import ProfileCard from '@/Components/ProfileCard.vue'

export default defineComponent({
    components: {
        JetDialogModal,
        ProfileCard,
    },

    props: ['post', 'show'],

    data() {
        return {
            shareContent: '',
        }
    },

    methods: {
        close() {
            this.$emit('close');
        },

        sharePost() {
            axios.post('/sharePost', {post_id: this.post.id, content: this.shareContent}).then(response => {
                console.log(response.data);

                window.location.reload();
            });
        }
    }
})
</script>
