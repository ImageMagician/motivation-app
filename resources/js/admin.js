import './bootstrap';
import { createApp } from 'vue';
import AdminApp from './components/admin/App.vue';
import Toast from 'vue-toastification';
import "vue-toastification/dist/index.css";

// Send the CSRF token on every request so session-protected routes accept writes.
const token = document.querySelector('meta[name="csrf-token"]')?.content;
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}

// If session expires mid-use, go back to login.
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            window.location.href = '/login';
        }
        return Promise.reject(error)
    }
)

const app = createApp(AdminApp);
app.use(Toast);
app.mount('#admin-app');
