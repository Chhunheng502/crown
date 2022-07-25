<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('home')" :active="route().current('home')">
                                    News Feed
                                </jet-nav-link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('chat')" :active="route().current('chat')">
                                    Chat
                                </jet-nav-link>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <div class="ml-3 relative">
                                    <notifications :userID="$page.props.auth.user.id"> </notifications>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="relative mx-auto text-gray-600 lg:block hidden" v-on:click="showModal = true">
                                <input
                                    class="border-2 border-gray-300 bg-white h-10 pl-2 pr-8 rounded-lg text-sm cursor-pointer focus:outline-none hover:bg-gray-300"
                                    type="text" placeholder="Search Crown" readonly
                                >
                                <button type="button" class="absolute right-0 top-1/2 transform -translate-y-1/2 mr-2"> <i class="fas fa-search"></i> </button>

                                <search-modal :show="showModal" @close="showModal = false"> </search-modal>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <div class="ml-3 relative">
                                    <jet-dropdown align="right" width="48">
                                        <template #trigger>
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </template>

                                        <template #content>
                                            <jet-dropdown-link :href="'profiles?' + 'search=' + $page.props.auth.user.name">
                                                Profile
                                            </jet-dropdown-link>

                                            <div class="border-t border-gray-100"></div>

                                            <form @submit.prevent="logout">
                                                <jet-dropdown-link as="button">
                                                    Log Out
                                                </jet-dropdown-link>
                                            </form>
                                        </template>
                                    </jet-dropdown>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center sm:hidden">
                            <jet-dropdown align="center" width="96">
                                <template #trigger>
                                    <div class="cursor-pointer">
                                        <span class="mr-4"> <i class="fas fa-user-friends fa-lg"></i> </span>
                                    </div>
                                </template>

                                <template #content>
                                    <div class="px-2 py-1">
                                        <friend-requests :user="$page.props.auth.user" :responsive="true"> </friend-requests>
                                    </div>
                                </template>
                            </jet-dropdown>
                            <jet-dropdown align="center" width="96">
                                <template #trigger>
                                    <div class="cursor-pointer">
                                        <span class="mr-4"> <i class="fas fa-address-book fa-lg"></i> </span>
                                    </div>
                                </template>

                                <template #content>
                                    <div class="px-2 py-1">
                                        <contact-list :user="$page.props.auth.user" :responsive="true"> </contact-list>
                                    </div>
                                </template>
                            </jet-dropdown>
                            <notifications :userID="$page.props.auth.user.id" :responsive="true"> </notifications>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div>
                                <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link :href="route('home')">
                                News Feed
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('chat')">
                                Chat
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="'profiles?' + 'search=' + $page.props.auth.user.name">
                                Profile
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import BreezeApplicationLogo from '@/Breeze/ApplicationLogo.vue'
    import JetNavLink from '@/Breeze/NavLink.vue'
    import Notifications from '@/Pages/Home/Notifications'
    import SearchModal from '@/Components/SearchModal.vue'
    import JetDropdown from '@/Breeze/Dropdown.vue'
    import JetDropdownLink from '@/Breeze/DropdownLink.vue'
    import FriendRequests from '@/Pages/Home/FriendRequests.vue'
    import ContactList from '@/Pages/Home/ContactList.vue'
    import JetResponsiveNavLink from '@/Breeze/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head,
            BreezeApplicationLogo,
            JetNavLink,
            Notifications,
            SearchModal,
            JetDropdown,
            JetDropdownLink,
            FriendRequests,
            ContactList,
            JetResponsiveNavLink,
            Link,
        },

        data() {
            return {
                showingNavigationDropdown: false,
                showModal: false,
            }
        },

        methods: {
            logout() {
                localStorage.removeItem('chatKey');
                
                this.$inertia.post(route('logout'));
            },
        }
    })
</script>
