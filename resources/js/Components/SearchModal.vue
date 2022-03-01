<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            <div class="relative mx-auto text-gray-600 lg:block hidden">
                <input
                    v-on:keyup="search" v-model="searchContent"
                    class="w-full border-2 border-gray-300 bg-white h-10 pl-2 pr-8 rounded-lg text-sm focus:outline-none"
                    type="text" name="search" placeholder="Search Crown"
                >
                <!-- <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 mr-2"> <i class="fas fa-search"></i> </button> -->
            </div>
        </template>
        <template #content>
            <div class="space-y-2">
                <h1 class="font-bold"> Result: </h1>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2" v-for="item in data" :key="item">
                        <img v-bind:src="'storage/' + (item.profile_photo_path ?? 'images/default-post.png')" class="rounded-full w-12 h-12 object-cover" alt="">
                        <div class="w-3/4">
                            <a v-if="item.name !== null" :href="'profiles?' + 'search=' + item.name" class="whitespace-nowrap overflow-hidden" style="text-overflow:ellipsis"> {{ item.name }} </a>
                            <a v-if="item.content !== null" :href="'posts?' + 'content=' + item.id" class="whitespace-nowrap overflow-hidden" style="text-overflow:ellipsis"> {{ item.content }} </a>
                        </div>
                    </div>
                </div> 
            </div>
        </template>
    </jet-dialog-modal>
</template>

<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal'
import axios from 'axios';

export default defineComponent({
    components: {
        JetDialogModal,
    },

    props: ['show'],

    data() {
        return {
            searchContent: '',
            data: [],
        }
    },

    // created() {
    //     if(this.show)
    //     {
    //         this.fetchSearchableData();
    //     }
    // },

    methods: {
        close() {
            this.$emit('close');
        },

        // search() {
        //     console.log(this.searchContent);
        // },

        search()
        {
            axios.get('/fetchSearchableData').then(response => {
                this.data = response.data.filter(item => this.searchCondition(item));
            })
        },

        searchCondition(item) {
            return String(item.name).toLowerCase().includes(this.searchContent.toLowerCase()) 
            || String(item.content).toLowerCase().includes(this.searchContent.toLowerCase());
        }
    }
})
</script>
