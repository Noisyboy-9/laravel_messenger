<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import {Inertia} from '@inertiajs/inertia';

defineProps({
    viewingUser: {
        type: Object,
        default: []
    },
    auth: {
        type: Object,
        default: [],
    },
    hasConnectionWithViewingUser: {
        type: Boolean,
        default: false,
    },
    hasBlockedViewingUser: {
        type: Boolean,
        default: false,
    },
    hasInvitedViewingUser: {
        type: Boolean,
        default: false,
    }
});

const goToMessagesPage = (user) => {
    Inertia.get(`/users/${user.id}/messages`);
};

const unBlockUser = (user) => {
    Inertia.post(`/users/${user.id}/unblock`);
};

const blockUser = (user) => {
    Inertia.post(`/users/${user.id}/block`);
};

const inviteUser = (user) => {
    Inertia.post(`/users/${user.id}/invite`);
};

const cancelInvite = (user) => {
    Inertia.delete(`/users/${user.id}/invite`);
};

</script>
<template>
    <AppLayout :title="viewingUser.name">
        <template v-if="auth.id!==viewingUser.id" #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ viewingUser.name }}
            </h2>
        </template>

        <template v-if="auth.id===viewingUser.id" #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Saved Messages
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden sm:rounded-lg flex justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ viewingUser.name }}
                    </h2>


                    <div>
                        <JetButton
                            v-if="(auth.id !== viewingUser.id) && !hasInvitedViewingUser && !hasConnectionWithViewingUser && !hasBlockedViewingUser"
                            class="mr-3 bg-green-600"
                            @click="inviteUser(viewingUser)"
                        >
                            Invite
                        </JetButton>

                        <JetButton
                            v-if="(viewingUser.id !== auth.id) && hasInvitedViewingUser && !hasConnectionWithViewingUser"
                            class="mr-3 bg-green-600"
                            @click="cancelInvite(viewingUser)"
                        >
                            Cancel Invite
                        </JetButton>


                        <JetButton
                            v-if="(viewingUser.id !== auth.id) && !hasBlockedViewingUser"
                            class="bg-red-500 mr-3"
                            @click="blockUser(viewingUser)"
                        >
                            Block
                        </JetButton>

                        <JetButton v-if="(viewingUser.id !== auth.id) && hasBlockedViewingUser"
                                   class="bg-red-500 mr-3"
                                   @click="unBlockUser(viewingUser)"
                        >
                            unblock
                        </JetButton>

                        <JetButton
                            v-if="hasConnectionWithViewingUser"
                            class="bg-indigo-500"
                            @click="goToMessagesPage(viewingUser)"
                        >
                            Start Chatting
                        </JetButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
