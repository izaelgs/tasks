<template>
    <div class="col-span-2 text-white overflow-hidden shadow-sm sm:rounded-lg">
        <CreateListForm />
    </div>

    <ToastMessage v-if="toastMessage" :message="toastMessage"/>
</template>

<script>
import ToastMessage from '@/Components/ToastMessage.vue';
import ApiService from '@/services/ApiService';

import CreateListForm from '@/Components/Project/CreateListForm.vue';

export default {
    async setup() {
        try {
            const request_lists = await ApiService.get('list');
            const lists         = request_lists.data;

            const toastMessage = '';

            return {
                lists,
                toastMessage
            };
        } catch (error) {
            const toastMessage  = error.response.status != 404 ? error.response : '';
            const lists         = [];

            return {
                lists,
                toastMessage
            };
        }
    },

    methods: {
        isoToLocaleString(date) {
            date = new Date(date + ' 00:00:00');

            return date.toLocaleDateString();
        }
    },

    watch: {
        toastMessage() {
            setTimeout(() => {
                this.toastMessage = null;
            }, 5000);
        }
    },

    components: { ToastMessage, CreateListForm },
}

</script>