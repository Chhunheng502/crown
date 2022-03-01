<template>
    <app-layout title="Chat">
        <section-layout>
            <template #section-left>
                <chat-list v-on:chatClicked="changeChat" :from_user="from_user" :chats="chats"> </chat-list>
            </template>
            <template #section-middle>
                <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col h-screen border-2 border-gray-300 rounded-lg">
                    <chat-upper-bar v-show="chats.length !== 0" :user="to_user"> </chat-upper-bar>
                    <chat-messages :messages="messages" :from_user="from_user" :to_user="to_user"></chat-messages>
                    <chat-form v-show="chats.length !== 0" v-on:messageSent="addMessage" :from_user="from_user" :to_user="to_user"> </chat-form>
                </div>
            </template>
            <template #section-right>
                <div>
                    
                </div>
            </template>
        </section-layout>
    </app-layout>
</template>

<style>
    .scrollbar-w-2::-webkit-scrollbar {
        width: 0.25rem;
        height: 0.25rem;
    }

    .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
        --bg-opacity: 1;
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--bg-opacity));
    }

    .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
        --bg-opacity: 1;
        background-color: #edf2f7;
        background-color: rgba(237, 242, 247, var(--bg-opacity));
    }

    .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
        border-radius: 0.25rem;
    }
</style>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import SectionLayout from '@/Layouts/SectionLayout.vue'
    import ChatList from './ChatList.vue'
    import ChatUpperBar from './ChatUpperBar.vue'
    import ChatMessages from './ChatMessages.vue'
    import ChatForm from './ChatForm.vue'
    import axios from 'axios';

    export default defineComponent({
        components: {
            AppLayout,
            SectionLayout,
            ChatList,
            ChatUpperBar,
            ChatMessages,
            ChatForm,
        },

        props: ['from_user', 'chats'],

        data() {
            return {
                newMessage: '',
                messages: [],
                to_user: [],
            }
        },

        // do you need to include user_id as well ?
        // it might conflict with the current user (to_user == current user)
        created() {
            Echo.private('chat')
                .listen('MessageSent', (e) => {
                    this.messages.push({
                    content: e.message.content
                });
            });

            this.fetchMessages();
        },

        methods: {
            changeChat(id) {
                // prepare a counter when localStorage value is undefined
                localStorage.setItem('chatKey', id);
                this.fetchMessages();
            },

            fetchMessages() {
                axios.post('/fetchMessages', {id: localStorage.getItem('chatKey')}).then(response => {
                    if(response.data.length > 0)
                    {
                        if(this.from_user.id === response.data[0].sender.id) {
                            this.to_user = response.data[0].receiver;
                        } else {
                            this.to_user = response.data[0].sender;
                        }

                        this.messages = response.data[0].messages;
                    }
                    else
                    {
                        this.createChat();
                    }
                });
            },

            addMessage(message) {
                this.messages.push(message);

                axios.post('/sendMessage', message).then(response => {
                    console.log(response.data);
                });
            },

            createChat() {
                axios.post('/createChat', {friend_id: localStorage.getItem('chatKey')}).then(response => {
                    console.log(response.data);

                    window.location.reload();
                })
            }
        },
    })
</script>
