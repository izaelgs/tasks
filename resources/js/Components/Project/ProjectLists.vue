<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid mb-4">
        <div class="col-span-3 p-4 bg-gradient-to-r from-slate-200 to-slate-300 overflow-hidden shadow-sm rounded-lg">
            <template v-if="lists.length">
                <div
                    v-for="list in lists"
                    class="bg"
                >
                    {{ list.title }}
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import ApiService from '@/services/ApiService';

import CreateListForm from '@/Components/Project/CreateListForm.vue';

export default {
    props: {
        project_id : Number
    },
    async setup() {
        try {
            const request_lists = await ApiService.get('list');
            const lists         = request_lists.data;

            return {
                lists,
            };
        } catch (error) {

            if(error.response.status != 404)
                this.$store.commit('addMessage', error.response);

            const lists         = [];

            return {
                lists,
            };
        }
    },

    methods: {
        isoToLocaleString(date) {
            date = new Date(date + ' 00:00:00');

            return date.toLocaleDateString();
        }
    },

    components: { CreateListForm },
}

</script>