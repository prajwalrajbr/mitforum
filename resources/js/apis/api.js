import axios from "axios";

let api = axios.create({
    baseURL: "https://mitforum.herokuapp.com/api"
});

api.defaults.withCredentials = true;

export default api;