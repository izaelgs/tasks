<template>
    <AppLayout title="Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Project
            </h2>
        </template>

        <div class="py-12">
            <Suspense>
                <template #default>
                    <ProjectDetails v-if="project_id" :project_id="project_id" />
                </template>
                <template #fallback>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid mb-4">
                        <div
                            class="col-span-3 p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg animate-pulse"
                        ></div>
                    </div>
                </template>
            </Suspense>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-4 md:grid-cols-3 grid-rows-3">
                <Suspense>
                    <template #default>
                        <ProjectLists v-if="project_id" :project_id="project_id" />
                    </template>
                    <template #fallback>
                        <div
                            class="col-span-2 text-white p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg animate-pulse"
                        ></div>
                    </template>
                </Suspense>

                <div class="sm:col-span-2 md:col-span-1 p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg">
                    Appointments
                </div>
            </div>
        </div>

        <ToastMessage />
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';

import ProjectDetails from '@/Components/Project/ProjectDetails.vue';
import ProjectLists from '@/Components/Project/ProjectLists.vue';
import ToastMessage from '@/Components/ToastMessage.vue';

export default {
    data: () => {
        return {
            project_id  : 0,
        };
    },

    created() {
        this.project_id = parseInt(this.route().params.id);
    },

    components: { AppLayout, ProjectDetails, ProjectLists, ToastMessage },
}

</script>