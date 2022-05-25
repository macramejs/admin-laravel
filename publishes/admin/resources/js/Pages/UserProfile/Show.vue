<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <SettingsSidebar />
        </template>
        <template v-slot:topbar-left> Mein Konto </template>
        <div class="p-10">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-full md:col-span-9">
                    <Card class="flex gap-5">
                        <FormField no-label class="w-2/3">
                            <Input label="Name" v-model="form.name" />
                        </FormField>
                        <FormField no-label class="w-2/3">
                            <Input label="E-Mail" v-model="form.email" />
                        </FormField>
                    </Card>
                    <ChangePasswordModal :user="user" />
                </div>
            </div>
        </div>
    </Admin>
</template>

<script setup lang="ts">
import { Admin } from "@admin/layout";
import { Card, FormField, Input } from "@macramejs/admin-vue3";
import { useForm } from "@macramejs/macrame-vue3";
import { SettingsSidebar } from "@admin/modules/settings";
import ChangePasswordModal from "./components/ChangePasswordModal.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    data: {
        name: props.user.name,
        email: props.user.email,
    },
});
</script>
