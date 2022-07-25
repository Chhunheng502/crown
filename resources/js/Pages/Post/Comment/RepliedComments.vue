<template>
  <div class="flex space-x-2">
    <crown-profile-image :src="comment.replier.profile_photo_path" />
    <div
      v-show="!viewEdit"
      class="w-full"
    >
      <div class="flex items-center space-x-2">
        <div class="p-3 bg-gray-300 rounded-2xl">
          <h5 class="font-bold">
            {{ comment.replier.name }}
          </h5>
          <p> <span class="font-extrabold"> {{ comment.commenter.name }} </span> {{ content }} </p>
        </div>
        <!-- make this disable after enter -->
        <popover
          v-show="user.id === comment.replier.id"
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
                class="w-full px-4 py-2 hover:bg-gray-300"
                @click="viewEdit = true"
              >
                Edit
              </button>
            </div>
            <div>
              <button
                type="button"
                class="w-full px-4 py-2 hover:bg-gray-100"
                @click="deleteComment"
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
        v-show="replyClicked && (user.id !== comment.replier.id)"
        class="flex mt-2 space-x-2 items-center"
        @submit.prevent="replyComment"
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
import CrownTextarea from '@/Components/Textarea.vue'

export default defineComponent({
  components: {
    CrownProfileImage,
    Popover,
    CrownInput,
    CrownTextarea
  },

  props: ['user', 'comment'],

  data () {
    return {
      content: this.comment.content,
      reply: '',

      replyClicked: false,
      viewEdit: false
    }
  },

  methods: {
    editComment () {
      axios.post('/editRepliedComment', { reply_id: this.comment.id, content: this.content })
        .then(response => {
          console.log(response.data)
        })

      this.viewEdit = false
    },

    deleteComment () {
      this.$emit('triggerDelete', { id: this.comment.id })
    },

    replyComment () {
      this.$emit('triggerReply', {
        replier: this.comment.replier,
        reply: this.reply
      })

      this.replyClicked = false
      this.reply = ''
    }
  }
})
</script>
