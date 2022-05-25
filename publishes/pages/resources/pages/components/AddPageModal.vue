<template>
    <slot name="button" :open="() => (isOpen = true)">
        <ButtonRound white sm @click="isOpen = true">
            <IconPlus class="w-4 h-4" />
        </ButtonRound>
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
import {
    Modal,
    Input,
    Select,
    ButtonRound,
    Button,
    IconPlus,
} from '@macramejs/admin-vue3';
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
        template: 'default',
        slug: '',
    },
    method: 'post',
    onSuccess(response) {
        emit('pageAdded', this);
        isOpen.value = false;
        form.reset();

        // Visit the recently created page, to refresh the Page/Show component
        // when currently already on a page.
        Inertia.visit(`/admin/pages/${response.props.page.data.id}`, {
            only: ['page'],
        });
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
