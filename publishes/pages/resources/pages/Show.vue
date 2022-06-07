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
            <div class="ml-4 space-x-2 text-sm text-gray">
                <a :href="pageUrl" v-html="fullSlug" target="_blank" />
                <EditSlugModal :form="contentForm" />
            </div>
        </template>
        <template v-slot:topbar-right>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2">
                    <span class="text-xs uppercase">
                        <template v-if="contentForm.is_live">online</template>
                        <template
                            v-if="
                                !contentForm.is_live && !contentForm.publish_at
                            "
                            >offline</template
                        >
                        <template
                            v-if="
                                !contentForm.is_live && contentForm.publish_at
                            "
                            >geplant</template
                        >
                    </span>
                    <Toggle v-model="contentForm.is_live" />
                </div>
                <DatePicker
                    v-model="publish_at"
                    v-slot="{ togglePopover }"
                    class="relative"
                    is-dark
                    color="orange"
                    mode="dateTime"
                    is24hr
                    timezone=""
                    :min-date="new Date()"
                >
                    <div
                        class="relative flex items-center justify-center w-8 h-8 bg-gray-200 rounded cursor-pointer hover:bg-gray-300"
                        @click="togglePopover"
                    >
                        <div
                            class="absolute top-0 right-0 w-3 h-3 -mt-1 -mr-1 border-2 border-gray-100 rounded-full bg-orange"
                            v-if="contentForm.publish_at"
                        ></div>
                        <svg
                            class="w-4 h-4"
                            width="24"
                            height="24"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M15 4V2M15 4V6M15 4H10.5M3 10V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V10H3Z"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M3 10V6C3 4.89543 3.89543 4 5 4H7"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M7 2V6"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M21 10V6C21 4.89543 20.1046 4 19 4H18.5"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                </DatePicker>

                <TopbarRight />
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
    watch,
    ref,
} from 'vue';
import { useForm } from '@macramejs/macrame-vue3';
import { TabGroup, TabList, Tab, Content, Toggle } from '@macramejs/admin-vue3';

import { DatePicker } from 'v-calendar';
import 'v-calendar/dist/style.css';

import { TabPanels, TabPanel } from '@headlessui/vue';
import BaseLayout from './Index.vue';
import { saveQueue } from '@admin/modules/save-queue';
import { PageResource, LinkOption } from '@admin/types/resources';
import { PageContent, PageMeta } from '@admin/types/forms';
import TopbarRight from '@admin/layout/TopbarRight.vue';
import PanelMetaBody from './components/PanelMetaBody.vue';
import PanelContentBody from './components/PanelContentBody.vue';
import PanelContentSidebar from './components/PanelContentSidebar.vue';
import EditSlugModal from './components/EditSlugModal.vue';
import PanelSettingsBody from './components/PanelSettingsBody.vue';
import { linkOptions as GlobalLinkOptions } from '@admin/modules/links';

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
});

onBeforeMount(() => {
    GlobalLinkOptions.value = props.linkOptions;
});

const contentFormQueueKey = `page.${props.page.data.id}.content`;
const contentForm = useForm<PageContent>({
    route: `/admin/pages/${props.page.data.id}`,
    method: 'put',
    data: {
        name: props.page.data.name,
        content: props.page.data.content || [],
        slug: props.page.data.slug,
        is_live: props.page.data.is_live,
        publish_at: props.page.data.publish_at,
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

const publish_at = ref(
    props.page.data.publish_at
        ? new Date(props.page.data.publish_at)
        : new Date()
);

watch(
    () => publish_at.value,
    date => {
        contentForm.publish_at = date;
        contentForm.is_live = false;
    }
);

watch(
    () => contentForm,
    data => {
        if (data.is_live == true) {
            contentForm.publish_at = null;
        }
        if (data.publish_at != null) {
            contentForm.is_live = false;
        }
    },
    {
        deep: true,
    }
);

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
