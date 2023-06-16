<template>
    <div>
      <h2>Lista klientów</h2>
      <ul>
        <li v-for="client in clients" :key="client.id">
            <router-link :to="{ name: 'ClientDetails', query: { id: client.id } }">{{ client.name }}</router-link>
        </li>
      </ul>

      <h2>Szczegóły klienta</h2>
      <div v-if="selectedClient">
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
    name:'CustomersList',
    data() {
      return {
        clients: [],
        selectedClient: null
      };
    },
    methods: {
      fetchClients() {
        axios.get('http://localhost:8000/clients')
        .then(response => {

          this.clients = response.data;
        })
        .catch(error => {
          console.log(error);
        });

      },



    },
    mounted() {
      this.fetchClients();
    },
    watch: {
      $route(to) {
        if (to.name === 'ClientDetails') {

          const clientId = to.params.id;
          console.log(to.params.id);
          this.fetchClientDetails(clientId);
        }
      }
    }
  };
  </script>
