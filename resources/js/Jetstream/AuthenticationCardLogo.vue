<template>
    <Link :href="'/'">
        <img src="https://img.icons8.com/color/96/000000/crown.png"/>
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
    })
</script>
