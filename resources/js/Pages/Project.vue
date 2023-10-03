<template>
    <AppLayout title="Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-4 grid-cols-3 grid-rows-3">
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

        <ToastMessage v-if="toasMessage" :message="toasMessage"/>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import ToastMessage from '@/Components/ToastMessage.vue';

export default {
    data: () => {
        return {
            project: null,

            toasMessage: ''
        };
    },

    methods: {
        async getProject() {
            try {
                let project = await ApiService.get('project/1');
                this.project = project.data;
            } catch (error) {
                this.toasMessage = error.response;
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
        this.getProject();
    },

    components: { AppLayout, ToastMessage },
}

</script>