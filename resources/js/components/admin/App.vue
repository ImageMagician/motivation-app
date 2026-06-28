<script setup>
    import { ref } from 'vue';
    import Dashboard from './Dashboard.vue';
    import QuotesManager from './QuotesManager.vue';

    const tab = ref('subscribers');
</script>

<template>
    <div class="admin">
        <nav class="mb-8 border-b border-gray-300 px-8">
            <button
                class="py-1 px-4 mx-1"
                :class="tab === 'subscribers' ? 'font-bold border-l border-t border-r border-gray-300 border-b-white translate-y-0.25 bg-white rounded-t-lg' : 'font-normal'"
                @click="tab = 'subscribers'"
            >
                Subscribers
            </button>
            <button
                class="py-1 px-4 mx-1"
                :class="tab === 'quotes' ? 'font-bold border-l border-t border-r border-gray-300 border-b-white translate-y-0.25 bg-white rounded-t-lg' : 'font-normal'"
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
