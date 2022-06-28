<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import {Inertia} from '@inertiajs/inertia';
import AppLayout from '../../Layouts/AppLayout';

const blockUser = (user) => {
    Inertia.post(`/users/${user.id}/block`);
};


defineProps({
    connections: Array,
});
</script>

<template>
    <Head title="Connections"/>

    <AppLayout title="connecitons">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Connections
            </h2>
        </template>

        <div class="font-sans text-gray-900 antialiased">
            <div class="pt-4 bg-gray-100">
                <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                    <div>
                        <JetAuthenticationCardLogo/>
                    </div>


                    <h2 class="font-semibold mt-4 text-xl text-gray-800 leading-tight">
                        Your connections
                    </h2>


                    <div v-for="connection in connections"
                         class="w-full sm:max-w-2xl flex align-baseline justify-between p-6 bg-white shadow-md overflow-hidden sm:rounded-lg mb-2">
                        <h2 class="font-semibold text-xl text-gray-800">
                            {{ connection.connected.name }}
                        </h2>


                        <div>
                            <p class="ml-3 font-medium text-sm truncate">
                                {{ connection.created_at }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
