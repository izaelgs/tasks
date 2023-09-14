// ApiService.js
import axios from 'axios';
import { Cookies } from 'quasar';

const apiClient = axios.create({
    baseURL: '/api/',
    headers: {
        'Content-Type'  : 'application/json',
        'Authorization' : Cookies.get('token') ?? '',
    },
});

export default {

    async setToken (payload) {
        let response = await apiClient.post('/tokens/create', payload);

        if(response.data && response.data.token) {
            let token = 'Bearer ' + response.data.token;
            Cookies.set('token', token);
            apiClient.defaults.headers['Authorization'] = token;
        }
    },

    // Exemplo de função para buscar dados
    async get(endpoint) {
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
