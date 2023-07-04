<template>
    <div>
        <h1>Notifications</h1>

        <div v-if="loading">Loading...</div>

        <div v-else>
            <div v-for="notification in notifications" :key="notification.id" class="card mb-3">
                <div class="card-header">{{ formatDate(notification.created_at) }}</div>
                <div class="card-body">
                    <p v-if="notification.data && JSON.parse(notification.data).car_id">Car ID: {{
                        JSON.parse(notification.data).car_id }}</p>
                    <p v-if="notification.data && JSON.parse(notification.data).client_id">Client ID: {{
                        JSON.parse(notification.data).client_id }}</p>
                    <p v-if="notification.data && JSON.parse(notification.data).message">Message: {{
                        JSON.parse(notification.data).message }}</p>
                </div>
            </div>


            <div v-if="notifications.length === 0">No notifications found.</div>

            <div v-if="pagination" class="pagination">
                <button @click="loadPreviousPage" :disabled="!pagination.prev_page_url">Previous</button>
                <button @click="loadNextPage" :disabled="!pagination.next_page_url">Next</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../store/auth.js';
export default {
    data() {
        return {
            loading: true,
            notifications: [],
            pagination: null,
            currentPage: 1,
        };
  },


    methods: {
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
            const date = new Date(dateString);
            return date.toLocaleString(undefined, options);
        },
        loadNotifications() {
            this.loading = true;
            const userId = useAuthStore().user.id;
            console.log(userId);
            // Przekazanie ID użytkownika jako parametru do zapytania API

            axios.get(`http://localhost:8000/notifications/${userId}`)
                .then(response => {
                    this.notifications = response.data.data;
                    this.pagination = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    this.loading = false;
                });
        },
        loadPreviousPage() {
            if (this.pagination && this.pagination.prev_page_url) {
                this.currentPage--;
                this.loadNotifications();
            }
        },
        loadNextPage() {
            if (this.pagination && this.pagination.next_page_url) {
                this.currentPage++;
                this.loadNotifications();
            }
        },
    },
    mounted() {
        this.loadNotifications();
    },
};
</script>

<style scoped>
.pagination {
    margin-top: 1rem;
}</style>
