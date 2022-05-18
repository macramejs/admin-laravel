<template>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-400 text-gray-100">
        <button
            :class="
                mediaIndex.filters.types.value.includes('images')
                    ? 'bg-gray-100'
                    : ''
            "
            class="px-4 py-2 mb-1 rounded-[8px] transition-colors w-full text-left duration-300 hover:bg-gray-500 hover:bg-opacity-20"
            @click="mediaIndex.filters.types.toggle('images')"
        >
            Images
        </button>
        <button
            :class="
                mediaIndex.filters.types.value.includes('documents')
                    ? 'bg-gray-100'
                    : ''
            "
            class="px-4 py-2 mb-1 rounded-[8px] transition-colors w-full text-left duration-300 hover:bg-gray-500 hover:bg-opacity-20"
            @click="mediaIndex.filters.types.toggle('documents')"
        >
            Documents
        </button>
    </div>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-400 text-gray-100">
        <div class="flex items-center gap-3 px-5 pt-16 pb-6 -mx-2">
            <IconBookStack />
            <span class="inline-block text-xl"> Collections </span>
            <ButtonRound white sm @click="showForm = !showForm" class="ml-auto">
                <IconPlus class="w-4 h-4"></IconPlus>
            </ButtonRound>
        </div>
        <AddCollectionForm class="mb-4" v-if="showForm" />
    </div>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-400 text-gray-100">
        <Link
            v-for="c in collections"
            :key="c.id"
            :class="c.id == collection?.id ? 'bg-gray-50 bg-opacity-10' : ''"
            class="px-4 py-2 rounded-[8px] transition-colors text-left duration-300 hover:bg-gray-100 hover:bg-gray-50 hover:bg-opacity-20"
            :href="
                c.id == collection?.id ? `/admin/media` : `/admin/media/${c.id}`
            "
        >
            <div class="flex justify-between">
                {{ c.title }}
                <span class="text-gray-300"> {{ c.files_count }}</span>
            </div>
        </Link>
    </div>
</template>

<script lang="ts" setup>
import {
    Input,
    IconBookStack,
    ButtonRound,
    IconPlus,
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
