<script setup>
  import { ref } from 'vue';
  import axios from 'axios';

  const email = ref('');
  const name = ref('');
  const message = ref('');
  const error = ref('');
  const loading = ref(false);

  async function submit() {
      loading.value = true;
      message.value = '';
      error.value = '';
      try {
          const { data } = await axios.post('/api/subscribe', {
              email: email.value,
              name: name.value,
          });
          message.value = data.message;
          email.value = '';
          name.value = '';
      }
      catch (e) {
          error.value = e.response?.data?.message ?? 'Something went wrong. Try again.';
      }
      finally {
          loading.value = false;
      }
  }
</script>

<template>
    <div class="card max-w-2xl mx-auto p-6">
        <h1 class="text-xl font-bold mb-3">Daily Motivation</h1>
        <p class="mb-3">One uplifting message in your inbox every morning.</p>
        <input type="text" v-model="name" placeholder="Your name (optional)" class="block w-full p-2 mb-3 border border-gray-200 rounded" />
        <input type="email" v-model="email" placeholder="you@example.com" class="block w-full p-2 mb-3 border border-gray-200 rounded" />
        <button :disabled="loading" @click="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ loading ? 'Subscribing...' : 'Subscribe' }}
        </button>
        <p v-if="message" style="color:green">{{ message }}</p>
        <p v-if="error" style="color:red">{{ error }}</p>
    </div>

</template>

<style scoped>

</style>
