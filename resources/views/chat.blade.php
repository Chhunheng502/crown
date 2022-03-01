

<x-layout>
    <x-slot name="title"> Chat Page </x-slot>
    <x-slot name="content">
        <x-section-layout>
            <x-slot name="section_left">
                <div>
                    <h1 class="text-lg"> Chats </h1>
                </div>
                <div>
                    <input type="text" name="search" id="search" class="px-3 py-2" placeholder="Search Chat">
                </div>
                <x-chat-list />
            </x-slot>
            <x-slot name="section_middle">
                <div id="chat">
                    <chat-upper-bar :user="user"> </chat-upper-bar>
                    <chat-messages :messages="messages"></chat-messages>
                    <chat-form v-on:messageSent="addMessage" :user="user"></chat-form>
                </div>
            </x-slot>
            <x-slot name="section_right">
                Setting
            </x-slot>
        </x-section-layout>
    </x-slot>
</x-layout>