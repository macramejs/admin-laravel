<template>
    <div
        class="ml-2 p-2 px-2 bg-white cursor-pointer relative inline-flex items-center justify-center text-sm uppercase transition-all duration-300 focus:ring focus:outline-none rounded"
        @click="isOpen = true"
    >
        <svg
            class=""
            width="12"
            height="12"
            stroke-width="1.5"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M13.0207 5.82839L15.8491 2.99996L20.7988 7.94971L17.9704 10.7781M13.0207 5.82839L3.41405 15.435C3.22652 15.6225 3.12116 15.8769 3.12116 16.1421V20.6776H7.65669C7.92191 20.6776 8.17626 20.5723 8.3638 20.3847L17.9704 10.7781M13.0207 5.82839L17.9704 10.7781"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </div>
    <Modal lg v-model:open="isOpen" title="Edit Slug">
        <div class="space-y-3">
            <Input
                label="Slug"
                :modelValue="form.slug"
                @update:modelValue="(slug) => (form.slug = slugify(slug))"
                @keyup.enter="isOpen = false"
            />
        </div>
        <template #footer>
            <Button @click="isOpen = false">Ok</Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { ref, PropType } from 'vue';
import { Modal, Input, Select, Button } from '@macramejs/admin-vue3';
import { slugify } from '@admin/modules/helpers';
import { PageContentForm } from '@admin/types/forms';

const isOpen = ref<boolean>(false);

const props = defineProps({
    form: {
        type: Object as PropType<PageContentForm>,
        required: false,
    },
});
</script>
