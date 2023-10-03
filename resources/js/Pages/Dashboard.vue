<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import CreateProjectForm from '@/Components/Dashboard/CreateProjectForm.vue';
import RecentProjects from '@/Components/Dashboard/RecentProjects.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-4 grid-cols-3 grid-rows-3">
                <CreateProjectForm />

                <div class="p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg">
                    Appointments
                </div>

                <Suspense>
                    <template #default>
                        <RecentProjects />
                    </template>

                    <template #fallback>
                        <div
                            class="col-span-3 p-4 bg-gradient-to-r from-slate-200 to-slate-300 overflow-hidden shadow-sm sm:rounded-lg animate-pulse"
                        >
                        </div>
                    </template>
                </Suspense>

                <div class="col-span-3 p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg">
                    Categorie
                </div>
                <div class="col-span-2 text-white p-4 bg-gradient-to-r from-violet-500 to-blue-500 overflow-hidden shadow-sm sm:rounded-lg">
                    Recent Projects
                </div>
                <div class="p-4 bg-gradient-to-r from-slate-300 to-slate-200 overflow-hidden shadow-sm sm:rounded-lg">
                    Teams
                </div>
            </div>
        </div>
    </AppLayout>
</template>
