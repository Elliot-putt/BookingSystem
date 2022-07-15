<template>
    <Link as="div" @click="options(booking.id)" v-for="booking in bookings"
          class="bg-light card-css-shadow rounded-hard-blue card-md cursor-click card-shadow col-7 bg-light mx-auto mb-4">
        <div class="row m-2">
            <div class="col-10 d-flex flex-column">
                <div class="d-flex me-2 mt-2">
                    <p class="bg-green p-1 rounded flex text-white" v-if="booking.status === 0">Confirmed -
                        #{{ booking.ref }}</p>
                    <p class="bg-grey p-1 rounded flex text-white" v-else-if="booking.status === 1">
                        Finished - #{{ booking.ref }}</p>
                </div>
                <p class=" fw-bold fs-4 my-0" v-text="booking.serviceName"></p>
                <p class="text-secondary fs-6 mt-0" v-text="booking.company.address_1"></p>
                <div class="d-flex">
                    <img class="img-text-size "
                         :src="imageSmall"
                         alt="Company img">
                    <p class="my-auto left-divider mx-2 px-2" v-text="booking.company.name"></p>
                </div>
            </div>
            <div class="col-2 d-flex flex-column text-center my-auto left-divider ">
                <p class="fs-4 m-0" v-text="booking.month"></p>
                <p class="fs-2 m-0" v-text="booking.day"></p>
                <p class="fs-3 m-0 text-secondary" v-text="booking.time"></p>
            </div>
        </div>
    </Link>

</template>

<script setup>
import Pagination from "../Shared/Pagination"
import imageSmall from "../../../public/images/simplycentral.png"
import Swal from "sweetalert2";
import {Inertia} from "@inertiajs/inertia";
defineProps({
    bookings: Object
});
let options = (id) => {
    Swal.fire({
        title: 'Booking Options',
        text: "All changes are permanent",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ff6633',
        cancelButtonColor: '#3f5efb',
        confirmButtonText: 'Yes, delete my booking!'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(`/booking/${id}/delete`);
            //delete booking inertia.delete
            Swal.fire(
                'Deleted!',
                'Your Booking has been deleted.',
                'success'
            )
        }
    })
}
</script>


