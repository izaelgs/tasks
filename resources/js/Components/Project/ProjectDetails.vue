<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid mb-4">
        <div class="col-span-3 p-4 bg-gradient-to-r from-slate-200 to-slate-300 overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900">{{ project.title }}</h3>
            <p class="text-sm font-normal text-gray-500">{{ project.description }}</p>

            <div class="flex flex-wrap">
                <span
                    class="ms-0 m-1 bg-slate-100 text-slate-100 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-violet-600"
                >Prazo: {{ isoToLocaleString(project.deadline) }}</span>

                <span
                    class="ms-0 m-1 bg-slate-100 text-slate-100 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-violet-600"
                >Prioridade: {{ project.priority }}</span>

                <span
                    class="ms-0 m-1 bg-slate-100 text-slate-100 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-violet-600"
                >Time: {{ project.team ? project.team : 'nenhum' }}</span>

                <span
                    class="ms-0 m-1 bg-slate-100 text-slate-100 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-violet-600"
                >Status: {{ project.status ? 'Ativo' : 'Inativo' }}</span>
            </div>

            <small class="text-xs font-normal text-gray-500">Criado em {{ (new Date(project.created_at)).toLocaleDateString() }}</small>
            <small v-if="project.updated_at" class="text-xs font-normal text-gray-500"> e Atualizado em {{ (new Date(project.updated_at)).toLocaleDateString() }}</small>
        </div>
    </div>

    <ToastMessage v-if="toastMessage" :message="toastMessage"/>
</template>

<script>
import ToastMessage from '@/Components/ToastMessage.vue';
import ApiService from '@/services/ApiService';

export default {
    props:["project_id"],

    async setup(props) {
        try {
            const toastMessage = '';

            const request_project   = await ApiService.get('project/' + props.project_id);
            const project           = request_project.data;

            return {
                project,
                toastMessage
            };
        } catch (error) {
            const toastMessage  = error.response;
            const project       = {};

            // throw error;

            return {
                project,
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

    components: { ToastMessage },
}

</script>