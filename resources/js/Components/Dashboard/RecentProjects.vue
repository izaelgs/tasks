<template>
    <div class="col-span-3 p-4 bg-gradient-to-r from-slate-200 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="text-base font-semibold leading-7">Projetos Recentes</h2>

        <template v-if="projects.length">
            <div
                v-for="project in projects"
                class="col-span-3 p-4 overflow-hidden shadow-sm hover:shadow sm:rounded-lg relative"
            >
                <h5 class="text-base font-semibold text-gray-900">
                    {{ project.title }}
                </h5>

                <p class="text-sm font-normal text-gray-500">
                    {{ project.description }}
                </p>

                <small class="text-xs font-normal text-gray-500 absolute left-4 bottom-1">
                    {{ (new Date(project.created_at)).toLocaleDateString() }}
                </small>

                <small class="text-xs font-normal text-gray-500 absolute right-2 bottom-1">
                    {{ isoToLocaleString(project.deadline) }}
                </small>
            </div>
        </template>
        <template v-else>
            <div class="flex h-5/6 flex-col justify-center items-center">
                <h5 class="text-base font-semibold text-gray-900">
                    Não há nada por aqui
                </h5>

                <p class="text-sm font-normal text-gray-500">
                    Você pode adicionar projetos pessoais no card acima
                </p>
            </div>
        </template>

        <ToastMessage v-if="toasMessage" :message="toasMessage"/>
    </div>
</template>

<script>
import ApiService from '@/services/ApiService';
import ToastMessage from '../ToastMessage.vue';

export default {
    data: () => {
        return {
            projects: [],

            toasMessage: ''
        };
    },

    methods: {
        async getProjects() {
            try {
                let projects = await ApiService.get('project');
                this.projects = projects.data;
            } catch (error) {
                // this.toasMessage = error.response;
            }
        },

        isoToLocaleString(date) {
            date = new Date(date + ' 00:00:00');

            return date.toLocaleDateString();
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
        this.getProjects();
    },

    components: { ToastMessage }
}

</script>