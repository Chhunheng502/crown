<template>
  <div class="py-3 border-b-2 border-gray-200">
    <div class="flex items-center space-x-4">
      <img
        :src="'storage/' + user.profile_photo_path"
        alt=""
        class="w-10 sm:w-16 h-10 sm:h-16 rounded-full object-cover"
      >
      <div class="flex flex-col leading-tight">
        <div class="text-2xl mt-1 flex items-center">
          <span class="text-gray-700 mr-3"> {{ user.name }} </span>
          <span class="text-green-500">
            <svg
              width="10"
              height="10"
            >
              <circle
                cx="5"
                cy="5"
                r="5"
                fill="currentColor"
              />
            </svg>
          </span>
        </div>
        <span class="text-lg text-gray-600"> Active Now </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['user']
}
</script>
