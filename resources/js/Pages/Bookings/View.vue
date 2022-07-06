<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
    <TitleLayout title="Bookings"
                 description="This page allows you to View your all your Bookings. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="row justify-content-center" v-if="bookings">
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
    </div>

</template>

<script setup>
import Pagination from "../../Shared/Pagination"
import {usePage} from '@inertiajs/inertia-vue3'
import TitleLayout from "../../Shared/TitleLayout";
import {computed} from 'vue'
import BookingCard from "../../Components/BookingCard";

defineProps({
    bookings: Object,
});
const bookings = computed(() => {
    return {
        expired: usePage().props.value.bookings.filter(booking => booking.status === 1),
        active: usePage().props.value.bookings.filter(booking => booking.status === 0),
    }
});
let page = usePage().props.value;
</script>
