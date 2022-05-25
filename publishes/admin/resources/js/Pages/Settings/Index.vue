<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <SettingsSidebar />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
    </Admin>
</template>

<script setup lang="ts">
import { Admin } from "@admin/layout";
import { SettingsSidebar } from "@admin/modules/settings";
</script>
