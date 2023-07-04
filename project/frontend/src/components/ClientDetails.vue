<template>
    <div v-if="client">
        <h2>{{ client.name }}</h2>
        <p>Pracownik przypisany: {{ client.employee.name }}</p>
        <p type="email">Email Klienta: {{ client.email }}</p>
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
    <li v-for="car in client.cars" :key="car.id">
        {{ car.brand }} {{ car.model }} (Rok: {{ car.year }})
        <span v-if="Number(car.currently_using) === 1">
            - W użyciu
        </span>
        <span v-else-if="Number(car.currently_using) === 0">
            - Nie w użyciu
        </span>
    </li>
</ul>

        <form @submit.prevent="removeClient">
            @csrf
            <button type="submit">Usuń klienta</button>
        </form>
        <form @submit.prevent="updateClient">
            <label for="name">Nazwa:</label>
            <input v-model="client.name" id="name" type="text" maxlength="30" />

            <label for="email">E-mail:</label>
            <input v-model="client.email" id="email" type="email" maxlength="30" />
            <label for="employee">Pracownik:</label>
            <select v-model="client.employee_id" id="employee">
                <option v-for="employee in employees" :value="employee.id" :key="employee.id">
                    {{ employee.name }}
                </option>
            </select>
            <p>Samochody:</p>
            <div v-for="(car, index) in client.cars" :key="index">
                <label :for="`carBrand${index}`">Marka:</label>
                <input v-model="car.brand" :id="`carBrand${index}`" type="text" maxlength="15" />

                <label :for="`carModel${index}`">Model:</label>
                <input v-model="car.model" :id="`carModel${index}`" type="text" maxlength="15" />

                <label :for="`carYear${index}`">Rok:</label>
                <input v-model="car.year" :id="`carYear${index}`" type="number" />
                <label :for="`carUsage${index}`">Czy używany:</label>
                <input v-model="car.currently_using" :id="`carUsage${index}`" type="checkbox" />
            </div>

            <p>Zakupy:</p>
            <div v-for="(order, index) in client.orders" :key="index">
                <div v-for="(product, productIndex) in order.products" :key="productIndex">
                    <label :for="`productName${index}${productIndex}`">Nazwa produktu:</label>
                    <input v-model="product.name" :id="`productName${index}${productIndex}`" type="text" maxlength="30" />

                    <label :for="`productPrice${index}${productIndex}`">Cena produktu:</label>
                    <input v-model="product.price" :id="`productPrice${index}${productIndex}`" type="text" maxlength="7" />
                </div>
            </div>
            <button type="submit">Aktualizuj</button>
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
                    this.client.cars.forEach(car => {
                car.currently_using = !!car.currently_using;
            });

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
                    console.error('błą podczas usuwania klienta:', error.response);
                });
        },

        updateClient() {
            const clientData = {...this.client};
                clientData.cars.forEach(car => {
                car.currently_using = car.currently_using ? 1 : 0;
    });
            axios.put(`http://localhost:8000/clients/${this.clientId}`, this.client)

                .then(response => {
                    // obsługa sukcesu - klient został zaktualizowany
                    console.log('Klient został zaktualizowany:', response.data);
                    // przekierowanie na inną stronę lub wykonanie innych operacji
                })
                .catch(error => {
                    // obsługa błędu - wystąpił problem podczas aktualizacji klienta
                    console.error('Błąd podczas aktualizacji klienta:', error);
                });
        },
        fetchEmployees() {
            axios.get('http://localhost:8000/employees')
                .then(response => {
                    this.employees = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },


    },
    data() {
        return {
            client: null,
            employees: [],
            clientId: null,
            error: null,
        };
    },
    mounted() {
        this.fetchClientDetails();
        this.fetchEmployees();
    }
};
</script>
