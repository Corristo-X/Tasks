<template>
    <div>

        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">

        </head>
        <div>
            <h1 v-if="name">Zalogowany użytkownik: {{ name }}</h1>

            <div v-if="error" class="error">{{ error }}</div>
        </div>
        <div>
        <label>Email:</label>
        <input v-model="email" type="text">

        <label>Password:</label>
        <input v-model="password" type="password">

        <button @click="login">Login</button>
        <button @click="logout">Wyloguj</button>


        <!-- Wyświetl nazwę zalogowanego użytkownika -->

    </div>
        <h1>Strona główna</h1>
        <ul>
            <li><router-link to="/clients">Lista klientów</router-link></li>
            <li><router-link to="/clientform">Dodawanie klientow</router-link></li>
            <li><router-link to="/carform">Dodawanie samochodów</router-link></li>
            <li><router-link to="/notifications">Powiadomienia</router-link></li>
            <li><router-link to="/useractivationmanager">Menedżer aktywacji użytkownika</router-link></li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../store/auth.js';

export default {
    data() {
        return {
            email: '',
            password: '',
            error:null,
        };
    },
    computed: {
        userId() {
    return useAuthStore().user ? useAuthStore().user.id : null;
  },
        name() {
            return useAuthStore().name
        },

        // Dodaj computed property do wyświetlania nazwy zalogowanego użytkownika

    },
    methods: {
        async login() {
            const authStore = useAuthStore();

            try {
                const response = await axios.post('http://localhost:8000/login', {
                    email: this.email,
                    password: this.password
                });

                authStore.setUser(response.data);
                localStorage.setItem('user', JSON.stringify(response.data));
                location.reload();



            } catch (error) {
                if (error.response) {
                    this.error = error.response.data.error;
                    console.error(error.response.data);
                } else if (error.request) {
                    console.error(error.request);
                } else {
                    console.error('Error', error.message);
                }
            }
        },
        async logout() {
            const authStore = useAuthStore();

            try {
                await axios.post('http://localhost:8000/logout', null, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}` // Przekazanie tokena uwierzytelniającego
                    }
                });
                localStorage.removeItem('user');
                authStore.logout();
                location.reload();

            } catch (error) {
                console.error('Error', error.message);
            }
        },
    },
    created() {
        // Sprawdź, czy dane użytkownika są dostępne w localStorage
        const storedUser = localStorage.getItem('user');
        if (storedUser) {
            // Zaloguj użytkownika automatycznie na podstawie danych z localStorage
            const user = JSON.parse(storedUser);
            useAuthStore().setUser(user);

        }
    },
};
</script>
