<template>
    <div id="messages" class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
        <div class="chat-message" v-for="message in messages" :key="message.id">
         <div class="flex items-end" v-bind:class="isSender(message.from_user_id) ? '' : 'justify-end'">
            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
               <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none text-base" v-bind:class="isSender(message.from_user_id) ? 'bg-gray-300 text-gray-600' : 'bg-blue-600 text-white'">{{ message.content }}</span></div>
            </div>
            <img v-bind:src="'storage/' + (isSender(message.from_user_id) ? from_user.profile_photo_path : to_user.profile_photo_path)" alt="My profile" class="w-6 h-6 rounded-full object-cover" v-bind:class="isSender(message.from_user_id) ? 'order-1' : 'order-2'">
         </div>
      </div>
   </div>
</template>

<script>            
    export default {
        props: ['messages', 'from_user', 'to_user'],

        methods: {
            isSender(id) {
                return this.from_user.id === id;
            },
        },
    };
</script>

