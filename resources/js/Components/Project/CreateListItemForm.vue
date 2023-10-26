<template>
    <div class="w-full text-white overflow-hidden shadow-sm rounded-lg mt-2">
        <form
            class="text-white p-4 bg-gradient-to-r from-transparent to-teal-500 overflow-hidden shadow-sm"
            @submit.stop.prevent="create"
        >
            <div class="mt-5 grid grid-flow-row-dense grid-cols-4 gap-x-4 gap-y-4 md:grid-cols-6 relative">
                <!-- Título -->
                <div class="col-span-4">
                    <label for="title" class="block text-sm font-medium leading-6 text-slate-200">Título</label>

                    <div class="mt-1">
                        <input
                            type="text"
                            name="title"
                            id="title"
                            autocomplete="title"
                            v-model="title"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Prazo -->
                <div class="col-span-4">
                    <label for="deadline" class="block text-sm font-medium leading-6 text-slate-200">Prazo</label>

                    <div class="mt-1">
                        <input
                            type="date"
                            name="deadline"
                            id="deadline"
                            autocomplete="deadline"
                            v-model="deadline"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Valor -->
                <div class="col-span-2">
                    <label for="value" class="block text-sm font-medium leading-6 text-slate-200">Valor</label>

                    <div class="mt-1">
                        <input
                            type="number"
                            name="value"
                            id="value"
                            autocomplete="value"
                            v-model="value"
                            step="0.01"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Prioridade -->
                <div class="col-span-2">
                    <label for="priority" class="block text-sm font-medium leading-6 text-slate-200">Prioridade</label>

                    <div class="mt-1">
                        <input
                            type="number"
                            name="priority"
                            id="priority"
                            min="0"
                            max="10"
                            autocomplete="priority"
                            v-model="priority"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Descrição -->
                <div class="col-span-6">
                    <div class="relative">
                        <textarea
                            type="text"
                            name="description"
                            id="description"
                            rows="4"
                            class="peer block w-full rounded-md border-0 pt-4 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder=" "
                            v-model="description"
                        ></textarea>

                        <label
                            for="description"
                            class="absolute text-sm font-medium text-slate-200 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] left-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2"
                        >Descrição</label>
                    </div>
                </div>

                <!-- Adicionar -->
                <div class="sm:col-span-1 absolute bottom-0 right-0">
                    <button class="bg-teal-600 h-10 w-auto px-4 w-full rounded-md border-0 shadow-sm ring-inset">Adicionar</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>

import { Icon } from '@iconify/vue';

import ApiService from '@/services/ApiService';

export default {
    props: {
        project_list_id : Number,
    },
    data: () => {
        return {
            title           : '',
            description     : '',
            priority        : 0,
            deadline        : '',
            value           : 0,
        };
    },

    methods: {
        async create() {
            try {
                let payload = {
                    project_list_id : this.project_list_id,
                    title           : this.title,
                    description     : this.description,
                    priority        : this.priority,
                    deadline        : this.deadline,
                    value           : this.value,
                };

                let message = await ApiService.post('item', payload);

                this.$store.commit('addMessage', message);

                this.reset();
            } catch (error) {
                this.$store.commit('addMessage', error.response);
            }
        },

        getActualDate() {
            let hoje = new Date();
            let ano = hoje.getFullYear();
            let mes = String(hoje.getMonth() + 1).padStart(2, '0');
            let dia = String(hoje.getDate()).padStart(2, '0');

            let dataAtual = `${ano}-${mes}-${dia}`;
            return dataAtual;
        },

        reset() {
            this.title          = '';
            this.description    = '';
            this.priority       = 0;
            this.deadline       = this.getActualDate();
            this.value          = 0;
        },
    },

    created: function () {
        this.reset();
    },

    components: { Icon }
}

</script>