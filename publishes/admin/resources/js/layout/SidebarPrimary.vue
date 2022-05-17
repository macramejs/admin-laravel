<template>
    <SidebarPrimary>
        <template v-slot:logo>
            <Logo class="pl-0.5" />
        </template>
        <template v-slot="{ expanded }">
            <SidebarSection
                :expanded="expanded"
                :expandable="true"
                title="Website"
            >
                <SidebarLink
                    v-for="link in sidebarLinks"
                    :title="link.title"
                    :hide-title="!expanded"
                    :href="link.href"
                >
                    <template #icon v-if="link.icon">{{ link.icon }}</template>
                </SidebarLink>
            </SidebarSection>
        </template>
    </SidebarPrimary>
</template>

<script lang="ts" setup>
import {
    SidebarSection,
    SidebarLink,
    SidebarPrimary,
} from '@macramejs/admin-vue3';
import { sidebarLinks } from '@admin/modules/sidebar-navigation';
import Logo from './Logo.vue';
</script>
