<template>
    <button :type="type" class="rounded-lg text-white">
        <slot></slot>
    </button>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        type: {
            type: String,
            default: 'button',
        },
    }
})
</script>
