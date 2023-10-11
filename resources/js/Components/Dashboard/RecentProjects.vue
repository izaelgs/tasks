<template>
    <div class="col-span-3 p-4 bg-gradient-to-r from-slate-200 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="text-base font-semibold leading-7">Projetos Recentes</h2>

        <template v-if="projects.length">
            <Link
                v-for="project in projects"
                :href="route('project', 1)"
                class="block p-4 overflow-hidden shadow-sm hover:shadow sm:rounded-lg relative"
            >
                <h5 class="text-base font-semibold text-gray-900">
                    {{ project.title}}
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
            </Link>
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
    </div>
</template>

<script>
import ApiService from '@/services/ApiService';
import { Link } from '@inertiajs/vue3';

export default {
    async setup() {
        let request_projects = await ApiService.get('project');
        const projects = request_projects.data;

        return {
            projects,
        };
    },

    methods: {
        isoToLocaleString(date) {
            date = new Date(date + ' 00:00:00');

            return date.toLocaleDateString();
        }
    },

    components: { Link }
}

</script>