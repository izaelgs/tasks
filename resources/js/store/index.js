import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state () {
        return {
            messages: []
        }
    },
    mutations: {
        addMessage (state, message) {
            message.hash = Math.random() * 10000;

            state.messages.push(message);

            setTimeout(() => {
                let indice = state.messages.find(m => m.hash == message.hash);
                indice = state.messages.indexOf(indice);

                state.messages.splice(indice, 1);
            }, 4800);
        }
    }
})

export default store;