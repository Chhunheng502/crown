<template>
    <div class="relative h-screen grid grid-cols-4 gap-4">
        <div class="px-2 py-3">
            <slot name="section-left"></slot>
        </div>
        <div class="col-span-2 px-2 py-3 ">
            <slot name="section-middle"></slot>
        </div>
        <div class="px-2 py-3">
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
