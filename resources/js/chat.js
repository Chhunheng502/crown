Vue.component('chat-upper-bar', {
    template: `
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div>
                    <img v-bind:src="user.detail.picture" class="rounded-full w-12 h-12 object-cover" alt="">
                </div>
                <div>
                    <h1> {{ user.name }} </h1>
                </div>
            </div>
            <div class="flex space-x-2">
                <div>
                    <i class="fas fa-phone-volume"></i>
                </div>
                <div>
                    <i class="fas fa-video"></i>
                </div>
            </div>
        </div>
    `,

    props: ['user'],
});

Vue.component('chat-messages', {
    template: `
        <div style="width:100%;height:600px" class="overflow-auto bg-green-300">
            <div class="mr-20 space-y-5">
                
                <p class="max-w-max px-2 py-1 rounded-md bg-gray-400">
                    Hello World
                </p>
            </div>
        </div>
    `,

    props: ['messages'],
});


Vue.component('chat-form', {
    template: `
        <div class="flex items-center space-x-2">
            <div class="flex-initial flex space-x-2">
                <div>
                    <i class="fas fa-images"></i> Add photo
                </div>
                <div>
                    <i class="fas fa-smile"></i> Choose sticker
                </div>
            </div>
            <div class="flex-auto">
                <input type="text" name="search" id="search" class="w-full px-3 py-2 rounded-md" placeholder="Aa">
            </div>
            <div class="flex-initial">
                <i class="fas fa-heart text-red-500"></i>
            </div>
        </div>
    `,

    props: ['user'],

    data() {
        return {
            newMessage: ''
        }
    },

    methods: {
        sendMessage() {
            this.$emit('messageSent', {
                user: this.user,
                message: this.newMessage
            });

            this.newMessage = ''
        }
    }   
});

new Vue({
    el: '#chat',

    data: {
        messages: []
    },

    props: ['user'],

    created() {
        this.fetchMessages();

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                message: e.message.message,
                user: e.user
            });
        });
    },

    methods: {
        fetchMessages() {
            axios.get('/chat-box/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/chat-box/messages', message).then(response => {
              console.log(response.data);
            });
        },        
    }
});