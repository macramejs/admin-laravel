<template>
    <slot name="button" :open="() => (isOpen = true)">
        <ContextMenuItem @click="isOpen = true">
            Add to collection
        </ContextMenuItem>
    </slot>
    <Modal lg v-model:open="isOpen" title="Add To Collection">
        <div class="space-y-3">
            <Select
                label="Collection"
                :options="collectionOptions"
                v-model="collection"
            />
        </div>
        <template v-slot:footer>
            <Button @click="addToCollection" :disabled="!collection">
                Add
            </Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { defineEmits, ref, PropType, watch, computed } from 'vue';
import {
    Modal,
    Input,
    Select,
    Button,
    ContextMenuItem,
} from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';
import { templateOptions } from './content/templates';
import { Page } from '@admin/types/resources';
import { Selection } from '../modules';
import { MediaCollection } from '@admin/types/resources';

const isOpen = ref<boolean>(false);

const collection = ref<MediaCollection>();

const props = defineProps({
    selection: {
        type: Object as PropType<Selection>,
        required: true,
    },
    collections: {
        type: Array as PropType<MediaCollection[]>,
        required: true,
    },
});

//

const collectionOptions = computed(() => {
    console.log({ col: props.collections });
    return props.collections.map((collection) => ({
        value: collection,
        label: collection.title,
    }));
});

const addToCollection = () => {
    if (!collection.value) return;

    props.selection.addToCollection(collection.value);

    isOpen.value = false;
};
</script>
