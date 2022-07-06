<template>
    <div v-for="booking in bookings" class="card card-shadow col-7 bg-light mx-auto mb-4">
        <div class="row m-2">
            <div class="col-10 d-flex flex-column">
                <div class="d-flex me-2 mt-2">
                    <p class="bg-success p-1 rounded flex text-white" v-if="booking.status === 0">Confirmed - #{{booking.ref}}</p>
                    <p class="bg-dark p-1 rounded flex text-white" v-else-if="booking.status === 1">
                        Finished - #{{booking.ref}}</p>
                </div>
                <p class=" fw-bold fs-4 my-0" v-text="booking.serviceName"></p>
                <p class="text-secondary fs-6 mt-0" v-text="booking.company.address_1"></p>
                <div class="d-flex">
                    <img height="50px"
                         src="https://www.centrallearning.co.uk/wp-content/uploads/2022/06/CLPT-Logo-SQ.png"
                         alt="Company img">
                    <p class="my-auto" v-text="booking.company.name"></p>
                </div>
            </div>
            <div class="col-2 d-flex flex-column text-center my-auto left-divider ">
                <p class="fs-4 m-0" v-text="booking.month"></p>
                <p class="fs-2 m-0" v-text="booking.day"></p>
                <p class="fs-3 m-0 text-secondary" v-text="booking.time"></p>
            </div>

        </div>
    </div>
</template>

<script setup>
defineProps({
    bookings :Object
})
</script>


