<template>
    <div class="flex items-center space-x-2">
        <img v-bind:src="'storage/' + user.profile_photo_path" class="rounded-full w-12 h-12 object-cover" alt="">
        <input type="text" v-on:click="showModal = true" class="w-full border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-300" placeholder="Write a post..." readonly>
        <label class="flex items-center p-2 rounded-md cursor-pointer transition hover:bg-gray-300">
            <i class="fas fa-photo-video mr-2"></i> Photo/Video
            <!-- should allow only photo and video for file type -->
            <input type="file" v-on:change="getFileUpload" class="hidden">
        </label>
        <jet-dialog-modal :show="showModal" @close="showModal = false">
            <template #title>
                <div class="text-center">
                    <h1 class="text-lg"> Create a post </h1>
                </div>
            </template>
            <template #content>
                <textarea type="text" v-model="content" class="w-full border-2 border-gray-300 rounded-lg" rows="5" placeholder="Write a post..." />
                <img v-if="isFile" v-bind:src="getImage" alt="">
            </template>
            <template #footer>
                <button type="button" v-on:click="createPost" class="w-full py-2 rounded-lg text-white bg-blue-400"> Post </button>
            </template>
        </jet-dialog-modal>
    </div>

</template>

<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import axios from 'axios';

export default defineComponent({
    components: {
        JetDialogModal,
    },

    props: ['user'],

    data() {
        return {
            content: '',
            fileUpload: '',

            showModal: false,
            isFile: false,
        }
    },

    computed: {
        getImage() {
            return URL.createObjectURL(this.fileUpload);
        }
    },

    methods: {
        getFileUpload(event) {
            this.fileUpload = event.target.files[0];

            this.showModal = true;
            this.isFile = true;
        },

        createPost() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            };

            let formData = new FormData();
            formData.append('user_id', this.user.id);
            formData.append('content', this.content);
            formData.append('photo', this.fileUpload);

            axios.post('/createPost', formData, config)
            .then(response => {
                console.log(response.data);

                window.location.reload();
            })
        }
    }

})
</script>
