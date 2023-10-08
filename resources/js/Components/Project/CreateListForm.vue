<template>

    <form
        class="text-white p-4 bg-gradient-to-r from-violet-500 to-blue-400 overflow-hidden shadow-sm sm:rounded-lg"
        @submit.stop.prevent="create"
    >
        <h2 class="text-base font-semibold leading-7 text-slate-200">Adicionar Lista</h2>
        <p class="mt-1 text-sm leading-6 text-slate-300">Desbrave o mundo, crie idéias, pinte o quadro da vida com a sua cor.</p>

        <div class="mt-5 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-6 relative">
            <!-- Título -->
            <div class="col-span-full">
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

            <!-- Icone -->
            <div class="sm:col-span-1">
                <label for="icon" class="block text-sm font-medium leading-6 text-slate-200">Icone</label>

                <div class="mt-1">
                    <button
                        @click="toggleEmojiArea()"
                        type="button"
                        class="relative w-10 rounded-md border-0 h-10 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <Icon
                            class="text-slate-100 absolute start-0 bottom-0 pb-2 ps-2"
                            :icon="icon"
                            style="font-size: 2rem;"
                        />
                    </button>
                </div>
            </div>

            <!-- Cor -->
            <div class="sm:col-span-1">
                <label for="color_hex" class="block text-sm font-medium leading-6 text-slate-200">Cor</label>

                <div class="mt-1">
                    <input
                        type="color"
                        name="color_hex"
                        id="color_hex"
                        v-model="color_hex"
                        class="block w-full rounded-md border-0 h-10 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                </div>
            </div>

            <!-- Adicionar -->
            <div class="sm:col-span-1 absolute bottom-0 right-0">
                <button class="bg-violet-600 h-10 w-auto px-4 w-full rounded-md border-0 shadow-sm ring-inset">Adicionar</button>
            </div>

            <div
                class="col-span-full transition-all"
                :class="{ hidden: emojiHidden }"
            >
                escolha
            </div>
        </div>

        <ToastMessage v-if="toasMessage" :message="toasMessage"/>
    </form>
</template>

<script>

import { Icon } from '@iconify/vue';

import ApiService from '@/services/ApiService';
import ToastMessage from '../ToastMessage.vue';

export default {
    data: () => {
        return {
            categories  : [],
            toasMessage : '',

            emojiHidden : true,

            project_id  : '1',
            title       : '',
            description : '',
            icon        : 'material-symbols:sentiment-very-satisfied-outline',
            color_hex   : '#C246F2',
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
        },

        toggleEmojiArea() {
            this.emojiHidden = !this.emojiHidden;
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

    components: { ToastMessage, Icon }
}

</script>