<script setup>
    import { ref } from 'vue';
    import axios from 'axios';
    import Dashboard from './Dashboard.vue';
    import QuotesManager from './QuotesManager.vue';

    const tab = ref('subscribers');
    const profileMenu = ref(false);

    // Read the admin's name
    const adminName = ref(document.querySelector('meta[name="admin-name"]')?.content) ?? 'Admin';

    function toggleProfileMenu() {
        profileMenu.value = !profileMenu.value;
    }

    async function logout() {
        await axios.post('/logout');
        window.location.href = '/login?redirect=/admin';
    }
</script>

<template>
    <div class="admin mx-auto pb-20">
        <div class="flex justify-between items-center mb-8 py-2 px-8 border-b border-gray-300">
            <nav>
                <button
                    class="py-1 px-4 mx-1"
                    :class="tab === 'subscribers' ? 'font-bold' : 'font-normal'"
                    @click="tab = 'subscribers'"
                >
                    Subscribers
                </button>
                <button
                    class="py-1 px-4 mx-1"
                    :class="tab === 'quotes' ? 'font-bold' : 'font-normal'"
                    @click="tab = 'quotes'">
                    Quotes
                </button>
            </nav>
            <div class="relative">
                <button type="button"
                        @click="toggleProfileMenu"
                        class="px-2"
                        :class="profileMenu ? 'text-blue-500 font-bold' : 'text-gray-500'"
                >
                    {{ adminName }}
                </button>
                <div
                    class="absolute t-full left-0  border border-gray-300 p-4 bg-white shadow translate-y-3"
                    v-if="profileMenu"
                >
                    <button type="button"
                            @click="logout"
                            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded cursor-pointer"
                    >
                        Logout
                    </button>

                </div>
            </div>
        </div>

        <Dashboard v-if="tab === 'subscribers'" />
        <QuotesManager v-else />
    </div>
</template>

<style scoped>

</style>
