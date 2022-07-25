<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            <crown-input
                type="text" class="w-full text-sm" name="search"
                placeholder="Search Crown" @keyup="search" v-model="searchContent"
            />
        </template>
        <template #content>
            <div class="space-y-2">
                <h1 class="font-bold"> Result: </h1>
                <div class="space-y-2" v-show="searchContent !== ''">
                    <div class="flex items-center space-x-2" v-for="item in data" :key="item">
                        <crown-profile-image v-if="item.profile_photo_path !== undefined" :src="item.profile_photo_path" />
                        <crown-image v-else src="images/default-post.png" class="w-12 h-12 rounded-full object-cover" alt="Default post image" />
                        <div class="w-3/4 whitespace-nowrap overflow-hidden overflow-ellipsis">
                            <a v-if="item.name !== undefined" :href="'profiles?' + 'search=' + item.name"> {{ item.name }} </a>
                            <!-- below is not complete yet -->
                            <a v-else :href="'profiles?' + 'post=' + item.id"> {{ item.content }} </a>
                        </div>
                    </div>
                </div> 
            </div>
        </template>
    </jet-dialog-modal>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import JetDialogModal from '@/Breeze/DialogModal'
import CrownInput from './Input.vue'
import CrownProfileImage from './ProfileImage.vue'
import CrownImage from './Image.vue';

export default defineComponent({
    components: {
        JetDialogModal,
        CrownInput,
        CrownProfileImage,
        CrownImage,
    },

    props: ['show'],

    data() {
        return {
            data: [],
            filterableData: [],

            searchContent: '',
        }
    },

    created() {
        this.fetchSearchableData();
    },

    methods: {
        close() {
            this.$emit('close');
        },

        fetchSearchableData() {
            axios.get('/fetchSearchableData').then(response => {
                this.data = response.data;
                this.filterableData = response.data;
            })
        },

        search()
        {
            this.data = this.filterableData.filter(item => this.searchCondition(item));
        },

        searchCondition(item) {
            return String(item.name).toLowerCase().includes(this.searchContent.toLowerCase()) 
            || String(item.content).toLowerCase().includes(this.searchContent.toLowerCase());
        }
    }
})
</script>
