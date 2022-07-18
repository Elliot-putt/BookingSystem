<template>
    <Head>
        <title>Company Search</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>
    <TitleLayout title="Search for a company"
                 description="This page allows you to search Companies services. If you Believe you should have more access please contact test@gmail.com"/>

    <div class="row justify-content-center">
        <div class="col-12 row justify-content-center">
            <h3 class="text-center">
                Company Search
            </h3>
            <div class="text-center fs-6 text-secondary mb-4">
                Click in the search box below to Search for a company <i class="fa-solid fa-circle-arrow-down"></i>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <input placeholder="Search a Company" type="text" name="search" class="input-search" v-model="search">
            </div>
            <div class="my-4">

                    <p class="text-center" :class="companies.data.length === 0 ? 'text-red' :'text-secondary'" v-text="companies.data.length + ' Item(s) Found '"></p>
                    <CompanyCard :comapnies="companies.data"/>
                    <Pagination class="mt-4" :links="companies.links"/>
            </div>

            <div v-if="companies.length < 1" class="mt-4">
                <p class="text-center">Search for a Company</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import Pagination from "../../Shared/Pagination"
import TitleLayout from "../../Shared/TitleLayout";
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import throttle from "lodash/throttle"
import CompanyCard from "../../Components/CompanyCard";

let search = ref(props.filters.search);

let props = defineProps({
    companies: Object,
    filters: Object,
});
watch(search, throttle(function (value) {
    Inertia.get('/company/search', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));
</script>

