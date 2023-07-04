import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: {
      id: null,
      // inne pola użytkownika
    },
    token: null,
    name: null,
    role: null,
    message: null,
  }),
  actions: {
    setUser(payload) {
        console.log(payload.id)
      this.user.id = payload.id;
      this.token = payload.token;
      this.name = payload.name;
      this.role = payload.role;
    },
    logout() {
      this.user.id = null;
      this.token = null;
      this.name = null;
      this.role = null;
      this.imie = null;
    },
    setName(imie) {
      this.name = imie;
    },
  },
});
