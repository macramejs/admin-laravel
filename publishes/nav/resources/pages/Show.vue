<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <NavigationsSidebar />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
        <NavigationsBody :items="items.data" :type="type" />
    </Admin>
</template>

<script setup lang="ts">
import { PropType } from 'vue';
import { Admin } from '@{{ app }}/layout';
import NavigationsSidebar from './components/NavigationsSidebar.vue';
import NavigationsBody from './components/NavigationsBody.vue';
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
