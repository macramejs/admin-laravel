<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerImageCarousel preview />
        </template>
        <div class="pb-6">
            <Draggable
                tag="div"
                class="grid grid-cols-2 gap-5"
                :list="model.items"
                handle=".drag-logo"
                item-key="_draggableKey"
                v-if="model"
            >
                <template #item="{ element, index }">
                    <Card :key="index">
                        <Header class="mb-6">
                            <div class="flex items-center space-x-4">
                                <InteractionButton
                                    class="cursor-move drag-logo"
                                    gray
                                >
                                    <IconDraggable class="w-2.5 h-2.5" />
                                </InteractionButton>
                                <div class="text-lg font-semibold">
                                    {{ element.name || 'Carousel-Element' }}
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
                        <div class="grid grid-cols-12 gap-5">
                            <div class="col-span-6">
                                <SelectImage v-model="element.image" />
                            </div>
                            <div class="col-span-6 space-y-4">
                                <Input v-model="element.title" label="Titel" />
                                <Input v-model="element.text" label="Text" />
                            </div>
                        </div>
                    </Card>
                </template>
            </Draggable>
        </div>
        <div class="flex justify-center">
            <AddItem @click="addItem"> Bild hinzufügen </AddItem>
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
    Header,
    ContextMenu,
    ContextMenuItem,
} from '@macramejs/admin-vue3';
import { watch, reactive } from 'vue';
import AddItem from './components/AddItem.vue';
import Draggable from 'vuedraggable';
import SelectImage from './components/SelectImage.vue';
import { v4 as uuid } from 'uuid';
import DrawerImageCarousel from '../drawers/DrawerImageCarousel.vue';

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
        _draggableKey: uuid(),
        image: {
            id: null,
            title: '',
            alt: '',
        },
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
