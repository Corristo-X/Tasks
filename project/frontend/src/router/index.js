import { createRouter, createWebHistory } from 'vue-router';

import CustomersList from '../components/CustomersList.vue';
import ClientDetails from '../components/ClientDetails.vue';
import ClientForm from '../components/ClientForm.vue';
import CarForm from '../components/CarForm.vue';
import NotificationsPage from '../components/NotificationsPage';
import UserActivationManager from '../components/UserActivationManager';
import { useAuthStore } from '../store/auth'

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
    path: '/notifications',
    component: NotificationsPage,
    beforeEnter: (to, from, next) => {
      const authStore = useAuthStore();
      console.log(authStore.name);
      if (!authStore.name) {
        next('/clients');  // Jeżeli użytkownik nie jest zalogowany przekieruj go do strony logowania
      } else {
        next();  // Jeżeli użytkownik jest zalogowany pozwól mu wejść na stronę
      }
    },
  },
  {
    path:'/useractivationmanager',
    name:'UserActivationManager',
    component:UserActivationManager,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
