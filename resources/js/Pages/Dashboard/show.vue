<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import {Inertia} from '@inertiajs/inertia';

defineProps({
    user: {
        type: Object,
        default: []
    },
    auth: {
        type: Object
    }
});

const inviteUser = (user) => {
    Inertia.post(`/users/${user.id}/invite`);
};

</script>
<template>
    <AppLayout :title="user.name">
        <template v-if="auth.id!==user.id" #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ user.name }}
            </h2>
        </template>

        <template v-if="auth.id===user.id" #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Saved Messages
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden sm:rounded-lg flex justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ user.name }}
                    </h2>


                    <div v-if="user.id !== auth.id">
                        <JetButton
                            class="mr-3 bg-green-600"
                            @click="inviteUser(user)"
                        >
                            Invite
                        </JetButton>


                        <JetButton
                            class="bg-red-500"
                            @click="blockUser(user)"
                        >
                            Block
                        </JetButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
