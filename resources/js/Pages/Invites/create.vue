<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

const form = useForm({
    answer: '',
    question_id: ''
});

const submit = () => {
    form.post(route('security_questions_answers.store'));
};
</script>

<template>
    <Head title="Answer Security Question"/>

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo/>
        </template>

        <JetValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <h3 class="text-lg font-medium text-gray-900 my-3">
                New Answer
            </h3>
            <div>
                <JetLabel for="question_id" value="question_id"/>
                <JetInput
                    id="question_id"
                    v-model="form.question_id"
                    autocomplete="question_id"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />
            </div>


            <div>
                <JetLabel for="answer" value="answer"/>
                <JetInput
                    id="answer"
                    v-model="form.answer"
                    autocomplete="answer"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />
            </div>
            <div class="flex items-center justify-start mt-4">

                <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="">
                    Submit
                </JetButton>
            </div>

        </form>
    </JetAuthenticationCard>
</template>
