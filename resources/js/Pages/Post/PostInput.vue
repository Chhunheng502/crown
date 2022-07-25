<template>
    <div class="flex items-center space-x-2">
        <crown-profile-image :src="user.profile_photo_path" />
        <crown-input
            type="text" class="w-full cursor-pointer hover:bg-gray-300" placeholder="Write a post..."
            @click="showModal = true" readonly
        />
        <!-- should allow only photo and video for file type -->
        <crown-file-input class="flex items-center p-2 rounded-lg hover:bg-gray-300" @change="getFileUpload">
            <i class="fas fa-photo-video mr-2"></i> Photo/Video
        </crown-file-input>
        <jet-dialog-modal :show="showModal" @close="showModal = false">
            <template #title>
                <!-- title component is generalizable -->
                <div class="text-center">
                    <h1 class="text-lg"> Create a post </h1>
                </div>
            </template>
            <template #content>
                <crown-textarea
                    type="text" class="w-full" rows="5"
                    placeholder="Write a post..." v-model="content"
                />
                <!-- can't use v-show here -->
                <div v-if="isFile" class="w-full h-auto">
                    <img :src="getImage" class="w-full h-full object-contain" alt="Post image" />
                </div>
            </template>
            <template #footer>
                <crown-button class="w-full py-2 bg-blue-400" @click="createPost"> Post </crown-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import CrownProfileImage from '@/Components/ProfileImage.vue'
import CrownInput from '@/Components/Input.vue'
import CrownFileInput from '@/Components/FileInput.vue'
import JetDialogModal from '@/Breeze/DialogModal.vue'
import CrownTextarea from '@/Components/Textarea.vue'
import CrownButton from '@/Components/Button.vue';


export default defineComponent({
    components: {
        CrownProfileImage,
        CrownInput,
        CrownFileInput,
        JetDialogModal,
        CrownTextarea,
        CrownButton,
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

            axios.post('/posts', formData, config)
            .then(response => {
                console.log(response.data);

                window.location.reload();
            })
        }
    }

})
</script>
