<template>
    <Button round sm @click="isOpen = true">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="-4.5 -4.5 24 24"
            class="w-4 h-4 fill-white"
        >
            <path
                d="M8.9 6.9v-5a1 1 0 1 0-2 0v5h-5a1 1 0 1 0 0 2h5v5a1 1 0 1 0 2 0v-5h5a1 1 0 1 0 0-2h-5z"
            ></path>
        </svg>
    </Button>
    <Modal lg v-model:open="isOpen" title="New Page">
        <div class="space-y-3">
            <Input
                label="Slug"
                :modelValue="form.slug"
                @update:modelValue="(slug) => (form.slug = slugify(slug))"
            />
        </div>
        <template #footer>
            <Button @click="isOpen = false"> Ok </Button>
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
