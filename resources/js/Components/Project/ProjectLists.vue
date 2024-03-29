<template>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 grid">
        <template v-if="lists.length">
            <div
                v-for="list in lists"
                :style="'background: ' + list.color_hex"
                class="
                    col-span-3
                    p-4
                    bg-gradient-to-r
                    from-slate-200
                    to-slate-300
                    overflow-hidden
                    shadow-sm
                    rounded-lg
                    text-white
                    mb-4
                    relative"
            >
                <Icon
                    class="p-2 cursor-pointer absolute end-0 top-2"
                    :icon="list.icon"
                    style="font-size: 2.2rem;"
                />

                <div
                    @click="collapseList(list)"
                    class="w-full"
                >
                    {{ list.title }}
                </div>

                <!-- Items -->
                <div
                    class="transition-all duration-50 transition-[height] ease-out flex flex-wrap h-100"
                    :class="list.show ? 'col-span-full h-auto opacity-100 my-2' : 'h-0 opacity-0 overflow-hidden easy-in-out'"
                >
                    <template v-if="list.items.length">
                        <div
                            v-for="item in list.items"
                            class="block w-full my-2 p-4 overflow-hidden shadow-sm hover:shadow sm:rounded-lg relative"
                        >
                            <h5 class="text-base font-semibold text-slate-50">
                                {{ item.title}} <small class="text-xs font-light text-slate-50">R$ {{ item.value}}</small>
                            </h5>

                            <p class="text-sm font-normal text-slate-250">
                                {{ item.description }}
                            </p>

                            <small class="text-xs font-normal text-slate-300 absolute left-4 bottom-1">
                                {{ (new Date(item.created_at)).toLocaleDateString() }}
                            </small>

                            <small class="text-xs font-normal text-slate-300 absolute right-2 bottom-1">
                                {{ isoToLocaleString(item.deadline) }}
                            </small>
                        </div>
                    </template>
                    <template v-else>
                        <div class="w-full text-center">
                            Nenhum item cadastrado
                        </div>
                    </template>

                    <CreateListItemForm
                        :project_list_id="list.id"
                        @add_item="addItem"
                    />
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import ApiService from '@/services/ApiService';

import CreateListForm from '@/Components/Project/CreateListForm.vue';
import { Icon } from '@iconify/vue';
import { ref } from 'vue';
import CreateListItemForm from './CreateListItemForm.vue';

export default {
    props: {
        project_id : Number
    },
    async setup(props) {
        try {
            const request_lists = await ApiService.get(`project/${props.project_id}/lists`);
            const lists         = ref(request_lists.data);

            return {
                lists,
            };
        } catch (error) {

            if(!error.response)
                throw error;

            if(error.response.status != 404)
                this.$store.commit('addMessage', error.response);

            const lists = [];

            return {
                lists,
            };
        }
    },

    methods: {
        collapseList(list) {
            let index = this.lists.indexOf(list);

            list.show = list.show ? false : true;
            this.lists[index].show = list.show;
        },

        isoToLocaleString(date) {
            date = new Date(date + ' 00:00:00');

            return date.toLocaleDateString();
        },

        addItem(item) {
            let list = this.lists.find(list => list.id == item.project_list_id);
            let index = this.lists.indexOf(list);

            this.lists[index].items.push(item);
        }
    },

    components: { CreateListForm, Icon, CreateListItemForm },
}

</script>