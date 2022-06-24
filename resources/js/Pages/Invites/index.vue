<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import {Inertia} from '@inertiajs/inertia';
import JetDangerButton from '@/Jetstream/DangerButton.vue';


const rejectInvitation = (invite) => {
    Inertia.post(`/invites/${invite.id}/reject`);
};

const acceptInvitation = (invite) => {
    let url = `/invites/${invite.id}/accept`;
    console.log(url);
    Inertia.post(url);
};

defineProps({
    invites: Array,
});
</script>

<template>
    <Head title="invites"/>

    <div class="font-sans text-gray-900 antialiased">
        <div class="pt-4 bg-gray-100">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <JetAuthenticationCardLogo/>
                </div>


                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Users that have invited you to connect
                </h2>


                <div v-for="invite in invites"
                     class="w-full sm:max-w-2xl flex align-baseline justify-between mt-6 px-6 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                    <h2 class="font-semibold text-xl text-gray-800 -mb-10 pb-0">
                        {{ invite.inviter.name }}
                    </h2>

                    <div>
                        <JetButton
                            :href="`invites/${invites.id}/accept`"
                            class="mx-5 inline-flex text-white no-underline items-center px-4 py-2 bg-green-600 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue-200 active:text-gray-800 active:bg-green-800 disabled:opacity-25 transition"
                            @click="acceptInvitation(invite)">
                            Accept
                        </JetButton>
                        <JetDangerButton @click="rejectInvitation(invite)">Reject</JetDangerButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
