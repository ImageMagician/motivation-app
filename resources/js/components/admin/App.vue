<script setup>
    import { ref } from 'vue';
    import Dashboard from './Dashboard.vue';
    import QuotesManager from './QuotesManager.vue';

    const tab = ref('subscribers');
</script>

<template>
    <div class="admin">
        <nav class="mb-8 border-b border-gray-300 pb-4">
            <button
                class="py-2 px-4 mx-2"
                :class="tab === 'subscribers' ? 'font-bold' : 'font-normal'"
                @click="tab = 'subscribers'"
            >
                Subscribers
            </button>
            <button
                class="py-2 px-4 mx-2"
                :class="tab === 'quotes' ? 'font-bold' : 'font-normal'"
                @click="tab = 'quotes'">
                Quotes
            </button>
        </nav>

        <Dashboard v-if="tab === 'subscribers'" />
        <QuotesManager v-else />
    </div>
</template>

<style scoped>

</style>
