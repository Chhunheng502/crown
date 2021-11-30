<template>
    <label class="cursor-pointer transition">
        <slot> </slot>
        <!-- triggerEvent has no any effect, you can change to any name -->
        <!-- better to use emit explicitly -->
        <input type="file" class="hidden" @change="triggerEvent">
    </label>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({

})
</script>
