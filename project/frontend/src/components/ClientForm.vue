<template>
    <form @submit.prevent="addClient">
        @csrf
      <!-- pola formularza dla danych klienta -->
      <input v-model="name" type="text" placeholder="Imię i nazwisko" required>
      <input v-model="email" type="email" placeholder="Adres e-mail" required>
      <!-- inne pola formularza -->

      <!-- przycisk dodawania klienta -->
      <button type="submit">Dodaj klienta</button>
    </form>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        name: '',
        email: '',
        // inne pola danych klienta
      };
    },
    methods: {
      addClient() {
        // walidacja formularza przed wysłaniem żądania
        if (!this.validateForm()) {
          return;
        }

        // przygotowanie danych klienta do wysłania
        const clientData = {
          name: this.name,
          email: this.email,

          // inne pola danych klienta
        };

        // wysłanie żądania HTTP POST do dodania klienta
        axios.post('http://localhost:8000/clients', clientData)
          .then(response => {
            // obsługa sukcesu - klient został dodany
            console.log('Klient został dodany:', response.data);
            // wyczyść pola formularza po dodaniu klienta
            this.resetForm();
          })
          .catch(error => {
            // obsługa błędu - wystąpił problem podczas dodawania klienta
            console.error('Błąd podczas dodawania klienta:', error);
          });
      },
      validateForm() {
        // tutaj dokonaj walidacji wprowadzonych danych w formularzu
        // zwróć true, jeśli formularz jest poprawny, lub false w przeciwnym razie
        // możesz użyć biblioteki do walidacji, takiej jak Vuelidate
        // przykładowa walidacja: return this.name !== '' && this.email !== '';
        return true;
      },
      resetForm() {
        // zresetuj pola formularza do wartości początkowych
        this.name = '';
        this.email = '';
        // wyczyść inne pola danych klienta
      }
    }
  };
  </script>
