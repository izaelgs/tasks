<template>
    <div
        class="fixed right-2 bottom-2"
    >
        <div
            v-for="message, indice in messages"
            id="toast-success"
            class="relative flex items-center w-full max-w-xs p-4 pb-8 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert"
        >
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"
                :class="status[message.atual_status].color_class">
                <Icon :icon="status[message.atual_status].icon" />
                <span class="sr-only">Check icon</span>
            </div>

            <div class="ml-3 text-sm font-normal">{{ message.data.message }}</div>

            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>

            <div class="absolute bottom-0 w-full pe-8">
                <div class="mb-4 h-1 rounded-full bg-gray-200">
                    <div
                        class="h-1 rounded-full animate-time-progress"
                        :class="status[message.atual_status].color_class"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { Icon } from '@iconify/vue';

export default {
    data: () => {
        return {
            icon: 'ic:baseline-check-circle',

            status: {
                success: {
                    icon: 'ic:baseline-check-circle',
                    color_class: 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200'
                },
                error: {
                    icon: 'ic:baseline-error',
                    color_class: 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200'
                },
                not_found: {
                    icon: 'mdi:file-search-outline',
                    color_class: 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200'
                },
                invalid_date: {
                    icon: 'ic:baseline-warning',
                    color_class: 'text-amber-500 bg-amber-100 dark:bg-amber-800 dark:text-amber-200'
                }
            }
        }
    },

    computed: {
        messages () {
            return this.$store.state.messages.map(message => {
                message.atual_status = 'error';

                switch (message.status) {
                    case 200:
                        message.atual_status = 'success';
                        break;
                    case 201:
                        message.atual_status = 'success';
                        break;
                    case 400:
                        message.atual_status = 'error';
                        break;
                    case 404:
                        message.atual_status = 'not_found';
                        break;
                    case 422:
                        message.atual_status = 'invalid_date';
                        break;

                    default:
                        break;
                }

                return message;
            })
        }
    },

    watch: {
        messages() {
            console.log('atualizando');
        }
    },

    props: ['message'],

    components: { Icon }
}

</script>

<style>

@keyframes widthAnimation {
    0% {
        width: 100%;
    }
    100% {
        width: 0%;
    }
}

</style>