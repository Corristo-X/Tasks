<template>
    <div v-if="client">
    <h2>{{ client.name }}</h2>
    <p>Pracownik przypisany: {{ client.employee.name }}</p>
    <p>Ostatnio kupione rzeczy:</p>
    <ul>
      <li v-for="(order, index) in client.orders" :key="index">
        <p>Zamówienie {{ index + 1 }}:</p>
        <ul>
          <li v-for="(product, productIndex) in order.products" :key="productIndex">
            {{ product.name }} - {{ product.price }} PLN
          </li>
        </ul>
      </li>
    </ul>
    <p>Łączna kwota wydana: {{ client.totalSpent }} PLN</p>
    <p>Posiadane samochody:</p>
    <ul>
      <li v-for="car in client.cars" :key="car.id">{{ car.brand }} {{ car.model }} (Rok: {{ car.year }})</li>
    </ul>
  </div>
    <div v-else>Loading...</div>
  </template>


  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        client: null
      };
    },
    methods: {
       /* fetchClientDetails() {
  const clientId = this.$route.query.id;
  axios.get(`http://localhost:8000/clients/${clientId}`)
    .then(response => {
      this.client = response.data;
    })
    .catch(error => {
      console.log(error);
    });



      }
      */
      fetchClientDetails() {
  const clientId = this.$route.query.id;
  axios.get(`http://localhost:8000/clients/${clientId}`)
    .then(response => {
      this.client = response.data;

      // Obliczanie totalSpent
      let totalSpent = 0;
      this.client.orders.forEach(order => {
        order.products.forEach(product => {
          totalSpent += parseFloat(product.price);
        });
      });
      this.client.totalSpent = totalSpent.toFixed(2);
    })
    .catch(error => {
      console.log(error);
    });
}
    },
    mounted() {
      this.fetchClientDetails();
    }
  };
  </script>
