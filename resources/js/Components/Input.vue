<template>
    <input
        class="border-2 border-gray-300 bg-white rounded-lg focus:outline-none"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
    >
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['modelValue'],

    emits: ['update:modelValue'],
})
</script>
