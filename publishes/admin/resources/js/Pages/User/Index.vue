<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <SettingsSidebar />
        </template>
        <template v-slot:topbar-left> Alle Benutzer </template>
        <div class="m-10">
            <UserTable />
        </div>
    </Admin>
</template>

<script setup lang="ts">
import { Admin } from "@admin/layout";
import { SettingsSidebar } from "@admin/modules/settings";
import UserTable from "./components/UserTable.vue";
</script>
