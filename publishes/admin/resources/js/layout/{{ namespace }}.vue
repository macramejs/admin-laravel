<template>
    <DefaultLayout>
        <template #sidebar-primary>
            <slot name="sidebar-primary">
                <SidebarPrimary />
            </slot>
        </template>
        <template v-slot:sidebar-secondary>
            <slot name="sidebar-secondary" />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
        <template v-slot:topbar-right>
            <slot name="topbar-right">
                <TopbarRight />
            </slot>
        </template>
        <template v-slot:topbar-secondary>
            <slot name="topbar-secondary" />
        </template>
        <slot />
    </DefaultLayout>
</template>

<script setup lang="ts">
import { DefaultLayout } from '@macramejs/admin-vue3';
import SidebarPrimary from './SidebarPrimary.vue';
import TopbarRight from './TopbarRight.vue';
</script>
