<template>
    <div>
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">

        </head>
      <h1>Strona główna</h1>
      <ul>
        <li><router-link to="/clients">Lista klientów</router-link></li>
        <li><router-link to="/clientform">Dodawanie klientow</router-link></li>
        <li><router-link to="/carform">Dodawanie samochodów</router-link></li>
        <li><router-link to="/notifications">Powiadomienia</router-link></li>
      </ul>
    </div>
  </template>

  <script>
  export default {
    name: 'HomePage',
  };
  </script>
