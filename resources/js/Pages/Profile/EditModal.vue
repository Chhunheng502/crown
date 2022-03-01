<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            <div class="text-center">
                <h1 class="text-lg"> Edit Detail </h1>
            </div>
        </template>
        <template #content>
            <div class="space-y-2">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <i class="fas fa-briefcase"></i>
                    </span>
                    <input 
                        type="text"
                        class="w-full py-2 text-sm border-2 border-gray-300 rounded-lg pl-8 focus:outline-none bg-white"
                        v-model="edited_work"
                    >
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <i class="fas fa-house-user"></i>
                    </span>
                    <input 
                        type="text"
                        class="w-full py-2 text-sm border-2 border-gray-300 rounded-lg pl-8 focus:outline-none bg-white"
                        v-model="edited_place_lived"
                    >
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <i class="fas fa-birthday-cake"></i>
                    </span>
                    <input 
                        type="date"
                        class="w-full py-2 text-sm border-2 border-gray-300 rounded-lg pl-8 focus:outline-none bg-white"
                        v-model="edited_birth_date"
                    >
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex space-x-2">
                <button type="button" v-on:click="close" class="w-full py-2 rounded-lg text-white bg-blue-400"> Cancel </button>
                <button type="button" v-on:click="updateUserDetail" class="w-full py-2 rounded-lg text-white bg-blue-400"> Done </button>
            </div>
        </template>
    </jet-dialog-modal>
</template>

<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue';

export default defineComponent({
    components: {
        JetDialogModal,
    },

    props: ['user_detail', 'show'],

    data() {
        return {
            edited_work: this.user_detail.work,
            edited_place_lived: this.user_detail.place_lived,
            edited_birth_date: this.user_detail.birth_date,
        }
    },

    methods: {
        close() {
            this.$emit('close');
        },

        updateUserDetail() {

            let formData = new FormData();
            
            formData.append('id', this.user_detail.id);
            formData.append('work', this.edited_work);
            formData.append('place_lived', this.edited_place_lived);
            formData.append('birth_date', this.edited_birth_date);

            axios.post('/updateUserDetail', formData).then(response => {
                console.log(response.data);

                // window.location.reload();
            });
        }
    }
})
</script>
