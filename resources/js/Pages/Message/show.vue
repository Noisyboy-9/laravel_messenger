<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';

defineProps({
    messages: {
        type: Array,
        default: []
    },
    auth: Object,
    user: Object
});

const sendMessage = (receiver, sender) => {
    form.sender_id = sender.id;
    form.receiver_id = receiver.id;
    form.post('/messages');
};

const form = useForm({
    body: '',
    sender_id: '',
    receiver_id: '',
});

</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ user.name }}
            </h2>
        </template>

        <div>
            <form @submit.prevent="sendMessage(user, auth)">
                <input v-model="form.body" placeholder="write your message" type="text">
                <JetButton @click="sendMessage(user, auth)">
                    send
                </JetButton>
            </form>
        </div>


        <div>
            <div v-for="message in messages">
                <p>{{ message.body }}</p>
            </div>
        </div>

    </AppLayout>
</template>
