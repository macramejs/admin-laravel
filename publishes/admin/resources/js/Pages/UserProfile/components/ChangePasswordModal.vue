<template>
    <Button @click="isOpen = true" class="my-4"> Change Password </Button>
    <Modal lg v-model:open="isOpen" title="Change Password">
        <form @submit.prevent="submit" class="space-y-4">
            <Input
                label="Altes Passwort"
                type="password"
                v-model="form.old_password"
                :errors="form.errors?.old_password"
            />
            <Input
                label="Neues Passwort"
                type="password"
                v-model="form.password"
                :errors="form.errors?.password"
            />
            <Input
                label="Neues Passwort bestätigen"
                type="password"
                v-model="form.password_confirmation"
            />
        </form>
        <template #footer>
            <Button @click="submit">Speichern</Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { ref, PropType } from "vue";
import { Modal, Input, Button } from "@macramejs/admin-vue3";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});
const isOpen = ref<boolean>(false);

const form = useForm({
    old_password: null,
    password: null,
    password_confirmation: null,
});

const submit = () => {
    form.post("/admin/settings/user/profile/password", {
        onSuccess: () => {
            isOpen.value = false;
            form.reset();
        },
    });
};
</script>
