<template>
    <div>
        <h2>Lista klientów</h2>
        <ul>
            <li v-for="client in clientsResponse.data" :key="client.id">
                <router-link :to="{ name: 'ClientDetails', query: { id: client.id } }">{{ client.name }}</router-link>
            </li>
        </ul>
        <button @click="sortClients('name')">Sortuj według nazwy</button>
        <button @click="sortClients('email')">Sortuj według e-mail</button>
        <button @click="previousPage" :disabled="clientsResponse.current_page === 1">Poprzednia strona</button>
        <button @click="nextPage" :disabled="clientsResponse.current_page === clientsResponse.last_page">Następna
            strona</button>

        <h2>Szczegóły klienta</h2>
        <div v-if="selectedClient && selectedClient.id">
            <h3>{{ selectedClient.name }}</h3>
            <p>Pracownik przypisany: {{ selectedClient.employee.name }}</p>
            <p>Ostatnio kupione rzeczy:</p>
            <ul>
                <li v-for="order in selectedClient.orders" :key="order.id">{{ order.item }}</li>
            </ul>
            <p>Łączna kwota wydana: {{ selectedClient.totalSpent }}</p>
            <p>Posiadane samochody:</p>
            <ul>
                <li v-for="car in selectedClient.cars" :key="car.id">{{ car.name }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'CustomersList',
    data() {
        return {
            clientsResponse: {},
            selectedClient: null,
            currentSort: 'name',
            currentDirection: 'asc'
        };
    },
    methods: {
        fetchClients(page = 1) {
            axios.get(`http://localhost:8000/clients?page=${page}&sort=${this.currentSort}&direction=${this.currentDirection}`)
                .then(response => {

                    this.clientsResponse = response.data;
                })
                .catch(error => {
                    console.log(error);
                });

        },
        sortClients(sortField) {
            if (this.currentSort === sortField) {
                this.currentDirection = this.currentDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.currentSort = sortField;
                this.currentDirection = 'asc';
            }
            this.fetchClients();
        },
        previousPage() {
            if (this.clientsResponse.current_page > 1) {
                this.fetchClients(this.clientsResponse.current_page - 1);
            }
        },
        nextPage() {
            if (this.clientsResponse.current_page < this.clientsResponse.last_page) {
                this.fetchClients(this.clientsResponse.current_page + 1);
            }
        },



    },
    fetchClientDetails(id) {
        axios.get(`http://localhost:8000/clients/${id}`)
            .then(response => {
                this.selectedClient = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    mounted() {
        this.fetchClients();
    },
    watch: {
        $route(to) {
            if (to.name === 'ClientDetails') {

                const clientId = to.query.id;

                this.fetchClientDetails(clientId);
            }
        }
    }
};
</script>
