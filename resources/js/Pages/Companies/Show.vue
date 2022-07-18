<template>
    <main class='mt-3 container'>
        <TitleLayout :title="` View Company - ${company.name}`"
                     description="This Page allows you to view a companies details. If you have any queries please contact the web development team on sc@clpt.co.uk."/>
        <div class='card shadow mb-4'>
            <div class='card-body row justify-content-evenly'>
                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Profile Picture</p>
                        </div>
                        <div
                            class="p-2 px-5 border-top border-secondary border-2 h-100 d-flex justify-content-center align-items-center flex-column">
                            <img

                                :src="companyImg"
                                class="rounded border border-secondary mb-4 img-fluid"
                                alt="profile image">
                        </div>
                    </div>
                </div>

                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Information</p>
                        </div>
                        <div
                            class="bg-light p-4 border-top border-secondary border-2 min-box text-center d-flex justify-content-center align-items-center flex-column">

                            <div class="mb-4">
                                <h4>{{ company.name }}</h4>
                                <hr class="m-0 p-0 w-25 mx-auto">
                                <p class="mb-3">Email: <a href="mailto:{{company.email}}">{{ company.email }}</a></p>
                            </div>
                            <div class="mb-4">
                                <h4 class="mb-3">Account Information</h4>
                                <p>Created: {{ company.created_at_date }}</p>
                                <p>Telephone: {{ company.telephone }}</p>
                                <p>Url: {{ company.url }}</p>
                                <p>Amount of Members: {{ company.memberCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Location</p>
                        </div>
                        <div class="bg-light p-4 border-top border-secondary border-2 min-box">
                            <div class="model_image p-4 d-flex justify-content-center align-items-middle">
                                <img class="img-fluid"
                                     :src="locationImg"
                                     alt="Select Profile Picture">
                            </div>
                            <div class="model_no py-2 px-4 text-center">
                                {{ company.address_1 }}
                                <small>
                                    {{ company.address_2 }}
                                </small>
                            </div>
                            <div class="model_no py-2 px-4 text-center">
                                {{ company.city + ', ' + company.county + ', ' + company.postcode }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4 pt-2 p-r5 p-l5 ">
            <div class="card shadow h-100 pb-2">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold">Members in the Company</h5>
                    <Link class="btn btn-blue" as="button" @click="userInvite">Invite a User +</Link>
                </div>
                <div class="card-body">
                    <div v-for="member in members"
                         class='d-flex justify-content-between align-items-center m-3 p-2 bg-light rounded'>
                        <p class='text-purple m-0 m-md-4'>Member: {{ member.name }}</p>
                        <span>
                                        <a :href="`/user/${member.id}/show`"
                                           class="d-sm-inline-block btn shadow-sm m-0 m-md-4 btn-blue">
                                                <i class="fas fa-arrow-circle-right fa-sm me-1"></i><span
                                            class='d-none d-lg-inline'>CLick to View</span></a>

                                            </span>
                    </div>
                    <p v-if="members.length < 1" class='text-center text-purple m-0 m-md-4'>No Members Attached to this
                        company</p>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
import TitleLayout from "../../Shared/TitleLayout";
import locationImg from "../../../../public/images/location-image.svg";
import companyImg from "../../../../public/images/building.svg";
import Swal from "sweetalert2";
import {Inertia} from "@inertiajs/inertia";
import {usePage} from "@inertiajs/inertia-vue3";


defineProps({
    company: Object,
    members: Object
});
let page = usePage().props.value;
let userInvite = () => {
    Swal.fire({
        title: 'Enter a SimplyCentral username',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Look up',
        showLoaderOnConfirm: true,
        preConfirm: (login) => {
            return fetch(`/users/${login}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        // `Request failed: ${error}`
                        `No User Found Request Failed`
                    )
                })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
Inertia.post(`/company/${page.company.id}/user/${result.value.id}/assign`)
            Swal.fire({
                title: `User ${result.value.name} Has been added to your company!`,
            })
        }
    })
}
</script>
