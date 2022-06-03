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
                <a :href="pageUrl" v-html="fullSlug" target="_blank" />
                <EditSlugModal :form="contentForm" />
            </div>
        </template>
    </BaseLayout>
</template>

<script setup lang="ts">
import {
    defineProps,
    PropType,
    computed,
    onBeforeUnmount,
    onBeforeMount,
} from 'vue';
import { useForm } from '@macramejs/macrame-vue3';
import { TabGroup, TabList, Tab, Content } from '@macramejs/admin-vue3';
import { TabPanels, TabPanel } from '@headlessui/vue';
import BaseLayout from './Index.vue';
import { saveQueue } from '@admin/modules/save-queue';
import {
    PageResource,
    LinkOption,
    BlockCollectionResource,
} from '@admin/types/resources';
import { PageContent, PageMeta } from '@admin/types/forms';
import PanelMetaBody from './components/PanelMetaBody.vue';
import PanelContentBody from './components/PanelContentBody.vue';
import PanelContentSidebar from './components/PanelContentSidebar.vue';
import EditSlugModal from './components/EditSlugModal.vue';
import PanelSettingsBody from './components/PanelSettingsBody.vue';
import { linkOptions as GlobalLinkOptions } from '@admin/modules/links';
import { blocks as GlobalBlocks } from '@admin/modules/blocks';

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
    linkOptions: {
        required: true,
        type: Array as PropType<LinkOption[]>,
    },
    blocks: {
        required: true,
        type: Object as PropType<BlockCollectionResource>,
    },
});

onBeforeMount(() => {
    GlobalLinkOptions.value = props.linkOptions;
    GlobalBlocks.value = props.blocks;
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
    onDirty: form =>
        saveQueue.add(contentFormQueueKey, async () => form.submit()),
    onClean: () => saveQueue.remove(contentFormQueueKey),
});

const metaFormQueueKey = `page.${props.page.data.id}.meta`;
const metaForm = useForm<PageMeta>({
    route: `/admin/pages/${props.page.data.id}/meta`,
    method: 'post',
    data: props.page.data.meta || {},
    onDirty: form => {
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
    let parts = props.page.data.full_slug.split('/').filter(p => p);
    parts.pop();
    return `${parts.join(' > ')} > <strong>${contentForm.slug}</strong>`;
});

const pageUrl = computed(() => {
    let parts = props.page.data.full_slug.split('/').filter(p => p);

    return `${window.location.origin}/${parts.join('/')}`;
});
</script>
