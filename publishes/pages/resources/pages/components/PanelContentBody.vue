<template>
    <ContentBody>
        <div class="container">
            <component :is="getComponent()" :form="form">
                <Sections v-model="form.content" :sections="sections" />
            </component>
        </div>
    </ContentBody>
</template>

<script lang="ts" setup>
import { Sections, ContentBody } from '@macramejs/admin-vue3';
import { defineProps, PropType } from 'vue';
import { templates } from './content/templates';
import { sections } from './content/sections';
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
