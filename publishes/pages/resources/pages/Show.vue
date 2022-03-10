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
                        <DrawerSection title="Text Komponenten">
                            <Cabinet>
                                <TextDrawer :draws="TextSection" />
                            </Cabinet>
                        </DrawerSection>
                        <DrawerSection title="Other">
                            <Cabinet>
                                <CardsDrawer :draws="CardsSection" />
                            </Cabinet>
                        </DrawerSection>
                    </template>
                    <div class="flex py-4">
                        <div class="container">
                            <component
                                v-if="form.template in templates"
                                :is="templates[form.template]"
                                :form="form"
                            />
                            <Sections
                                v-model="form.content"
                                :sections="sections"
                            />
                        </div>
                    </div>
                </TabPanel>
            </TabPanels>
        </TabGroup>
        <template v-slot:topbar-left>
            <span>{{ form.name }}</span>
            <div class="ml-4 text-sm text-gray">
                {{ form.full_slug }}
            </div>
        </template>
    </BaseLayout>
</template>

<script setup lang="ts">
import { defineProps, watch, PropType } from 'vue';
import { Admin } from '@admin/layout';
import Layout from './package/Layout.vue';
import { useForm } from '@macramejs/macrame-vue3';
import {
    Button,
    TabGroup,
    TabList,
    Tab,
    TabPanel,
    DrawerSection,
    Sections,
} from '@macramejs/admin-vue3';
import { TabPanels } from '@headlessui/vue';
import { TextSection, CardsSection, UploadSection } from './sections';
import { TextDrawer, CardsDrawer } from './drawers';
import { Cabinet } from '@macramejs/page-builder-vue3';
import BaseLayout from './Index.vue';
import { saveQueue } from '@admin/modules/save-queue';
import { ExampleTemplate } from './templates';
import { {{ model }}Resource } from '@{{ app }}/types';

const props = defineProps({
    page: {
        type: Object as PropType<{{ model }}Resource>,
        required: true,
    },
});

const form = useForm(`/{{ app }}/{{ route }}/${props.page.data.id}`, props.page.data, {
    method: 'post',
});

const sections = {
    text: TextSection,
    cards: CardsSection,
    // upload: UploadSection,
};

const templates = {
    ExampleTemplate,
};

watch(
    form,
    () => {
        const queueKey = `page.${props.page.data.id}.content`;

        if (form.isDirty) {
            saveQueue.add(queueKey, async () => form.submit());
        } else {
            saveQueue.remove(queueKey);
        }
    },
    { immediate: true, deep: true }
);
</script>
