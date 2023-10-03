<template>
    <AppLayout title="Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-4 grid-cols-3 grid-rows-3">
                <Suspense>
                    <template #default>
                        <ProjectDetails />
                    </template>
                    <template #fallback>
                        <div
                            class="col-span-3 p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg animate-pulse"
                        ></div>
                    </template>
                </Suspense>

                <Suspense>
                    <template #default>
                        <ProjectLists />
                    </template>
                    <template #fallback>
                        <div
                            class="col-span-2 text-white p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg animate-pulse"
                        ></div>
                    </template>
                </Suspense>
                <div class="p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg">
                    Appointments
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';

import ProjectDetails from '@/Components/Project/ProjectDetails.vue';
import ProjectLists from '@/Components/Project/ProjectLists.vue';

export default {
    watch: {
        toasMessage() {
            setTimeout(() => {
                this.toasMessage = null;
            }, 5000);
        }
    },

    components: { AppLayout, ProjectDetails, ProjectLists },
}

</script>