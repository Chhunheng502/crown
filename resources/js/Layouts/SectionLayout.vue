<template>
    <div class="flex justify-between">
        <div class="w-1/4 px-2 py-3 hidden lg:block">
            <slot name="section-left"></slot>
        </div>
        <div class="flex-auto w-1/2 px-2 py-3">
            <slot name="section-middle"></slot>
        </div>
        <div class="w-1/4 px-2 py-3 hidden lg:block">
            <slot name="section-right"></slot>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    setup() {
        
    },
})
</script>
