<template>
    <form @submit.prevent="addCar">
      @csrf

      <!-- Pola formularza dla danych samochodu -->
 <!-- Dodaj v-if="selectedClient" do elementów zależnych od selectedClient -->
<select v-model="selectedClient" required>
  <option disabled value="">Wybierz klienta</option>
  <option v-for="client in clients" :value="client" :key="client.id">
    {{ client.name }}
  </option>
</select>

<!-- Przycisk do dodania samochodu powinien być wyłączony, jeżeli nie wybrano klienta -->

<select v-model="selectedCar" @change="onCarSelected" >
      <option disabled value="">Wybierz samochód</option>
      <option v-for="car in cars" :value="car" :key="car.id">
        {{ car.brand }} - {{ car.model }} ({{ car.year }})
      </option>
    </select>

      <input v-model="brand" type="text" placeholder="Marka samochodu" required>
      <input v-model="model" type="text" placeholder="Model samochodu" required>
      <input v-model="year" type="text" placeholder="Rok produkcji" required>
      <input v-model="currentlyUsing" type="checkbox"> Czy obecnie używany?

      <!-- Przycisk dodawania samochodu -->
      <button type="submit" :disabled="!selectedClient">Dodaj samochód ręcznie</button>
      <p v-if="selectedCar">
      Wybrany samochód zostanie przypisany do klienta.
    </p>
    <p v-else>
      Wprowadzone dane zostaną użyte do stworzenia nowego samochodu.
    </p>

    </form>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        selectedClient: null,
      selectedCar: null,
        clientId: '',
        brand: '',
        model: '',
        year: '',
        currentlyUsing: false,
        clients: [],
        cars: []
      };
    },
    methods: {
        addCar() {
  if (this.selectedClient && this.selectedClient.id) {
    const carData = {
      brand: this.brand,
      model: this.model,
      year: this.year,
      client_id: this.selectedClient.id,
      currently_using: this.currentlyUsing,
    };

    if (this.selectedCar) {
      // Wykonaj akcję PUT - aktualizuj istniejący samochód
      axios.put(`http://localhost:8000/cars/${this.selectedCar.id}`, carData)
        .then(response => {
          console.log('Samochód został przypisany do klienta:', response.data);
          this.resetForm();
        })
        .catch(error => {
          console.error('Błąd podczas przypisywania samochodu:', error);
        });
    } else {
      // Wykonaj akcję POST - dodaj nowy samochód
      axios.post('http://localhost:8000/cars', carData)
        .then(response => {
          console.log('Samochód został dodany:', response.data);
          this.resetForm();
        })
        .catch(error => {
          console.error('Błąd podczas dodawania samochodu:', error);
        });
    }
  }
},
onCarSelected() {
      if (this.selectedCar) {
        this.brand = this.selectedCar.brand;
        this.model = this.selectedCar.model;
        this.year = this.selectedCar.year;
      } else {
        this.brand = '';
        this.model = '';
        this.year = '';
      }
    },

    resetForm() {
      this.selectedClient = null;
      this.selectedCar = null;
      this.brand = '';
      this.model = '';
      this.year = '';
      this.currentlyUsing = false;
    },
    fetchClients() {
      axios.get('http://localhost:8000/clients/all')
        .then(response => {
          this.clients = response.data;
        })
        .catch(error => {
          console.error('Błąd podczas pobierania klientów:', error);
        });
    },
    fetchCars() {
      axios.get('http://localhost:8000/cars')
        .then(response => {
          this.cars = response.data;
        })
        .catch(error => {
          console.error('Błąd podczas pobierania samochodów:', error);
        });
    },
  },
  mounted() {
    this.fetchClients();
    this.fetchCars();
  }
};
</script>
