<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import {Inertia} from '@inertiajs/inertia';
import AppLayout from '../../Layouts/AppLayout';


const rejectInvitation = (invite) => {
    Inertia.post(`/invites/${invite.id}/reject`);
};

const acceptInvitation = (invite) => {
    let url = `/invites/${invite.id}/accept`;
    console.log(url);
    Inertia.post(url);
};

defineProps({
    inviteds: Array,
});
</script>

<template>
    <Head title="Inviteds"/>

    <AppLayout title="inviteds">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inviteds
            </h2>
        </template>

        <div class="font-sans text-gray-900 antialiased">
            <div class="pt-4 bg-gray-100">
                <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                    <div>
                        <JetAuthenticationCardLogo/>
                    </div>


                    <h2 class="font-semibold mt-4 text-xl text-gray-800 leading-tight">
                        Users that you have invited to connect
                    </h2>


                    <div v-for="invited in inviteds"
                         class="w-full sm:max-w-2xl flex align-baseline justify-between p-6 bg-white shadow-md overflow-hidden sm:rounded-lg mb-2">
                        <h2 class="font-semibold text-xl text-gray-800">
                            {{ invited.invited.name }}
                        </h2>

                        <div>
                            <p class="ml-3 font-medium text-sm truncate">
                                {{ invited.created_at }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
