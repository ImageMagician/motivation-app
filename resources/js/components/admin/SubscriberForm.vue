<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    editing: { type: Object, default: null },       // subscribers being edited, or null = "add" mode
    errors: { type: Object, default: () => ({}) },  // validation errors being handed down
});

const emit = defineEmits(['save', 'cancel']);

const form = ref({
    email: '',
    name: '',
    is_active: true
});

// When the parent changes what's edited, reset the form to match
watch(
    () => props.editing,
    (subscriber) => {
        form.value = subscriber
            ? { email: subscriber.email, name: subscriber.name ?? '', is_active: !!subscriber.is_active }
            : { email: '', name: '', is_active: true };
    },
    { immediate: true }
)

function submit() {
    emit('save', { ...form.value});
}
</script>

<template>
    <div class="form">
        <h2 class="text-xl font-bold mb-4">{{ editing ? 'Edit Subscriber' : 'Add subscriber'}}</h2>

        <label class="block mb-2 mb-4">
            <span class="block mb-2">Email</span>
            <input type="email" v-model="form.email" class="block border rounded border-gray-200 focus:border-gray-500 p-2 w-full" />
        </label>

        <label class="block mb-2 mb-4">
            <span class="block mb-2">Name</span>
            <input type="text" v-model="form.name" class="block border rounded border-gray-200 focus:border-gray-500 p-2 w-full" />
        </label>

        <label class="block mb-2 mb-4">
            <input type="checkbox" v-model="form.is_active" />
            <span class="inline-block ml-1">Active</span>
        </label>

        <div class="actions">
            <button @click="submit" class="bg-blue-500 hover:bg-blue-700 font-bold text-white px-4 py-1 me-2 rounded">
                {{ editing ? 'Update' : 'Add' }}
            </button>
            <button v-if="editing" type="button" @click="emit('cancel')" class="border rounded border-gray-200 hover:border-gray-500 py-1 px-4">Cancel</button>
        </div>
    </div>
</template>

<style scoped>

</style>
