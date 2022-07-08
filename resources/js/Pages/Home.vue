<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
    <!--    if you have a company or are assigned one show company stats -->
    <div class="container-fluid ">
        <div class="row justify-content-center full">
            <div class="col-10 d-flex mx-auto my-auto ">
                <div class="mx-auto">
                    <h1 class="text-purple">
                        Online Booking System <br> <span class="text-red">for all service based users</span></h1>
                    <p class="text-secondary">
                        Simply define your services and providers, display their availability, and you will have clients
                        both
                        old and new making bookings 24/7. </p>
                    <div class="d-flex">
                        <div class="me-2">

                            <button class="fancy" type="submit">
                                <span class="top-key"></span>
                                <span class="text">Create a Company</span>
                                <span class="bottom-key-1"></span>
                                <span class="bottom-key-2"></span>
                            </button>
                        </div>
                        <div class="me-2">

                            <button class="fancy" type="submit">
                                <span class="top-key"></span>
                                <span class="text">Invite a User</span>
                                <span class="bottom-key-1"></span>
                                <span class="bottom-key-2"></span>
                            </button>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end my-4">
                        <button class="cssbuttons-io-button"> Get started
                            <div class="icon">
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="mx-auto">
                    <Link :href="`/users/${$page.props.auth.user.id}/edit`" as="span">
                        <div class="card-css cursor-click">
                            <div class="blob"></div>
                            <span class="img"><img class="img-card" :src="imageSmall"> </span>
                            <h2>{{ username }}</h2>
                            <p class="text-blue">
                                View Your profile </p>
                        </div>
                    </Link>
                </div>
            </div>
            <div class="text-center scroll">
                <section id="section07" class="demo">
                    <a href="#card"><span></span><span></span><span></span>Scroll</a>
                </section>
            </div>
        </div>
        <div class="row" id="card">
            <div class="col-12 my-auto row">
                <div class="col-4 justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-magnifying-glass text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-blue">Find a service</p>
                            </div>
                            <div >
                                <p class="text-muted">Finding a service is easy. Search for an event you would like to book , select a date and time that suits the user and click confirm! click on the Click below to find out more.</p>

                            </div>
                        </div>
                        <Link as="a" class="card-button text-center btn">More info</Link>
                    </div>
                </div>
                <div class="col-4 justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-building text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-blue">Create a Booking</p>
                            </div>
                            <div >
                                <p class="text-muted">Creating a booking couldn't be easier. Either search for your company if they are registered click ahead , else search for a service in your area.Click below to find out more.</p>

                            </div>
                        </div>
                        <Link as="a" class="card-button text-center btn">More info</Link>
                    </div>
                </div>
                <div class="col-4 justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-building text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-blue">Create a Company</p>
                            </div>
                            <div >
                                <p class="text-muted">Companies allow you to create services and manage you bookings. Create a company and allow users to find your service.Click below to find out more.</p>

                            </div>
                        </div>
                        <Link as="a" class="card-button text-center btn">More info</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    if you dont have a company show search for companies to book with or searhc for services with data or ask if they want ot create a company  -->

</template>
<script setup>
import imageSmall from "../../../public/images/simplycentrawhitel.png"
import calendar from "../../../public/images/Bookedlogo.png"
import {computed} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";

const username = computed(() => {
    return usePage().props.value.auth.user.username
});
let scrollToHere = () => {

}
</script>

