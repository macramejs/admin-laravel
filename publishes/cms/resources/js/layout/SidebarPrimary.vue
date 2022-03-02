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
                <SidebarLink title="Seiten" :hide-title="!expanded" href="#">
                    <template #icon>#</template>
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
import Logo from './Logo.vue';
</script>
