<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import SubscriberForm from './SubscriberForm.vue';

    const subscribers = ref([]);
    const editing = ref(null);
    const errors = ref({});
    const loading = ref(false);

    const API = '/admin/subscribers';

    async function load() {
        loading.value = true;
        try {
            const { data } = await axios.get(API);
            subscribers.value = data;
        }
        finally {
            loading.value = false;
        }
    }

    onMounted(load);

    async function save(payload) {
        errors.value = {};

        try {
            if (editing.value) {
                const { data } = await axios.put(`${API}/${editing.value.id}`, payload);
                const i = subscribers.value.findIndex(s => s.id === data.id);
                if (i !== -1) subscribers.value[i] = data;          // swap the edited row in place
                editing.value = null;
            }
            else {
                const { data } = await axios.post(API, payload);
                subscribers.value.unshift(data);                   // prepend the new one
            }
        }
        catch (e) {
            if (e.respons?.status === 422) {
                errors.value = e.response.data.errors;              // hand validation errors to the form
            }
            else {
                alert('Something went wrong. Please try again later');
            }
        }
    }

    function edit(subscriber) {
        editing.value = subscriber;
        errors.value = {};
    }

    function cancelEdit() {
        editing.value = null;
        errors.value = {};
    }

    async function remove(subscriber) {
        if (!confirm(`Delete ${subscriber.email}?`)) return;

        await axios.delete(`${API}/${subscriber.id}`);
        subscribers.value = subscribers.value.filter(s => s.id !== subscriber.email);
    }
</script>

<template>
    <div class="dashboard max-w-4xl mx-auto py-20">
        <h1 class="text-2xl font-bold mb-4">Subscribers</h1>

        <SubscriberForm
            :editing="editing"
            :errors="errors"
            @save="save"
            @cancel="cancelEdit"
            class="mb-8"
        />

        <p v-if="loading">Loading...</p>

        <table v-else class="border-collapse w-full">
            <thead>
                <tr>
                    <th class="p-2 border border-gray-200">Email</th>
                    <th class="p-2 border border-gray-200">Name</th>
                    <th class="p-2 border border-gray-200">Active</th>
                    <th class="p-2 border border-gray-200">Joined</th>
                    <th class="p-2 border border-gray-200"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="s in subscribers" :key="s.id">
                    <td class="p-2 border border-gray-200 w-full">{{ s.email }}</td>
                    <td class="p-2 border border-gray-200 text-nowrap">{{ s.name }}</td>
                    <td class="p-2 border border-gray-200 text-nowrap">{{ s.is_active ? 'Yes' : 'No' }}</td>
                    <td class="p-2 border border-gray-200 text-nowrap">{{ new Date(s.created_at).toLocaleDateString() }}</td>
                    <td class="p-2 border border-gray-200 text-nowrap">
                        <button @click="edit(s)" class="border rounded border-gray-300 hover:border-gray-500 mx-1 py-1 px-4">Edit</button>
                        <button @click="remove(s)" class="border rounded border-gray-300 hover:border-gray-500 mx-1 py-1 px-4">Delete</button>
                    </td>
                </tr>
                <tr v-if="!subscribers.length">
                    <td colspan="5" class="p-2">
                        No subscribers yet
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<style scoped>

</style>
