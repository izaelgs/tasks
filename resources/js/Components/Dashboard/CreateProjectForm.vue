<template>
    <div
        class="col-span-2 text-white p-4 bg-gradient-to-r from-violet-500 to-blue-500 overflow-hidden shadow-sm sm:rounded-lg"
    >
        <form
            class="border-b border-gray-900/10 pb-12"
            @submit.stop.prevent="create"
        >
            <h2 class="text-base font-semibold leading-7 text-slate-200">Adicionar Projeto</h2>
            <p class="mt-1 text-sm leading-6 text-slate-300">Desbrave o mundo, crie idéias, pinte o quadro da vida com a sua cor.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <!-- Título -->
                <div class="col-span-full">
                    <label for="title" class="block text-sm font-medium leading-6 text-slate-200">Título</label>

                    <div class="mt-2">
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

                <!-- Descrição -->
                <div class="col-span-full">
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

                <!-- Categoria -->
                <div class="sm:col-span-2">
                    <label for="category_id" class="block text-sm font-medium leading-6 text-slate-200">Categoria</label>

                    <div class="mt-2">
                        <select
                            id="category_id"
                            v-model="category_id"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                            required
                        >
                            <option value="0" hidden>Selecione uma categoria</option>
                            <option
                                v-for="category in categories"
                                :value="category.id"
                            >{{ category.title }}</option>
                        </select>
                    </div>
                </div>

                <!-- Prioridade -->
                <div class="sm:col-span-1">
                    <label for="priority" class="block text-sm font-medium leading-6 text-slate-200">Prioridade</label>

                    <div class="mt-2">
                        <input
                            type="text"
                            name="priority"
                            id="priority"
                            v-model="priority"
                            max="10"
                            min="0"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Prazo -->
                <div class="sm:col-span-2">
                    <label for="deadline" class="block text-sm font-medium leading-6 text-slate-200">Prazo</label>

                    <div class="mt-2">
                        <input
                            type="date"
                            name="deadline"
                            id="deadline"
                            v-model="deadline"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Adicionar -->
                <div class="sm:col-span-1">
                    <button class="bg-slate-500 mt-8 py-1.5 w-full rounded-md border-0 shadow-sm ring-inset">Adicionar</button>
                </div>
            </div>
        </form>

        <ToastMessage v-if="toasMessage" :message="toasMessage"/>
    </div>
</template>

<script>
import ApiService from '@/services/ApiService';
import ToastMessage from '../ToastMessage.vue';

export default {
    data: () => {
        return {
            categories: [],
            toasMessage: '',

            category_id : 0,
            title       : '',
            description : '',
            priority    : 0,
            deadline    : '',
        };
    },

    methods: {
        async create() {
            try {
                let payload = {
                    category_id : this.category_id ? this.category_id : null,
                    team_id     : this.team_id,
                    title       : this.title,
                    description : this.description ? this.description : '...',
                    priority    : this.priority,
                    deadline    : this.deadline,
                };

                let response = await ApiService.post('project', payload);

                this.toasMessage = response;

                this.reset();

            } catch (error) {
                this.toasMessage = error.response;
            }
        },

        async getCategories() {
            try {
                let categories = await ApiService.get('category');
                this.categories = categories.data;
            } catch (error) {
                this.toasMessage = error.response;
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
            this.category_id = 0;
            this.title       = '';
            this.description = '';
            this.priority    = 0;
            this.deadline = this.getActualDate();
        }
    },

    watch: {
        toasMessage() {
            setTimeout(() => {
                this.toasMessage = null;
            }, 5000);
        }
    },

    created: function () {
        this.getCategories();
        this.deadline = this.getActualDate();
    },

    components: { ToastMessage }
}

</script>