<template>
  <jet-dropdown
    align="center"
    width="96"
  >
    <template #trigger>
      <div
        class="text-sm text-gray-500 cursor-pointer"
        @click="markNotifications"
      >
        <span v-if="responsive"> <i class="text-black fas fa-bell fa-lg" /> </span>
        <span v-else> Notifications </span>
        <span
          v-show="numOfUnread !== 0"
          class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"
        >{{ numOfUnread }}</span>
      </div>
    </template>

    <template #content>
      <div
        v-if="notifications.length !== 0"
        class="h-64 overflow-auto"
      >
        <div
          v-for="notification in notifications"
          :key="notification.id"
          class="px-2 py-1 hover:bg-gray-300 cursor-pointer"
          @click="checkNotificationType(notification, 'getEvent')"
        >
          <div class="flex space-x-2">
            <crown-image
              :src="notification.profile_photo_path ?? notification.data.profile_photo_path"
              class="w-14 h-14"
            />
            <div class="leading-5">
              <h1>
                <span class="font-bold"> {{ notification.name ?? notification.data.name }} </span>
                <span v-text="' ' + checkNotificationType(notification, 'getText')" />
              </h1>
              <p class="text-sm text-gray-400">
                {{ notification.created_at }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div
        v-else
        class="px-2 py-1 text-center"
      >
        <p> No notification just yet. </p>
      </div>
    </template>
  </jet-dropdown>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import JetDropdown from '@/Breeze/Dropdown.vue'
import CrownImage from '@/Components/Image.vue'

export default defineComponent({
  components: {
    JetDropdown,
    CrownImage
  },

  props: {
    userID: {
      type: Number
    },
    responsive: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      notifications: [],

      numOfUnread: 0
    }
  },

  created () {
    Echo.private('App.Models.User.' + this.userID)
      .notification(notification => {
        this.notifications.unshift(notification)
        this.numOfUnread++
      })

    this.fetchNotifications()
  },

  methods: {
    fetchNotifications () {
      axios.get('/fetchNotifications').then(response => {
        this.notifications = response.data.notifications
        this.numOfUnread = response.data.unreadNotifications.length
      })
    },

    markNotifications () {
      if (this.numOfUnread !== 0) {
        axios.post('/markNotifications').then(response => {
          console.log(response.data)
        })

        this.numOfUnread = 0
      }
    },

    checkNotificationType (notification, action) {
      let text = ''
      let event = ''

      if (String(notification.type).includes('FriendRequest')) {
        text = 'sent you a friend request'
        event = 'profiles?search=' + notification.data.name
      } else if (String(notification.type).includes('CommentReply')) {
        text = 'replied you in the comment'
        event = 'profiles?post=' + (notification.post_id ?? notification.data.post_id)
      } else if (String(notification.type).includes('Comment')) {
        text = 'commented on your post'
        event = 'profiles?post=' + (notification.post_id ?? notification.data.post_id)
      } else {
        text = 'shared your post'
        event = 'profiles?share=' + (notification.share_id ?? notification.data.share_id)
      }

      if (action == 'getText') {
        return text
      } else if (action == 'getEvent') {
        window.location.href = event
      }
    }
  }
})
</script>
