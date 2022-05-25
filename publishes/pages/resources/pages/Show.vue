<template>
    <BaseLayout v-bind="$attrs">
        <TabGroup :default-index="tabs.indexOf(tab)">
            <TabList>
                <Tab :href="`/admin/pages/${page.data.id}`">Content</Tab>
                <Tab :href="`/admin/pages/${page.data.id}/meta`">Meta</Tab>
                <Tab :href="`/admin/pages/${page.data.id}/settings`">
                    Settings
                </Tab>
            </TabList>
            <TabPanels>
                <TabPanel>
                    <Content>
                        <PanelContentBody
                            :form="contentForm"
                            :page="page.data"
                        />
                        <PanelContentSidebar />
                    </Content>
                    <!-- <template v-slot:sidebar>
                        
                    </template> -->
                </TabPanel>
                <TabPanel>
                    <PanelMetaBody
                        :form="metaForm"
                        :page="page"
                        :full-slug="fullSlug"
                    />
                </TabPanel>
                <TabPanel>
                    <PanelSettingsBody :page="page" :form="contentForm" />
                </TabPanel>
            </TabPanels>
        </TabGroup>
        <template v-slot:topbar-left>
            <span>{{ contentForm.name }}</span>
            <div class="ml-4 text-sm text-gray">
                <span v-html="fullSlug" /> <EditSlugModal :form="contentForm" />
            </div>
        </template>
    </BaseLayout>
</template>

<script setup lang="ts">
import { defineProps, PropType, computed, onBeforeUnmount } from 'vue';
import { useForm } from '@macramejs/macrame-vue3';
import {
    TabGroup,
    TabList,
    Tab,
    Content,
    ContentSidebar,
    ContentBody,
} from '@macramejs/admin-vue3';
import { TabPanels, TabPanel } from '@headlessui/vue';
import BaseLayout from './Index.vue';
import { saveQueue } from '@admin/modules/save-queue';
import { PageResource } from '@admin/types/resources';
import { PageContent, PageMeta } from '@admin/types/forms';
import PanelMetaBody from './components/PanelMetaBody.vue';
import PanelContentBody from './components/PanelContentBody.vue';
import PanelContentSidebar from './components/PanelContentSidebar.vue';
import EditSlugModal from './components/EditSlugModal.vue';
import PanelSettingsBody from './components/PanelSettingsBody.vue';

const tabs = ['content', 'meta', 'settings'];

const props = defineProps({
    page: {
        type: Object as PropType<PageResource>,
        required: true,
    },
    tab: {
        type: String,
        required: false,
        default: 'content',
    },
});

const contentFormQueueKey = `page.${props.page.data.id}.content`;
const contentForm = useForm<PageContent>({
    route: `/admin/pages/${props.page.data.id}`,
    method: 'put',
    data: {
        name: props.page.data.name,
        content: props.page.data.content || [],
        slug: props.page.data.slug,
        attributes: Array.isArray(props.page.data.attributes)
            ? {}
            : props.page.data.attributes,
    },
    onDirty: (form) =>
        saveQueue.add(contentFormQueueKey, async () => form.submit()),
    onClean: () => saveQueue.remove(contentFormQueueKey),
});

const metaFormQueueKey = `page.${props.page.data.id}.meta`;
const metaForm = useForm<PageMeta>({
    route: `/admin/pages/${props.page.data.id}/meta`,
    method: 'post',
    data: props.page.data.meta || {},
    onDirty: (form) => {
        saveQueue.add(metaFormQueueKey, async () => form.submit());
    },
    onClean: () => saveQueue.remove(metaFormQueueKey),
});

onBeforeUnmount(() => {
    if (contentForm.isDirty || metaForm.isDirty) {
        if (confirm('Do you want to save your unchanged changes?')) {
            saveQueue.save();
        }
    }
});

const fullSlug = computed(() => {
    let parts = props.page.data.full_slug.split('/');
    parts.pop();
    return `${parts.join(' > ')} > <strong>${contentForm.slug}</strong>`;
});
</script>
