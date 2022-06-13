<template>
    <SidebarPrimary :locked="locked">
        <template v-slot:logo>
            <Logo />
        </template>
        <template v-slot="{ expanded }">
            <SidebarSection
                :expanded="expanded"
                :expandable="true"
                title="Website"
            >
                <SidebarLink
                    v-for="link in sidebarLinks"
                    :title="link.title || ' '"
                    :hide-title="!expanded"
                    :href="link.href"
                >
                    <template #icon v-if="link.icon">
                        <component
                            v-if="typeof link.icon === 'object'"
                            :is="link.icon"
                            class="w-4 h-4"
                        >
                        </component>
                        <template v-else>
                            {{ link.icon }}
                        </template>
                    </template>
                </SidebarLink>
            </SidebarSection>
            <SidebarSection
                :expanded="expanded"
                :expandable="true"
                class="mt-auto"
            >
                <SidebarLink
                    class=""
                    href="/admin/settings"
                    :hideTitle="!expanded"
                    :active="isActiveFor(['admin/settings', 'admin/user'])"
                >
                    <template #icon>
                        <IconSettings class="w-4 h-4" />
                    </template>
                    Settings
                </SidebarLink>
                <SidebarLink
                    method="post"
                    href="/admin/logout"
                    :hideTitle="!expanded"
                >
                    <template #icon>
                        <IconLogout class="w-4 h-4" />
                    </template>
                    Logout
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
    IconSettings,
    IconLogout,
} from '@macramejs/admin-vue3';
import { sidebarLinks } from '@admin/modules/sidebar-navigation';
import Logo from './Logo.vue';
import { computed } from 'vue';

const locked = computed(() => {
    if (localStorage.hasOwnProperty('sideBarLocked')) {
        return JSON.parse(localStorage.getItem('sideBarLocked'));
    }
    return false;
});

const isActiveFor = (items: any[]) => {
    return items.some(e => {
        return window.location.pathname.includes(e);
    });
};
</script>
