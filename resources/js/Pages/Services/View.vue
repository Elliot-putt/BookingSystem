<template>
    <Head>
        <title>{{company.name}} - services</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>
    <TitleLayout :title="company.name + ' - services'"
                 description="This page allows you to search Companies services. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <Link :href="`/company/${company.id}/service/create`" class="text-decoration-none my-auto mx-2">Create a new Service +</Link>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 row justify-content-around">
            <div v-for="service in services" class="col-md-3 bg-light rounded row m-0 p-0 shadow m-2"
                 style="min-height: 270px">
                <Link as="button" :href="`/booking/${company.id}/${service.id}/`" class="btn d-flex p-0 m-0" href="#">
                    <div class="col-md-4 text-start d-flex flex-column justify-content-evenly bg-primary rounded p-4">
                        <img height="110px"
                             src="https://www.centrallearning.co.uk/wp-content/uploads/2022/06/CLPT-Logo-SQ.png">
                        <div class="mx-auto">
                            <p class="text-center m-0 text-white">Popularity</p>
                            <span class="py-1 px-4 bg-light rounded">75%</span>
                        </div>
                    </div>
                    <div class="col-md-8 text-center d-flex flex-column justify-content-evenly px-4 py-3">
                        <p class="fs-5" v-text="service.title"></p>
                        <p v-text="service.description"></p>
                        <Link as="button" :href="`/booking/${company.id}/${service.id}/`" class="button" type="button" data-hover="Book Now" data-active="I'M ACTIVE"><span v-text="'Duration: ' + service.duration"></span>
                        </Link>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import TitleLayout from "../../Shared/TitleLayout";
import {usePage} from "@inertiajs/inertia-vue3";

let emit = defineEmits(["bookModal"])
let page = usePage().props.value;
defineProps({
    company: Object,
    services: Object,
    filters: Object,
})
let show = () =>{
    alert(page.services)
}
</script>

