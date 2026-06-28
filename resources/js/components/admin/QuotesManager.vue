<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import QuotesForm from './QuotesForm.vue';
    import { useToast } from 'vue-toastification';

    const quotes = ref([]);
    const editing = ref(null);
    const errors = ref({});
    const loading = ref(false);
    const showForm = ref(false);
    const toast = useToast();

    async function toggleForm() {
        showForm.value
            ? closeForm()
            : ( editing.value = null, errors.value = {}, showForm.value = true );
    }

    const API = '/admin/quotes';

    async function load() {
        loading.value = true;
        try {
            const { data } = await axios.get(API);
            quotes.value = data;
        }
        finally {
            loading.value = false;
        }
    }

    onMounted(load);

    function closeForm() {
        showForm.value = false;
        editing.value = null;
        errors.value = {};
    }

    function edit(quote) {
        editing.value = quote;
        errors.value = {};
        showForm.value = true;
    }

    async function save(payload) {
        errors.value = {};
        try {
            if (editing.value) {
                const { data } = await axios.put(`${API}/${editing.value.id}`, payload);
                const i = quotes.value.findIndex(q => q.id === data.id);
                if (i !== -1) quotes.value[i] = data;
            } else {
                const {data} = await axios.post(API, payload);
                quotes.value.unshift(data);
            }
            toast.success('Quote saved');
            closeForm();
        }
        catch (e) {
            console.error(e);
            if (e.response?.status === 422) {
                errors.value = e.response.data.errors;
            } else {
                toast.error('Something went wrong. Please try again later');
            }
        }
    }

    async function remove(quote) {
        if (!confirm('Delete this quote?')) return;
        await axios.delete(`${API}/${quote.id}`);
        quotes.value = quotes.value.filter(q => q.id !== quote.id);
        toast.success('Quote deleted');
    }
</script>

<template>
    <div class="quotes max-w-4xl mx-auto py-20">
        <div class="flex justify-between items-center gap-3 mb-3">
            <h1 class="text-2xl font-bold mb-4">Quotes</h1>
            <button type="button"
                    @click="toggleForm"
                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded cursor-pointer"
            >
                {{ showForm ? 'Close' : 'Add Quote' }}
            </button>
        </div>
        <div
            class="form border rounded p-4 border-gray-300 shadow-md"
            v-if="showForm"
        >
            <h2 class="text-xl font-bold mb-2">{{ editing ? 'Edit Quote' : 'Add Quote'}}</h2>
            <QuotesForm
                :editing="editing"
                :errors="errors"
                @save="save"
                @cancel="closeForm()"
                class="mb-4"
            />
        </div>


        <!-- Show current quotes -->
        <p v-if="loading">Loading...</p>

        <div v-else>
            <h2 class="mt-8 text-xl font-bold">Current Quotes</h2>
            <table class="mt-2 border-collapse">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="p-2 font-bold text-start">Quote</th>
                        <th class="p-2 font-bold text-start">Author</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="q in quotes" :key="q.id"
                        class="even:bg-gray-100 border-b border-gray-300"
                    >
                        <td class="p-2 w-full">{{ q.body }}</td>
                        <td class="p-2 text-nowrap">{{ q.author }}</td>
                        <td class="p-2 text-nowrap">
                            <button
                                class="border border-gray-500 hover:border-gray-700 text-sm px-4 py-1 me-2 rounded"
                                type="button"
                                @click="edit(q)"
                            >
                                Edit
                            </button>
                            <button
                                class="border border-gray-500 hover:border-gray-700 text-sm px-4 py-1 me-2 rounded"
                                type="button"
                                @click="remove(q)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr v-if="!quotes.length">
                        <td colspan="3">
                            No quotes yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>
