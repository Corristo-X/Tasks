<template>

    <div id="app">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

      <img alt="Vue logo" src="./assets/logo.png">
      <HomePage/>
      <router-view></router-view>

    </div>
  </template>

  <script>
  import HomePage from './components/HomePage.vue';

  export default {
    name: 'App',
    components: {
      HomePage
    }
  }
  </script>

  <style>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }
  </style>
