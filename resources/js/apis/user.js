import api from './api';
import csrf from './csrf';

export default {
    async register(form) {
        await csrf.getCookie()
        return api.post("/register", form);
    },

    async login(form) {
        await csrf.getCookie()
        return api.post("/login", form);
    },

    async logout() {
        await csrf.getCookie()
        return api.post("/logout");
    },

    async auth() {
        await csrf.getCookie()
        return api.get("/user");
    }
};