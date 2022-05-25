<template>
    <Index :table="userIndex">
        <template v-slot:search>
            <div class="flex justify-between">
                <Search
                    class="w-full"
                    :table="userIndex"
                    placeholder="Benutzer durchsuchen"
                />
            </div>
        </template>
        <Table :table="userIndex">
            <template v-slot:thead>
                <UserTableHead :table="userIndex" />
            </template>
            <template v-slot:tbody>
                <UserTableBody :table="userIndex" />
            </template>
        </Table>
    </Index>
</template>

<script setup lang="ts">
import { Index, Table, Search, Toggle } from "@macramejs/admin-vue3";
import { userIndex } from "@admin/modules/user";
import UserTableBody from "./UserTableBody.vue";
import UserTableHead from "./UserTableHead.vue";

userIndex.loadItems();
</script>
