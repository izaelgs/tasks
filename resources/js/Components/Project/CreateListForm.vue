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

            <div class="col-span-full flex">
                <!-- Icone -->
                <div class="me-4">
                    <label for="icon" class="block text-sm font-medium leading-6 text-slate-200">Icone</label>

                    <button
                        @click="toggleEmojiArea()"
                        type="button"
                        class="
                            relative
                            w-10
                            rounded-md
                            border-0
                            h-10
                            text-gray-800
                            shadow-sm
                            ring-1
                            ring-inset
                            ring-gray-300
                            text-slate-100
                            placeholder:text-gray-400
                            active:ring-inset
                            active:ring-blue-400
                            active:bg-violet-600
                            active:text-blue-400
                            sm:text-sm
                            sm:leading-6"
                    >
                        <Icon
                            class="absolute start-0 bottom-0 pb-2 ps-2"
                            :icon="icon"
                            style="font-size: 2rem;"
                        />
                    </button>
                </div>

                <!-- Cor -->
                <div class="me-2">
                    <label for="color_hex" class="block text-sm font-medium leading-6 text-slate-200">Cor</label>

                    <button
                            @click="toggleColorArea()"
                            type="button"
                            class="
                                relative
                                w-10
                                h-10
                                p-1
                                rounded-md
                                border-0
                                text-gray-800
                                shadow-sm
                                ring-1
                                ring-inset
                                ring-gray-300
                                text-slate-100
                                placeholder:text-gray-400
                                active:ring-inset
                                active:ring-blue-400
                                active:bg-violet-600
                                active:text-blue-400
                                sm:text-sm
                                sm:leading-6"
                        >
                            <div
                                class="py-4 cursor-pointer m-0"
                                :style="`background-color: ${color_hex}`"
                            ></div>
                        </button>
                </div>
            </div>


            <!-- Adicionar -->
            <div class="sm:col-span-1 absolute bottom-0 right-0">
                <button class="bg-violet-600 h-10 w-auto px-4 w-full rounded-md border-0 shadow-sm ring-inset">Adicionar</button>
            </div>

            <!-- Icones -->
            <div
                class="transition-opacity duration-500 transition-[height] ease-out flex flex-wrap h-100"
                :class="emojiHidden ? 'h-0 opacity-0 overflow-hidden easy-in-out' : 'col-span-full h-full opacity-100 mt-2 mb-12'"
            >
                <template v-if="icones">
                    <div
                        v-for="icone in icones"
                    >
                        <Icon
                            class="p-2 cursor-pointer"
                            :icon="icone"
                            style="font-size: 2.2rem;"
                            @click="chooseIcon(icone)"
                        />
                    </div>
                </template>
            </div>

            <!-- Cores -->
            <div
                class="transition-opacity duration-500 transition-[height] ease-out flex flex-wrap h-100"
                :class="colorHidden ? 'h-0 opacity-0 overflow-hidden easy-in-out' : 'col-span-full h-auto opacity-100 mt-2 mb-12'"
            >
                <template v-if="colors">
                    <div
                        v-for="color in colors"
                        class="m-0"
                    >
                        <div
                            class="p-5 cursor-pointer m-0"
                            :style="`background-color: ${color}`"
                            @click="chooseColor(color)"
                        ></div>
                    </div>
                </template>
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
            icones : [
                'twemoji:1st-place-medal','twemoji:2nd-place-medal','twemoji:3rd-place-medal','twemoji:abacus','twemoji:accordion',
                'twemoji:adhesive-bandage','twemoji:aerial-tramway','twemoji:airplane','twemoji:airplane-arrival','twemoji:airplane-departure',
                'twemoji:alarm-clock','twemoji:alembic','twemoji:alien','twemoji:alien-monster','twemoji:ambulance','twemoji:american-football',
                'twemoji:amphora','twemoji:anatomical-heart','twemoji:anchor','twemoji:anger-symbol','twemoji:ant','twemoji:articulated-lorry',
                'twemoji:artist-palette','twemoji:atom-symbol','twemoji:auto-rickshaw','twemoji:automobile','twemoji:avocado','twemoji:axe',
                'twemoji:baby-bottle','twemoji:backpack','twemoji:bacon','twemoji:badminton','twemoji:bagel','twemoji:baguette-bread',
                'twemoji:balance-scale','twemoji:ballet-shoes','twemoji:balloon','twemoji:ballot-box-with-ballot','twemoji:banana','twemoji:banjo',
                'twemoji:bank','twemoji:bar-chart','twemoji:barber-pole','twemoji:baseball','twemoji:basket','twemoji:basketball',
                'twemoji:bat','twemoji:bathtub','twemoji:battery','twemoji:beach-with-umbrella','twemoji:beating-heart','twemoji:bed',
                'twemoji:beer-mug','twemoji:beetle','twemoji:bell','twemoji:bellhop-bell','twemoji:bento-box','twemoji:beverage-box',
                'twemoji:bicycle','twemoji:bikini','twemoji:billed-cap','twemoji:biohazard','twemoji:birthday-cake','twemoji:biting-lip',
                'twemoji:black-flag','twemoji:black-nib','twemoji:blossom','twemoji:blowfish','twemoji:blue-book','twemoji:blueberries',
                'twemoji:bomb','twemoji:bone','twemoji:bookmark','twemoji:bookmark-tabs','twemoji:books','twemoji:boomerang',
                'twemoji:bottle-with-popping-cork','twemoji:bouquet','twemoji:bow-and-arrow','twemoji:bowl-with-spoon','twemoji:bowling','twemoji:boxing-glove',
                'twemoji:brain','twemoji:bread','twemoji:brick','twemoji:bridge-at-night','twemoji:briefcase','twemoji:briefs',
                'twemoji:bright-button','twemoji:broom','twemoji:bubble-tea','twemoji:bubbles','twemoji:bucket','twemoji:building-construction',
                'twemoji:bullet-train','twemoji:bullseye','twemoji:burrito','twemoji:bus','twemoji:bus-stop','twemoji:butter',
                'twemoji:butterfly','twemoji:cactus','twemoji:calendar','twemoji:camel','twemoji:camera','twemoji:camping',
                'twemoji:candle','twemoji:candy','twemoji:canned-food','twemoji:canoe','twemoji:card-file-box','twemoji:card-index',
                'twemoji:card-index-dividers','twemoji:carousel-horse','twemoji:carp-streamer','twemoji:carpentry-saw','twemoji:carrot','twemoji:castle',
                'twemoji:chains','twemoji:chair','twemoji:chart-decreasing','twemoji:chart-increasing','twemoji:chart-increasing-with-yen','twemoji:cheese-wedge',
                'twemoji:chequered-flag','twemoji:cherries','twemoji:cherry-blossom','twemoji:chess-pawn','twemoji:chestnut','twemoji:chicken',
                'twemoji:children-crossing','twemoji:chocolate-bar','twemoji:chopsticks','twemoji:christmas-tree','twemoji:church','twemoji:cigarette',
                'twemoji:circus-tent','twemoji:cityscape','twemoji:cityscape-at-dusk','twemoji:clamp','twemoji:clapper-board','twemoji:clapping-hands',
                'twemoji:closed-mailbox-with-lowered-flag'
            ],

            colors: [
                '#64748b',
                '#6b7280',
                '#71717a',
                '#737373',
                '#78716c',
                '#ef4444',
                '#f97316',
                '#f59e0b',
                '#eab308',
                '#84cc16',
                '#22c55e',
                '#10b981',
                '#14b8a6',
                '#06b6d4',
                '#0ea5e9',
                '#3b82f6',
                '#6366f1',
                '#8b5cf6',
                '#a855f7',
                '#d946ef',
                '#ec4899',
                '#f43f5e'
            ],

            categories  : [],
            toasMessage : '',

            emojiHidden : true,
            colorHidden : true,

            project_id  : '1',
            title       : '',
            description : '',
            icon        : 'twemoji:1st-place-medal',
            color_hex   : '#8b5cf6',
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

        chooseIcon(icon) {
            this.icon = icon;
            this.emojiHidden = true;
        },

        chooseColor(color_hex) {
            this.color_hex = color_hex;
            this.colorHidden = true;
        },

        toggleEmojiArea() {
            this.emojiHidden = !this.emojiHidden;
            this.colorHidden = true;
        },

        toggleColorArea() {
            this.colorHidden = !this.colorHidden;
            this.emojiHidden = true;
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