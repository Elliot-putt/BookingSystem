<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
    <TitleLayout title="Bookings"
                 description="This page allows you to View your all your Bookings. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="row justify-content-center" v-if="bookings">
        <div class="d-flex mx-2">
            <label class="me-2 my-auto">Reference Filter:</label>
            <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
        </div>
        <div v-if="bookings.active[0]" class="col-7 mx-auto">
            <p class="fs-5">
                Active bookings </p>
            <hr>
        </div>
        <BookingCard :bookings="bookings.active"/>
        <div v-if="bookings.expired[0]" class="col-7 mx-auto">
            <p class="fs-5 text-secondary">
                Finished bookings </p>
            <hr>
        </div>
        <BookingCard :bookings="bookings.expired"/>
        <div class="text-center">
            <Pagination :links="booking.links"/>
        </div>
    </div>
</template>

<script setup>
import Pagination from "../../Shared/Pagination"
import {usePage} from '@inertiajs/inertia-vue3'
import TitleLayout from "../../Shared/TitleLayout";
import {computed, ref, watch} from 'vue'
import BookingCard from "../../Components/BookingCard";
import {Inertia} from "@inertiajs/inertia";
import throttle from "lodash/throttle"


let props = defineProps({
    booking: Object,
    filters: Object,
});
const bookings = computed(() => {
    return {
        expired: usePage().props.value.booking.data.filter(booking => booking.status === 1),
        active: usePage().props.value.booking.data.filter(booking => booking.status === 0),
    }
});

let page = usePage().props.value;
let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/bookings', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));
</script>
