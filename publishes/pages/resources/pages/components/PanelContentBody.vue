<template>
    <div class="flex py-4">
        <div class="container">
            <component
                v-if="page.template in templates"
                :is="templates[page.template]"
                :form="form"
            />
            <Sections v-model="form.content" :sections="sections" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Form } from '@macramejs/macrame-vue3';
import { Sections } from '@macramejs/admin-vue3';
import { defineProps, PropType } from 'vue';
import { templates } from './content/templates';
import { sections } from './content/sections';
import { PageResource } from '@admin/types/resources';
import { PageContentForm } from '@admin/types/forms';

const props = defineProps({
    page: {
        type: Object as PropType<PageResource>,
        required: true,
    },
    form: {
        type: Object as PropType<PageContentForm>,
        required: true,
    },
});
</script>
