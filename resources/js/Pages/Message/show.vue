<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import {Inertia} from '@inertiajs/inertia';

defineProps({
    messages: {
        type: Object,
        default: []
    },
    auth: Object,
    chattingWithUser: Object
});

const deleteMessage = (message) => {
    Inertia.delete(`/messages/${message.id}`);
};
const sendMessage = (receiver, sender) => {
    form.sender_id = sender.id;
    form.receiver_id = receiver.id;
    form.post('/messages');
};

const likeMessage = (message) => {
    Inertia.post(`/messages/${message.id}/like`);
};

const unLikeMessage = (message) => {
    console.log(message);
    Inertia.delete(`/messages/${message.id}/like`);
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
                Chatting with: {{ chattingWithUser.name }}
            </h2>
        </template>

        <div class="flex flex-col-reverse justify-between w-full h-full bg-red-100">
            <div class="self-end w-full">
                <form class="w-full flex">
                    <input v-model="form.body" class="w-full" placeholder="write your message" type="text">
                    <JetButton @click="sendMessage(chattingWithUser, auth)">
                        send
                    </JetButton>
                </form>
            </div>


            <div class="self-start">
                <div v-for="message in messages">
                    <p>-----------</p>
                    <p>{{ message.sender.name + ':' + message.body }}</p>
                    <p>{{ message.created_at }}</p>
                    <JetButton class="mr-3" @click="likeMessage(message)">Like</JetButton>
                    <JetButton class="mr-3" @click="unLikeMessage(message)">Unlike</JetButton>
                    <JetDangerButton v-if="message.sender_id === auth.id" class="mr-3" @click="deleteMessage(message)">
                        Delete
                    </JetDangerButton>
                    <p>-----------</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
