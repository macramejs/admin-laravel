<template>
    <SidebarSecondary>
        <template v-slot:header>
            <div class="flex justify-between w-full">
                <span class="inline-block text-xl"> Settings </span>
            </div>
        </template>
        <template v-slot:default>
            <SidebarSection :expandable="false">
                <SidebarLink
                    title="Konto"
                    href="/admin/user/profile"
                    secondary
                />
                <SidebarLink title="Benutzer" href="/admin/user/" secondary />
            </SidebarSection>
        </template>
    </SidebarSecondary>
</template>

<script lang="ts" setup>
import {
    SidebarSecondary,
    SidebarSection,
    SidebarLink,
} from "@macramejs/admin-vue3";
</script>
