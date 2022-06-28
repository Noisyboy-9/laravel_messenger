<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import {Inertia} from '@inertiajs/inertia';

defineProps({
    messages: {
        type: Array,
        default: []
    },
    auth: {
        type: Object,
        default: {},
    },
    chattingWithUser: {
        type: Object,
        default: {}
    }
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


            <div class="self-start w-full py-6 px-4">
                <div v-for="message in messages" class="mb-6">
                    <div class="flex align-middle">
                        <img :src="message.sender.profile_photo_url"
                             alt="profile"
                             class="inline object-cover w-12 h-12 mr-2 rounded-full">
                        <p class="self-center">{{ message.body }}</p>
                    </div>
                    <p>{{ (new Date(message.created_at)).toLocaleString() }}</p>
                    <JetButton class="mr-3" @click="likeMessage(message)">Like</JetButton>
                    <JetButton class="mr-3" @click="unLikeMessage(message)">Unlike</JetButton>
                    <JetDangerButton v-if="message.sender_id === auth.id" class="mr-3"
                                     @click="deleteMessage(message)">
                        Delete
                    </JetDangerButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
