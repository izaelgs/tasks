<template>
    <div
        class="col-span-2 text-white p-4 bg-gradient-to-r from-violet-500 to-blue-500 overflow-hidden shadow-sm sm:rounded-lg"
    >
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-slate-200">Adicionar Projeto</h2>
            <p class="mt-1 text-sm leading-6 text-slate-300">Desbrave o mundo, crie idéias, pinte o quadro da vida com a sua cor.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <!-- Título -->
                <div class="col-span-full">
                    <label for="title" class="block text-sm font-medium leading-6 text-slate-200">Título</label>

                    <div class="mt-2">
                        <input
                            type="text"
                            name="title"
                            id="title"
                            autocomplete="title"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Descrição -->
                <div class="col-span-full">
                    <div class="relative">
                        <textarea
                            type="text"
                            name="title"
                            id="title"
                            autocomplete="title"
                            rows="4"
                            class="peer block w-full rounded-md border-0 pt-4 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder=" "
                        ></textarea>
                        <!-- <input class="block px-2.5 pb-2.5  w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " /> -->
                        <label
                            for="title"
                            class="absolute text-sm font-medium text-slate-200 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] left-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2"
                        >Descrição</label>
                    </div>
                </div>

                <!-- Categoria -->
                <div class="sm:col-span-2">
                    <label for="country" class="block text-sm font-medium leading-6 text-slate-200">Categoria</label>

                    <div class="mt-2">
                        <select
                            id="country"
                            name="country"
                            autocomplete="country-name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                        >
                            <option>United States</option>
                            <option>Canada</option>
                            <option>Mexico</option>
                        </select>
                    </div>
                </div>

                <!-- Prioridade -->
                <div class="sm:col-span-1">
                    <label for="first-name" class="block text-sm font-medium leading-6 text-slate-200">Prioridade</label>

                    <div class="mt-2">
                        <input
                            type="text"
                            name="first-name"
                            id="first-name"
                            autocomplete="given-name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>

                <!-- Prazo -->
                <div class="sm:col-span-1">
                    <label for="city" class="block text-sm font-medium leading-6 text-slate-200">Prazo</label>

                    <div class="mt-2">
                        <input
                            type="text"
                            name="city"
                            id="city"
                            autocomplete="address-level2"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

}

</script>