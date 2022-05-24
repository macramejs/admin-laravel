<template>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-700 text-gray-100">
        <div class="flex items-center gap-3 px-5 pt-16 pb-6 -mx-2">
            <IconBookStack />
            <span class="inline-block text-xl"> Collections </span>
            <Button
                secondary
                outline
                sm
                square
                @click="showForm = !showForm"
                class="ml-auto !border-white"
            >
                <IconPlus class="w-4 h-4 text-white"></IconPlus>
            </Button>
        </div>
        <AddCollectionForm class="mb-4" v-if="showForm" />
    </div>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-700 text-gray-100">
        <SidebarLink
            v-for="c in collections"
            :key="c.id"
            secondary
            :active="c.id == collection?.id"
            class="pr-4"
            :href="
                c.id == collection?.id ? `/admin/media` : `/admin/media/${c.id}`
            "
        >
            <div class="flex justify-between">
                {{ c.title }}
                <span class="text-gray-300"> {{ c.files_count }}</span>
            </div>
        </SidebarLink>
    </div>
</template>

<script lang="ts" setup>
import {
    Input,
    IconBookStack,
    Button,
    IconPlus,
    SidebarLink,
} from '@macramejs/admin-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import { RadioGroup, RadioGroupOption } from '@headlessui/vue';
import { PropType, ref, computed } from 'vue';
import { MediaCollection } from '@admin/types';
import AddCollectionForm from './AddCollectionForm.vue';
import { mediaIndex } from '@admin/modules/media';

const props = defineProps({
    collections: {
        type: Array as PropType<MediaCollection[]>,
        required: true,
    },
    collection: {
        type: Object as PropType<MediaCollection>,
        required: false,
    },
});

const showForm = ref(false);
</script>
