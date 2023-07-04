
<template>
    <div>
        <select v-if="users" v-model="selectedUser" @change="selectUser">
            <option disabled value="">Proszę wybrać użytkownika</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.email }}
            </option>
        </select>
        <div v-else>Loading...</div>

        <div v-if="currentUser">
            <h2>{{ currentUser.email }}</h2>
            <button v-if="currentUser.is_active" @click="deactivateUser(currentUser)">Dezaktywuj</button>
            <button v-else @click="activateUser(currentUser)">Aktywuj</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            users: null,
            selectedUser: "",
            currentUser: null
        };
    },
    methods: {
        fetchUsers() {
            axios.get(`http://localhost:8000/users`)
                .then(response => {
                    this.users = response.data;
                    this.users.forEach(user => {
                        user.is_active = !!user.is_active;
                    });
                })
                .catch(error => {
                    console.log(error);
                });
        },
        selectUser() {
            const user = this.users.find(user => user.id === this.selectedUser);
            this.currentUser = user;
        },
        deactivateUser(user) {
            axios.patch(`http://localhost:8000/users/${user.id}/deactivate`)
                .then(response => {
                    user.is_active = false;
                    console.log('User deactivated:', response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        activateUser(user) {
            axios.patch(`http://localhost:8000/users/${user.id}/activate`)
                .then(response => {
                    user.is_active = true;
                    console.log('User activated:', response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.fetchUsers();
    }
};
</script>
