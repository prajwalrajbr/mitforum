import api from './api';

export default {
    getCookie(){
        return api.get("/csrf-cookie");
    }
};