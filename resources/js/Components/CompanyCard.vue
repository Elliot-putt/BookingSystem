<template>
    <Link as="div"  v-for="company in comapnies"
          class="bg-light card-css-shadow rounded-hard-blue card-md cursor-click card-shadow col-7 bg-light mx-auto mb-4">
        <div class="row m-2">
            <div class="col-10 d-flex flex-column">
                <div class="d-flex me-2 mt-2">
                    <p class="bg-green p-1 rounded flex text-white" v-if="company.new === false">New*</p>
                </div>
                <p class=" fw-bold fs-4 my-0" v-text="company.name"></p>
                <p class="text-secondary fs-6 mt-0" v-text="company.address_1"></p>
                <div class="d-flex">
                    <img class="img-text-size "
                         :src="imageSmall"
                         alt="Company img">
                    <p class="my-auto left-divider mx-2 px-2" v-text="'created: ' + company.date"></p>
                </div>
            </div>
            <div class="col-2 d-flex flex-column text-center my-auto left-divider ">
                <p class="fs-4 m-0" v-text="'Bookings: ' + company.bookings"></p>
                <p class="fs-4 m-0" v-text="'Members: ' +company.members"></p>
            </div>
        </div>
    </Link>
</template>

<script setup>
import imageSmall from "../../../public/images/simplycentral.png"

defineProps({
    comapnies: Object
});
</script>
