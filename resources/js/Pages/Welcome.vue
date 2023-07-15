<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative bg-gray-900 sm:flex sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >Dashboard</Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Entrar</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Cadastre-se</Link>
            </template>
        </div>

        <div class="w-screen h-screen">
            <div class="relative isolate overflow-hidden bg-gray-900 px-6 shadow-2xl sm:rounded-3xl sm:px-16 lg:flex items-center h-full lg:gap-x-20 lg:px-24">
                <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[128rem] w-[128rem] -translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] sm:left-full sm:-ml-80 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0" aria-hidden="true">
                    <circle cx="512" cy="512" r="512" fill="url(#759c1415-0410-454c-8f7c-9a820de03641)" fill-opacity="0.7" />
                    <defs>
                        <radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
                            <stop stop-color="#7775D6" />
                            <stop offset="1" stop-color="#E935C1" />
                        </radialGradient>
                    </defs>
                </svg>
                <div class="mx-auto text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Aumente sua produtividade.<br>Comece a usar nosso aplicativo hoje.</h2>

                    <p class="mt-6 text-lg leading-8 text-gray-300">Desperte sua produtividade. Simplifique a gestão de projetos e potencialize sua organização pessoal!</p>

                    <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
                        <a
                            href="#"
                            class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        >Comece sua jornada</a>
                        <a
                            href="#"
                            class="text-sm font-semibold leading-6 text-white"
                        >Saiba mais <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>