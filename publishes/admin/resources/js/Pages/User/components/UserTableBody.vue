<template>
    <Tr v-for="(user, trKey) in table.items" :key="`th-${trKey}`">
        <Td slim>
            <strong>{{ user.id }}</strong>
        </Td>
        <Td slim>
            {{ user.name }}
        </Td>
        <Td slim>
            <span
                class="inline-flex px-4 py-1 text-sm rounded-full bg-orange"
                :class="{
                    'bg-orange text-white': user.is_admin,
                    'bg-gray-300': !user.is_admin,
                }"
            >
                {{ user.is_admin ? "Admin" : "User" }}
            </span>
        </Td>
        <Td slim>
            <ContextMenu>
                <template v-slot:button>
                    <button class="p-1">
                        <IconMoreHorizontal
                            class="w-4 h-4 text-black transform rotate-90"
                        />
                    </button>
                </template>
                <ContextMenuItem
                    class="hover:bg-red-signal text-red-signal"
                    @click="deleteUser(user)"
                >
                    <template #icon>
                        <IconTrash class="origin-left scale-75" />
                    </template>
                    <span>Delete</span>
                </ContextMenuItem>
            </ContextMenu>
        </Td>
    </Tr>
</template>

<script setup lang="ts">
import { PropType } from "vue";
import { Index } from "@macramejs/macrame-vue3";
import {
    Tr,
    Td,
    ContextMenu,
    ContextMenuItem,
    IconMoreHorizontal,
} from "@macramejs/admin-vue3";
import { User } from "@admin/types/resources";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    table: Object as PropType<Index<User>>,
});

const deleteUser = (user: User) => {
    if (confirm("Are you sure?")) {
        Inertia.delete(`/admin/user/${user.id}`, {
            onSuccess() {
                props.table.reload();
            },
        });
    }
};
</script>
