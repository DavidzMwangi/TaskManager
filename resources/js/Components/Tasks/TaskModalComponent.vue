<script setup lang="ts">

import {ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Shared/InputLabel.vue";
import InputError from "@/Shared/InputError.vue";
import type {Task} from "@/Types/types";

const emit = defineEmits(['close']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    task: {
        type: [Object as () => Task, null],
        default: null,
    },
});
const showModal = ref(props.show);

// Watch for changes in the `show` prop to update the modal state
watch(() => props.show, (newVal) => {
    showModal.value = newVal;
});
// Close the modal and emit the custom `close` event
const closeModal = () => {
    showModal.value = false;
    emit('close');
};
const form = useForm({
    title: '',
    description: '',
});
const submit = () => {
    if (props.task) {
        form.put(route('tasks.update', props.task.id), {
            onSuccess: () => {
                form.reset()
                closeModal()
            },
        });
    } else {
        form.post(route('tasks.store'), {
            onSuccess: () => {
                form.reset()
                closeModal()
            },
        });
    }
};
watch(() => props.task, (newVal) => {
    if (newVal) {
        form.title = newVal.title
        form.description = newVal.description
    } else {
        form.reset()
    }
});
</script>

<template>
    <DialogModal
        :show="showModal"
        :max-width="'2xl'"
        :closeable="true"
        @close="closeModal"
    >
        <template #title>
            {{ task ? 'Edit' : 'New' }} Task Form
        </template>

        <template #content>
            <form @submit.prevent="submit" :disabled="form.processing">
                <div>
                    <InputLabel for="name" value="Name"/>
                    <TextInput
                        id="name"
                        v-model="form.title"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.title"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="Description" value="Description"/>
                    <TextInput
                        id="description"
                        v-model="form.description"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autocomplete="description"
                    />
                    <InputError class="mt-2" :message="form.errors.description"/>
                </div>

                <div class="flex justify-between mt-4">
                    <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>
                </div>
            </form>
        </template>
        <template #footer>


        </template>
    </DialogModal>
</template>

<style scoped>

</style>
