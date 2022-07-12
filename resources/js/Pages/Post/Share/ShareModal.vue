<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            <div class="text-center">
                <h1 class="text-lg"> Share this post? </h1>
            </div>
        </template>
        <template #content>
            <crown-textarea
                type="text" class="w-full" placeholder="Write something..."
                v-model="shareContent"
            />
            <!-- need to align with the post card -->
            <div class="px-2 py-1 border-2 border-gray-300 rounded-lg">
                <div class="space-y-2">
                    <profile-card :user="post.author"> </profile-card>
                    <p> {{ post.content }} </p>
                    <div class="w-full h-auto">
                        <crown-image v-show="post.photo !== null" :src="post.photo" class="w-full h-full object-contain" alt="Post image" />
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <crown-button class="w-full py-2 bg-blue-400" @click="sharePost"> Share </crown-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import CrownTextarea from '@/Components/Textarea.vue'
import ProfileCard from '@/Components/ProfileCard.vue'
import CrownImage from '@/Components/Image.vue'
import CrownButton from '@/Components/Button.vue';

export default defineComponent({
    components: {
        JetDialogModal,
        CrownTextarea,
        ProfileCard,
        CrownImage,
        CrownButton,
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
            axios.post('/shares', {post_id: this.post.id, content: this.shareContent}).then(response => {
                console.log(response.data);

                window.location.reload();
            });
        }
    }
})
</script>
