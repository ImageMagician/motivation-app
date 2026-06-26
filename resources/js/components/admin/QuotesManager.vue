<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';

    const quotes = ref([]);
    const editing = ref(null);
    const errors = ref({});
    const loading = ref(false);
    const form = ref({
        body: '',
        author: '',
    });

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

    function resetForm() {
        form.value = { body: '', author: '' };
        errors.value = {};
        editing.value = null;
    }

    function edit(quote) {
        form.value = { body: quote.body, author: quote.author };
        editing.value = quote;
        errors.value = {};
    }

    async function save() {
        errors.value = {};
        try {
            if (editing.value) {
                console.log('save v2', `${API}/${editing.value.id}`);
                const { data } = await axios.put(`${API}/${editing.value.id}`, form.value);
                const i = quotes.value.findIndex(q => q.id === data.id);
                if (i !== -1) quotes.value[i] = data;
            } else {
                const {data} = await axios.post(API, form.value);
                quotes.value.unshift(data);
            }
            resetForm();
        }
        catch (e) {
            if (e.response?.status === 422) {
                errors.value = e.response.data.errors;
            } else {
                alert('Something went wrong. Please try again later');
            }
        }
    }

    async function remove(quote) {
        if (!confirm('Delete this quote?')) return;
        await axios.delete(`${API}/${quote.id}`);
        quotes.value = quotes.value.filter(q => q.id !== quote.id);
    }
</script>

<template>
    <div class="quotes max-w-4xl mx-auto py-20">
        <h1 class="text-2xl font-bold mb-4">Quotes</h1>
        <div class="form">
            <h2 class="text-xl font-bold mb-2">{{ editing ? 'Edit Quote' : 'Add Quote'}}</h2>

            <label for="body" class="block mb-2">
                Quote
            </label>
            <textarea v-model="form.body" id="body" class="w-full h-32 p-2 mb-4 border rounded border-gray-300 focus:border-gray-500 focus:outline-blue-100 focus:outline-4"></textarea>
            <span v-if="errors.body" class="text-red-500">{{ errors.body[0] }}</span>

            <label for="author" class="block mb-2">
                Author
            </label>
            <input type="text"
                   v-model="form.author"
                   id="author"
                   class="w-full p-2 mb-4 border rounded border-gray-300 focus:border-gray-500 focus:outline-blue-100 focus:outline-4"
                   placeholder="(Optional)"
            />

            <div class="actions">
                <button @click="save"
                        class="bg-blue-500 hover:bg-blue-700 font-bold text-white px-4 py-1 me-2 rounded"
                >
                    {{ editing ? 'Update' : 'Add' }}
                </button>
                <button v-if="editing"
                        class="border border-gray-500 hover:border-gray-700 px-4 py-1 me-2 rounded"
                        type="button"
                        @click="resetForm"
                >
                    Cancel
                </button>
            </div>

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
    </div>
</template>

<style scoped>

</style>
