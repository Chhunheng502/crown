<template>
  <div class="flex space-x-2">
    <crown-profile-image :src="comment.user.profile_photo_path" />
    <div
      v-show="!viewEdit"
      class="w-full"
    >
      <div class="flex items-center space-x-2">
        <div class="p-3 bg-gray-300 rounded-2xl">
          <h5 class="font-bold">
            {{ comment.user.name }}
          </h5>
          <p> {{ content }} </p>
        </div>
        <popover
          v-show="user.id === comment.user.id"
          popover-class="rounded-full w-8 h-8 hover:bg-gray-300"
        >
          <template #btnText>
            <i class="fas fa-ellipsis-h fa-sm" />
          </template>

          <template #items>
            <!-- it's more flexible if generalizing class of button to be dynamic -->
            <div>
              <button
                type="button"
                class="w-full px-4 py-2 hover:bg-gray-100"
                @click="viewEdit = true"
              >
                Edit
              </button>
            </div>
            <div>
              <button
                type="button"
                class="w-full px-4 py-2 hover:bg-gray-100"
                @click="deleteUserComment"
              >
                Delete
              </button>
            </div>
          </template>
        </popover>
      </div>
      <div class="flex ml-2 space-x-2 text-sm">
        <button class="hover:underline">
          Like
        </button>
        <button
          class="hover:underline"
          @click="replyClicked = true"
        >
          Reply
        </button>
        <p> {{ comment.created_at }} </p>
      </div>
      <form
        v-show="replyClicked && (user.id !== comment.user.id)"
        class="flex mt-2 space-x-2 items-center"
        @submit.prevent="replyUserComment"
      >
        <crown-profile-image
          :src="user.profile_photo_path"
          class="w-8 h-8"
        />
        <crown-input
          v-model="reply"
          type="text"
          class="w-full"
          placeholder="Write a comment..."
        />
      </form>
      <!-- replied comments container -->
      <div
        v-show="viewReply"
        class="mt-3 space-y-2"
      >
        <replied-comments
          v-for="comment in repliedComments"
          :key="comment.id"
          :user="user"
          :comment="comment"
          @triggerReply="replyOtherComment"
          @triggerDelete="deleteOtherComment"
        />
      </div>
      <button
        v-show="showRepliedCmtBtn()"
        type="button"
        class="ml-2 text-sm hover:underline"
        @click="viewReply = true"
      >
        <i class="fas fa-reply rotate-180 mr-2" /> {{ repliedComments.length }} Reply
      </button>
    </div>
    <form v-show="viewEdit">
      <crown-textarea
        v-model="content"
        type="text"
        class="w-full"
        rows="5"
        placeholder="Write something..."
        @keyup.enter="editComment"
      />
    </form>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import CrownProfileImage from '@/Components/ProfileImage.vue'
import Popover from '@/Components/Popover.vue'
import CrownInput from '@/Components/Input.vue'
import RepliedComments from './RepliedComments.vue'
import CrownTextarea from '@/Components/Textarea.vue'

export default defineComponent({
  components: {
    CrownProfileImage,
    Popover,
    CrownInput,
    RepliedComments,
    CrownTextarea
  },

  props: ['user', 'comment'],

  data () {
    return {
      repliedComments: [],

      content: this.comment.content,
      reply: '',

      replyClicked: false,
      viewReply: false,
      viewEdit: false
    }
  },

  created () {
    this.fetchRepliedComments()
    console.log(this.user.id)
  },

  methods: {
    editComment () {
      axios.put(`/comments/${this.comment.id}`, { content: this.content })
        .then(response => {
          console.log(response.data)
        })

      this.viewEdit = false
    },

    deleteUserComment () {
      this.$emit('triggerDelete', { id: this.comment.id })
    },

    deleteOtherComment (comment) {
      this.repliedComments.splice(this.repliedComments.findIndex(item => item.id == comment.id), 1)

      axios.post('/deleteRepliedComment', { reply_id: comment.id })
        .then(response => {
          console.log(response.data)
        })
    },

    fetchRepliedComments () {
      axios.post('/fetchRepliedComments', { comment_id: this.comment.id })
        .then(response => {
          this.repliedComments = response.data
        })
    },

    replyUserComment () {
      axios.post('/replyComment', { comment_id: this.comment.id, to_user_id: this.comment.user.id, content: this.reply })
        .then(response => {
          this.repliedComments.push(response.data[0])
        })

      this.replyClicked = false
      this.viewReply = true
    },

    replyOtherComment (comment) {
      axios.post('/replyComment', { comment_id: this.comment.id, to_user_id: comment.replier.id, content: comment.reply })
        .then(response => {
          this.repliedComments.push(response.data[0])
        })
    },

    showRepliedCmtBtn () {
      if (this.replyClicked || this.viewReply || this.repliedComments.length === 0) {
        return false
      }

      return true
    }
  }
})
</script>
