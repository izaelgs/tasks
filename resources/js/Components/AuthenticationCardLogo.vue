<script setup>
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
</script>

<template>
    <Link :href="'/'">
        <Icon class="text-violet-500" icon="ic:outline-playlist-add-check" style="font-size: 12rem;"/>
    </Link>
</template>
