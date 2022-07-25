<template>
  <div class="space-y-2">
    <div
      v-for="chat in chats"
      :key="chat.id"
      class="hover:bg-gray-400 cursor-pointer"
      @click="sendReceiverId(isReceiver(chat.user2_id) ? chat.user2_id : chat.user_id)"
    >
      <profile-card
        :user="isReceiver(chat.user2_id) ? chat.receiver : chat.sender"
        :enable-link="false"
      />
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import ProfileCard from '@/Components/ProfileCard.vue'

export default defineComponent({
  components: {
    ProfileCard
  },

  props: ['from_user', 'chats'],

  methods: {
    sendReceiverId (receiverId) {
      this.$emit('chatClicked', receiverId)
    },

    isReceiver (id) {
      return this.from_user.id !== id
    }
  }
})
</script>
