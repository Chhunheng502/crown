<template>
    <app-layout title="Crown">
        <section-layout>
            <template #section-left>
                <friend-requests> </friend-requests>
            </template>
            <template #section-middle>
                <news-feed :user="user"> </news-feed>
            </template>
            <template #section-right>
                <contact-list :user="user"> </contact-list>
            </template>
        </section-layout>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import SectionLayout from '@/Layouts/SectionLayout.vue'
import FriendRequests from './FriendRequests.vue'
import NewsFeed from './NewsFeed.vue'
import ContactList from './ContactList.vue';

export default defineComponent({
    props: ['user'],

    components: {
        AppLayout,
        SectionLayout,
        FriendRequests,
        NewsFeed,
        ContactList,
    },
})
</script>
