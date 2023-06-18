import { createRouter, createWebHistory } from 'vue-router';

import CustomersList from '../components/CustomersList.vue';
import ClientDetails from '../components/ClientDetails.vue';
import ClientForm from '../components/ClientForm.vue';
import CarForm from '../components/CarForm.vue';
import NotificationsPage from '../components/NotificationsPage';
//import Cars from '../views/Cars.vue';
//import Employees from '../views/Employees.vue';

const routes = [

  {
    path: '/clients',
    name: 'Clients',
    component: CustomersList,
  },
  {
    path:'/clientDetails',
    name:'ClientDetails',
    component:ClientDetails,
  },
  {
    path:'/clientform',
    name:'ClientForm',
    component:ClientForm,
  },
  {
    path:'/carform',
    name:'CarForm',
    component:CarForm,
  },
  {
    path:'/notifications',
    name:'NotificationsPage',
    component:NotificationsPage,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
