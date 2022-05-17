<template>
    <slot name="button" :open="() => (isOpen = true)">
        <Button round dark @click="isOpen = true">
            <!-- TODO: change icon -->
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
    </slot>
    <Modal lg v-model:open="isOpen" title="New Page">
        <form @submit.prevent="submit">
            <div class="space-y-3">
                <Input label="Name" v-model="form.name" />
                <Input
                    label="Slug"
                    :modelValue="form.slug"
                    @update:modelValue="updateSlug"
                />
                <Select
                    label="Template"
                    :options="templateOptions"
                    v-model="form.template"
                />
            </div>
            <input type="submit" class="hidden" />
        </form>
        <template v-slot:footer>
            <Button @click="submit"> Save </Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { defineEmits, ref, PropType, watch } from 'vue';
import { Modal, Input, Select, Button } from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';
import { templateOptions } from './content/templates';
import { Page } from '@admin/types/resources';
import { slugify } from '@admin/modules/helpers';
import { Inertia } from '@inertiajs/inertia';

const isOpen = ref<boolean>(false);

const emit = defineEmits(['pageAdded', 'close']);

const props = defineProps({
    parent: {
        type: Object as PropType<Page>,
        required: false,
    },
});

const form = useForm({
    route: `/admin/pages`,
    data: {
        parent: props.parent?.id,
        name: '',
        template: '',
        slug: '',
    },
    method: 'post',
    onSuccess() {
        emit('pageAdded', this);
        isOpen.value = false;
        form.reset();
    },
});

const isSlugEdited = ref(false);

const submit = function () {
    form.submit();
};

const updateSlug = function (value) {
    form.slug = slugify(value);
    isSlugEdited.value = true;
};

watch(
    () => form.name,
    () => {
        if (!isSlugEdited.value) {
            form.slug = slugify(form.name);
        }
    },
    { immediate: true }
);
</script>
