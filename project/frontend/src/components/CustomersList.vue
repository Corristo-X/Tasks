<template>
    <div>
        <h2>Lista klientów</h2>
        <div>
            <label for="filterField">Pole filtru:</label>
            <select v-model="filterField" id="filterField">
                <option value="name">Nazwa</option>
                <option value="email">E-mail</option>

            </select>
            <input v-model="filterValue" type="text" placeholder="Wartość filtra">
            <button @click="applyFilter">Filtruj</button>
        </div>
        <ul>
            <li v-for="client in clientsResponse.data" :key="client.id">
                <router-link :to="{ name: 'ClientDetails', query: { id: client.id } }">{{ client.name }}- {{ client.email }}</router-link>
            </li>
        </ul>
        <button @click="sortClients('name')">Sortuj według nazwy</button>
        <button @click="sortClients('email')">Sortuj według e-mail</button>
        <button @click="previousPage" :disabled="clientsResponse.current_page === 1">Poprzednia strona</button>
        <button @click="nextPage" :disabled="clientsResponse.current_page === clientsResponse.last_page">Następna
            strona</button>
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
            currentDirection: 'asc',
            filterField: 'name',
            filterValue: ''
        };
    },
    methods: {
        fetchClients(page = 1) {
            let url = `http://localhost:8000/clients?page=${page}&sort=${this.currentSort}&direction=${this.currentDirection}`;
            if (this.filterField && this.filterValue) {
                url += `&filter_field=${this.filterField}&filter_value=${this.filterValue}`;
            }

            axios.get(url)
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
        applyFilter() {
            this.fetchClients();
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
