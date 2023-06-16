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

        <form @submit.prevent="removeClient">
            @csrf
            <button type="submit">Usuń klienta</button>
        </form>
        <div v-if="error">
            <p>{{ error }}</p>
        </div>

    </div>
    <div v-else>Loading...</div>
</template>


<script>

import axios from 'axios';
export default {

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
            this.clientId = clientId;
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
        },
        removeClient() {
            axios.delete(`http://localhost:8000/clients/${this.clientId}`)
                .then(response => {
                    console.log('Klient został usunięty:', response.data);
                    this.$router.push('/clients');
                })
                .catch(error => {
                    this.error = 'Nie udało się usunąć klienta';
                    console.error('błą podczas usuwania klienta:',error.response);
                });
        },
    },
    data() {
        return {
            client: null,
            clientId: null,
            error: null,
        };
    },
    mounted() {
        this.fetchClientDetails();
    }
};
</script>
