import { createRouter, createWebHistory } from 'vue-router';

import CustomersList from '../components/CustomersList.vue';
import ClientDetails from '../components/ClientDetails.vue';
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
  /*{
    path: '/cars',
    name: 'Cars',
    component: Cars,
  },
  {
    path: '/employees',
    name: 'Employees',
    component: Employees,
  },
  */
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
