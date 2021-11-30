<template>
    <textarea
        class="border-2 border-gray-300 rounded-lg"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
    />
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['modelValue'],

    emits: ['update:modelValue'],
})
</script>
