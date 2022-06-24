<template>
    <div class="w-full ">
        <multiselect
            v-model="selected"
            :options="options"
            :searchable="true"
            class="w-full "
            label="name"
            track-by="user.name"
            @select="selectUser"
            @search-change="searchChange"
        >
        </multiselect>
    </div>
</template>

<script>
import Multiselect from '@suadelabs/vue3-multiselect';
import {Inertia} from '@inertiajs/inertia';

export default {
    components: {Multiselect},
    props: {
        users: Array,
    },
    data() {
        return {
            selected: null,
            options: this.users,
        };
    },
    methods: {
        selectUser(user) {
            Inertia.get(`users/${user.id}`);
        },

        searchChange(q) {
            Inertia.get(`/search`, {q}, {
                preserveState: true,
                preserveScroll: true,
                replace: true
            });
        }
    }
};
</script>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
