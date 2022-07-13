<template>
    <Head>
        <title>{{company.name}} - services</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>
    <TitleLayout :title="company.name + ' - services'"
                 description="This page allows you to search Companies services. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <Link :href="`/company/${company.id}/service/create`" class="text-decoration-none my-auto mx-2">Create a new
            Service +
        </Link>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 row justify-content-around">
            <div v-for="service in services" class="col-md-3 bg-light rounded row m-0 p-0 shadow m-2"
                 style="min-height: 270px">
                <div class="col-md-4 text-start d-flex flex-column justify-content-evenly bg-primary rounded p-4">
                    <img class="img-small"
                         src="https://www.centrallearning.co.uk/wp-content/uploads/2022/06/CLPT-Logo-SQ.png">
                    <div class="mx-auto">
                        <p class="text-center m-0 text-white">Popularity</p>
                        <span class="py-1 px-4 bg-light rounded">75%</span>
                    </div>
                </div>
                <div class="col-md-8 text-center d-flex flex-column justify-content-evenly px-4 py-3">
                    <p class="fs-5" v-text="service.title"></p>
                    <p v-text="service.description"></p>
                    <Link as="button" v-if="!service.requiresDuration" :href="`/booking/${company.id}/${service.id}/`"
                          class="button" type="button" data-hover="Book Now" data-active="I'M ACTIVE">
                        <span v-if="service.allDay" v-text="'Duration: All Day'"></span>
                        <span v-if="service.hasDuration" v-text="'Duration: ' + service.duration"></span>
                        <span v-if="service.requiresDuration" v-text="'Between Working Hours'"></span>
                    </Link>
                    <div v-else>
                        <input type="text" name="duration" required :class="duration === undefined || duration === ''  ? 'border-warning' : '' "
                               class="form-control text-center input-flow mx-auto card-css-shadow px-2" id="duration"
                               placeholder="Duration in minutes" v-model="duration">
                        <Link as="button" @click.prevent="getDuration(service , company)" class="button" type="button"
                              data-hover="Book Now" data-active="I'M ACTIVE">
                            <span v-if="service.allDay" v-text="'Duration: All Day'"></span>
                            <span v-if="service.hasDuration" v-text="'Duration: ' + service.duration"></span>
                            <span v-if="service.requiresDuration" v-text="'Between Working Hours'"></span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import TitleLayout from "../../Shared/TitleLayout";
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import {ref} from "vue";
let emit = defineEmits(["bookModal"])
let page = usePage().props.value;
let duration = ref();
defineProps({
    company: Object,
    services: Object,
    filters: Object,
})
let getDuration = (service, company) => {
    if (duration.value ) {
        Inertia.get(`/booking/${company.id}/${service.id}/`, {duration: duration.value});
    }
}
</script>

