// ApiService.js
import axios from 'axios';
import { Cookies } from 'quasar';

const apiClient = axios.create({
    baseURL: '/api/',
    headers: {
        'Content-Type'  : 'application/json',
    },
});

export default {

    async setToken (payload) {
        let response = await apiClient.post('/tokens/create', payload);

        console.log('Token', apiClient, apiClient.defaults.headers);

        if(response.data && response.data.token)
            apiClient.defaults.headers['Authorization'] = 'Bearer ' + response.data.token;
    },

    // Exemplo de função para buscar dados
    async get(endpoint) {

        console.log('token', Cookies.get('XSRF-TOKEN'));
        await axios.get('/sanctum/csrf-cookie')

        try {
            const response = await apiClient.get(endpoint);
            return response.data;
        } catch (error) {
            throw error;
        }
    },

    /**
     *
     * @param {String} endpoint
     * @param {Object} data
     * @returns {JSON.Object} response
     */
    async post(endpoint, data) {
        try {
            const response = await apiClient.post(endpoint, data);
            return response.data;
        } catch (error) {
            throw error;
        }
    },

    // Adicione outras funções de API conforme necessário
};
