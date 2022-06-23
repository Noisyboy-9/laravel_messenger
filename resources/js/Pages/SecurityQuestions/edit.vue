<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

defineProps({
    question: Object
});

const form = useForm({
    title: ''
});

const submit = (id) => {
    form.patch(`/security_questions/${id}`);
};

</script>

<template>
    <Head title="Edit Security Question"/>

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo/>
        </template>

        <JetValidationErrors class="mb-4"/>

        <form @submit.prevent="submit(question.id)">
            <h3 class="text-lg font-medium text-gray-900 my-3">
                Edit Question
            </h3>
            <div>
                <JetLabel for="title" value="Title"/>
                <JetInput
                    id="title"
                    v-model="form.title"
                    autofocus
                    class="mt-1 block w-full"
                    type="text"

                />
            </div>

            <div class="flex items-center justify-start mt-4">
                <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
                </JetButton>
            </div>

        </form>
    </JetAuthenticationCard>
</template>
