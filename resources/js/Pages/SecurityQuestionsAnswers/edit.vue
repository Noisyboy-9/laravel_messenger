<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

defineProps({
    answer: Object
});

const form = useForm({
    answer: ''
});

const update = (id) => {
    form.patch(`/security_questions_answers/${id}`);
};

</script>

<template>
    <Head title="Edit Security Question"/>

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo/>
        </template>

        <JetValidationErrors class="mb-4"/>

        <form @submit.prevent="update(answer.id)">
            <h3 class="text-lg font-medium text-gray-900 my-3">
                Edit Question
            </h3>
            <div>
                <JetLabel for="answer" value="Answer"/>
                <JetInput
                    id="answer"
                    v-model="form.answer"
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
