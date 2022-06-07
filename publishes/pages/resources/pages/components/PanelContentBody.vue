<template>
    <ContentBody>
        <component :is="getComponent()" :form="form">
            <div class="flex justify-end mb-4">
                <button
                    @click="hideSections = !hideSections"
                    class="flex space-x-2 hover:font-semibold"
                >
                    <template v-if="hideSections">
                        <span class="text-xs uppercase">show all</span>
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
                                d="M15 9L20 4M20 4V8M20 4H16"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M9 15L4 20M4 20V16M4 20H8"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </template>
                    <template v-if="!hideSections">
                        <span class="text-xs uppercase">collapse all</span>
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
                                d="M4 20L9 15M9 15V19M9 15H5"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M20 4L15 9M15 9V5M15 9H19"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </template>
                </button>
            </div>
            <Sections v-model="form.content" :sections="sections" />
        </component>
    </ContentBody>
</template>

<script lang="ts" setup>
import { Sections, ContentBody, hideSections } from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { templates } from './templates';
import { sections } from '@admin/modules/content';
import { Page } from '@admin/types/resources';
import { PageContentForm } from '@admin/types/forms';

const props = defineProps({
    page: {
        type: Object as PropType<Page>,
        required: true,
    },
    form: {
        type: Object as PropType<PageContentForm>,
        required: true,
    },
});

const getComponent = () => {
    return props.page.template in templates
        ? templates[props.page.template]
        : 'div';
};
</script>
