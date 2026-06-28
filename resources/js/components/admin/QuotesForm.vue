<script setup>
    import {ref, watch} from "vue";

    const props = defineProps({
        editing: {
            type: Object,
            default: null,
        },
        errors: {
            type: Object,
            default: () => ({})
        }
    });

    const emit = defineEmits(['save', 'cancel']);
    const form = ref({
        body: '',
        author: '',
    })

    watch(
        () => props.editing,
        (quote) => {
            form.value = quote
                ? { body: quote.body, author: quote.author ?? '' }
                : { body: '', author: '' };
        },
        { immediate: true }
    );

    function save() {
        emit('save', { ...form.value });
    }

</script>

<template>
    <div class="form">
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
                    @click="emit('cancel')"
            >
                Cancel
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
