<template>
    <div class="p-10">
        <span class="inline-block pb-8 text-xl font-medium">
            Page Settings
        </span>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full md:col-span-9">
                <Card class="flex gap-5">
                    <FormField no-label class="w-2/3">
                        <Input label="Page Name" v-model="form.name" />
                    </FormField>
                    <FormField no-label class="w-1/3">
                        <Input
                            label="Page Slug"
                            v-model="form.slug"
                            @update:modelValue="
                                slug => (form.slug = slugify(slug))
                            "
                        />
                    </FormField>
                </Card>
                <Button
                    secondary
                    class="!bg-red-500 !text-white !border-none flex mt-4"
                    @click="deletePage(page.data)"
                >
                    <IconTrash class="w-4 h-4 mr-2" />
                    Delete Page
                </Button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { defineProps, PropType } from 'vue';
import { PageResource } from '@admin/types/resources';
import { PageContentForm } from '@admin/types/forms';
import { deletePage } from '@admin/modules/page';
import {
    Card,
    FormField,
    Input,
    Button,
    IconTrash,
} from '@macramejs/admin-vue3';
import { slugify } from '@admin/modules/helpers';

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
