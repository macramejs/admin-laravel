<template>
    <div class="p-10">
        <span class="inline-block pb-8 text-xl font-medium">
            Meta Informationen
        </span>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full md:col-span-9">
                <Card class="flex flex-col gap-5">
                    <FormField no-label>
                        <Input
                            class="w-full"
                            label="Title"
                            v-model="form.title"
                        />
                    </FormField>
                    <FormField>
                        <FormFieldLabel>Beschreibung</FormFieldLabel>
                        <Textarea
                            placeholder="Description"
                            v-model="form.description"
                        />
                    </FormField>
                    <div class="mt-4 max-w-[600px]">
                        <span class="inline-block pb-4 text-lg">
                            Vorschau
                        </span>

                        <div class="text-base flex text-[#202124]">
                            <span class="inline-block">
                                {{ origin }}
                            </span>
                            <span class="inline-block" v-html="fullSlug" />
                        </div>
                        <div class="text-[20px] text-[#1a0dab]">
                            {{ form.title }}
                        </div>
                        <div class="text-base text-[#4d5156]">
                            {{
                                descriptionPreview ? descriptionPreview : '...'
                            }}
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Form } from '@macramejs/macrame-vue3';
import { defineProps, PropType, computed } from 'vue';
import { PageResource } from '@admin/types/resources';
import { PageMetaForm } from '@admin/types/forms';
import {
    TabPanel,
    DrawerSection,
    Card,
    FormField,
    FormFieldLabel,
    Drawer,
    Input,
    Textarea,
} from '@macramejs/admin-vue3';

const props = defineProps({
    page: {
        type: Object as PropType<PageResource>,
        required: true,
    },
    form: {
        type: Object as PropType<PageMetaForm>,
        required: true,
    },
    fullSlug: {
        type: String,
        required: true,
    },
});

const origin = window.location.origin;

const descriptionPreview = computed(() => {
    if (props.form.description?.length > 160) {
        let trimmed = props.form.description?.substr(0, 160).substr(0, 160);

        // re-trim if we are in the middle of a word
        trimmed = trimmed.substr(
            0,
            Math.min(trimmed.length, trimmed.lastIndexOf(' '))
        );

        return `${trimmed} \u2026`;
    }

    return props.form.description;
});
</script>
