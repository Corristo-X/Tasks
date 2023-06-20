import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: null,
        name: null,  // Dodane pole 'name'
        role: null,
        message: null,
    }),
    actions: {
        setUser(payload) {
            this.user = payload.user;
            this.token = payload.token;
            this.name = payload.name;  // Ustaw pole 'name'
            this.role = payload.role;
        },
        logout() {
            this.user = null;
            this.token = null;
            this.name = null;
            this.role = null;
            this.imie = null;
        },
        setName(imie){
            this.name=imie;
        }
    },
});
