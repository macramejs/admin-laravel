<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerAccordion preview />
        </template>
        <div class="pb-6 space-y-3">
            <Draggable
                tag="div"
                :list="model.items"
                handle=".drag-logo"
                item-key="_draggableKey"
                v-if="model"
            >
                <template #item="{ element, index }">
                    <Card class="mb-3" :key="index">
                        <Header class="mb-6">
                            <div class="flex items-center space-x-4">
                                <InteractionButton
                                    class="cursor-move drag-logo"
                                    gray
                                >
                                    <IconDraggable class="w-2.5 h-2.5" />
                                </InteractionButton>
                                <div class="text-lg font-semibold">
                                    {{ element.title || 'Accordion-Element' }}
                                </div>
                            </div>
                            <ContextMenu placement="left">
                                <template #button>
                                    <InteractionButton class="cursor-pointer">
                                        <IconMoreHorizontal class="w-4 h-4" />
                                    </InteractionButton>
                                </template>
                                <ContextMenuItem
                                    class="hover:bg-red-signal text-red-signal"
                                    @click="removeItem(index)"
                                >
                                    <template #icon>
                                        <IconTrash
                                            class="origin-left scale-75"
                                        />
                                    </template>
                                    <span>Löschen</span>
                                </ContextMenuItem>
                            </ContextMenu>
                        </Header>
                        <div class="col-span-6 space-y-4">
                            <Input v-model="element.title" label="Title" />
                            <Textarea v-model="element.text" label="Text" />
                        </div>
                    </Card>
                </template>
            </Draggable>
        </div>
        <div class="flex justify-center">
            <AddItem @click="addItem"> Neues Logo hinzufügen </AddItem>
        </div>
    </BaseSection>
</template>
<script setup lang="ts">
import {
    Card,
    Section as BaseSection,
    InteractionButton,
    IconDraggable,
    IconTrash,
    IconMoreHorizontal,
    Input,
    Textarea,
    Header,
    ContextMenu,
    ContextMenuItem,
} from '@macramejs/admin-vue3';
import { defineProps, watch, defineEmits, reactive } from 'vue';
import AddItem from './components/AddItem.vue';
import Draggable from 'vuedraggable';
import { v4 as uuid } from 'uuid';
import DrawerAccordion from '../drawers/DrawerAccordion.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            items: [],
        }),
    },
});

const model = reactive({
    items: props.modelValue.items.map(item => {
        return { ...item, _draggableKey: uuid() };
    }),
});

function addItem() {
    model.items.push({
        title: '',
        text: '',
        // _draggableKey: uuid(),
    });
}

function removeItem(index) {
    model.items.splice(index, 1);
}

watch(
    () => model,
    () => {
        let items = JSON.parse(JSON.stringify(model.items)).map(item => {
            delete item._draggableKey;

            return item;
        });

        emit('update:modelValue', {
            ...model,
            items,
        });
    },
    { deep: true }
);
</script>
