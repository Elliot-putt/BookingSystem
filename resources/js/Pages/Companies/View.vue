<template>
    <Head>
        <title>Companies</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>
    <TitleLayout title="Companies"
                 description="This page allows you to search Companies. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <Link href="/company/create" class="text-decoration-none my-auto mx-2 btn btn-blue">Create a new Company +
        </Link>
    </div>
    <div class="card shadow mb-4">
        <div class=" card-body">
            <div class="d-flex mx-2 ">
                <label class="me-2 my-auto">Name Filter:</label>
                <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
            </div>
            <table class="table table-responsive ">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col" class=" d-none d-md-table-cell">Address 1</th>
                    <th scope="col" class=" d-none d-md-table-cell">Address 2</th>
                    <th scope="col" class=" d-none d-md-table-cell">City</th>
                    <th scope="col" class=" d-none d-md-table-cell">County</th>
                    <th scope="col" class=" d-none d-md-table-cell">Postcode</th>
                    <th scope="col" class=" d-none d-md-table-cell">Telephone</th>
                    <th scope="col" class=" d-none d-md-table-cell">Email</th>
                    <th scope="col" class=" d-none d-md-table-cell">Url</th>
                    <th scope="col" class="text-end ">Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="company in companies.data" :key="company.id">
                    <td v-text="company.name"></td>
                    <td class="d-none d-md-table-cell" v-text="company.address_1 || 'N/A'"></td>
                    <td class="d-none d-md-table-cell" v-text="company.address_2 || 'N/A'"></td>
                    <td class="d-none d-md-table-cell" v-text="company.city || 'N/A'"></td>
                    <td class="d-none d-md-table-cell" v-text="company.county || 'N/A'"></td>
                    <td class="d-none d-md-table-cell" v-text="company.postcode || 'N/A'"></td>
                    <td class="d-none d-md-table-cell" v-text="company.telephone || 'N/A'"></td>
                    <td class="d-none d-md-table-cell" v-text="company.email || 'N/A'"></td>
                    <td class="d-none d-md-table-cell" v-text="company.url || 'N/A'"></td>
                    <td class="text-end">
                        <div class="dropdown no-arrow">
                            <a class="btn btn-blue dropdown-toggle" href="#" role="button"
                               id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu text-right dropdown-menu-right shadow animated--fade-in"
                                 aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header text-left">Options:</div>
                                <Link class="dropdown-item" :href="`/company/ ${company.id}/show`">View</Link>
                                <Link class="dropdown-item" :href="`/company/ ${company.id}/edit`">Edit</Link>
                                <Link class="dropdown-item" :href="`/company/${company.id}/service`">Services</Link>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <Pagination class="mt-4" :links="companies.links"/>
        </div>
    </div>
</template>
<script setup>
import Pagination from "../../Shared/Pagination"
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import throttle from "lodash/throttle"
import TitleLayout from "../../Shared/TitleLayout";

let props = defineProps({
    companies: Object,
    filters: Object,
});
let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/company', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));


</script>
