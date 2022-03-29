<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <NavSidebar />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
        <NavBody :items="items.data" :type="type" />
    </Admin>
</template>

<script setup lang="ts">
import { PropType } from 'vue';
import { Admin } from '@{{ app }}/layout';
import NavSidebar from './components/NavSidebar.vue';
import NavBody from './components/NavBody.vue';
import { NavItemTreeCollectionResource } from '@{{ app }}/types';

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    items: {
        type: Object as PropType<NavItemTreeCollectionResource>,
        required: true,
    },
});
</script>
