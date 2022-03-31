<template>
    <BaseLayout v-bind="$attrs">
        <TabGroup>
            <TabList>
                <Tab> Content </Tab>
                <Tab> Meta </Tab>
                <Tab> Settings </Tab>
            </TabList>
            <TabPanels>
                <TabPanel has-sidebar sidebar-top-position="118">
                    <template v-slot:sidebar>
                        <PanelContentSidebar />
                    </template>
                    <PanelContentBody :form="contentForm" :page="page.data" />
                </TabPanel>
                <TabPanel>
                    <PanelMetaBody :form="metaForm" :page="page" />
                </TabPanel>
            </TabPanels>
        </TabGroup>
        <template v-slot:topbar-left>
            <span>{{ contentForm.name }}</span>
            <div class="ml-4 text-sm text-gray">
                {{ page.data.full_slug }}
            </div>
        </template>
    </BaseLayout>
</template>

<script setup lang="ts">
import { defineProps, PropType } from 'vue';
import Layout from './package/Layout.vue';
import { useForm } from '@macramejs/macrame-vue3';
import { TabGroup, TabList, Tab, TabPanel } from '@macramejs/admin-vue3';
import { TabPanels } from '@headlessui/vue';
import { TextSection, CardsSection, UploadSection } from './sections';
import { TextDrawer, CardsDrawer } from './drawers';
import BaseLayout from './Index.vue';
import { saveQueue } from '@admin/modules/save-queue';
import { {{ model }}Resource } from '@{{ app }}/types/resources';
import { {{ model }}Content, {{ model }}Meta } from '@{{ app }}/types/forms';
import PanelMetaBody from './components/PanelMetaBody.vue';
import PanelContentBody from './components/PanelContentBody.vue';
import PanelContentSidebar from './components/PanelContentSidebar.vue';

const props = defineProps({
    page: {
        type: Object as PropType<PageResource>,
        required: true,
    },
});

const contentFormQueueKey = `page.${props.page.data.id}.content`;
const contentForm = useForm<{{ model }}Content>({
    route: `/{{ app }}/{{ route }}/${props.page.data.id}`,
    method: 'post',
    data: {
        name: props.page.data.name,
        content: props.page.data.content || [],
        attributes: Array.isArray(props.page.data.attributes)
            ? {}
            : props.page.data.attributes,
    },
    onDirty: (form) =>
        saveQueue.add(contentFormQueueKey, async () => form.submit()),
    onClean: () => saveQueue.remove(contentFormQueueKey),
});

const metaFormQueueKey = `page.${props.page.data.id}.meta`;
const metaForm = useForm<{{ model }}Meta>({
    route: `/{{ app }}/{{ route }}/${props.page.data.id}/meta`,
    method: 'post',
    data: props.page.data.meta || {},
    onDirty: (form) =>
        saveQueue.add(metaFormQueueKey, async () => form.submit()),
    onClean: () => saveQueue.remove(metaFormQueueKey),
});
</script>
