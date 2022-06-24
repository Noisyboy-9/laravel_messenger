<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import {Inertia} from '@inertiajs/inertia';

const deleteAnswer = (id) => {
    console.log(id);
    Inertia.delete(route('security_questions_answers.destroy', id));
};
defineProps({
    answers: Array,
});
</script>

<template>
    <Head title="Security Questions Answer"/>

    <div class="font-sans text-gray-900 antialiased">
        <div class="pt-4 bg-gray-100">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <JetAuthenticationCardLogo/>
                </div>


                <div v-for="answer in answers"
                     class="w-full sm:max-w-2xl  mt-6 px-6 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                    <h2 class="font-semibold text-xl text-gray-800 mb-2 pb-0">
                        {{ answer.question.title }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ answer.answer }}
                    </p>

                    <div>
                        <Link
                            :href="'/security_questions_answers/' + answer.id + '/edit'"
                            class="mx-5 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                            Update
                        </Link>
                        <JetDangerButton @click="deleteAnswer(answer.id)">Delete</JetDangerButton>
                    </div>
                </div>

                <Link
                    class="inline-flex items-center px-4 bg-green-500 mt-3 text-white py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                    href="/security_questions_answers/create">
                    Add
                </Link>
            </div>
        </div>
    </div>
</template>
