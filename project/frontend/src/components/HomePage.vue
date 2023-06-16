<template>
    <div>
      <h1>Strona główna</h1>
      <ul>
        <li><router-link to="/clients">Lista klientów</router-link></li>
        <li><router-link to="/clientdetails">Detale klientów</router-link></li>
        <li><router-link to="/clientform">Dodawanie klientow</router-link></li>
      </ul>
    </div>
  </template>

  <script>
  export default {
    name: 'HomePage',
  };
  </script>
