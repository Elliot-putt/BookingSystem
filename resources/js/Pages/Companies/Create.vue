<template>
    <Head>
        <title>Create User</title>
        <meta type="description" content="Creating a user in my app" head-key="description">
    </Head>
    <TitleLayout title="Create new Company"
                 description="Please fill in the details below to create a company. If you Believe you should have more access please contact test@gmail.com"/>
    <form @submit.prevent="submit">
        <div class="row justify-content-center h-100">
            <div v-if="Object.keys(form.errors).length > 0" class="d-flex justify-content-center alert alert-danger w-50">
                <p class="text-danger my-auto">You Have Errors in your Form. Please check all pages</p>
            </div>
            <div class="col-8">
                <div class="card shadow mt-4 box">
                    <div class="position-relative d-flex justify-content-between mx-3 arrows">
                        <span class="prev"><a href="#" @click="prev($event.target)">&#10094;</a></span>
                        <span class="next"><a href="#" @click="next($event.target)">&#10095;</a></span>
                    </div>
                    <div class="card-body row justify-content-center">
                        <h4 class="mb-2 text-center">Company Information</h4>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="name" class="form-label fw-bold">Name <span
                                    class="text-danger">*</span></label>
                                <div v-if="form.errors.name" v-text="' - ' + form.errors.name"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control"
                                       :class="form.errors.name ? 'border-danger' : '' " id="name"
                                       placeholder="Please enter a name" v-model="form.name">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div v-if="form.errors.email" v-text="' - ' + form.errors.email"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control"
                                       :class="form.errors.email ? 'border-danger' : '' " id="email"
                                       placeholder="Please enter a valid email" v-model="form.email">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="telephone" class="form-label fw-bold">Telephone</label>
                                <div v-if="form.errors.telephone" v-text="' - ' + form.errors.telephone"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="telephone" class="form-control"
                                       :class="form.errors.telephone ? 'border-danger' : '' " id="telephone"
                                       placeholder="Please enter a valid telephone" v-model="form.telephone">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="url" class="form-label fw-bold">Url</label>
                                <div v-if="form.errors.url" v-text="' - ' + form.errors.url"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="url" class="form-control"
                                       :class="form.errors.url ? 'border-danger' : '' " id="url"
                                       placeholder="Please enter a valid url" v-model="form.url">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex">
                                <label for="address_1" class="form-label fw-bold">Address 1</label>
                                <div v-if="form.errors.address_1" v-text="' - ' + form.errors.address_1"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="address_1" class="form-control"
                                       :class="form.errors.address_1 ? 'border-danger' : '' " id="address_1"
                                       placeholder="Please enter an address" v-model="form.address_1">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex">
                                <label for="address_2" class="form-label fw-bold">Address 2</label>
                                <div v-if="form.errors.address_2" v-text="' - ' + form.errors.address_2"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="address_2" class="form-control"
                                       :class="form.errors.address_2 ? 'border-danger' : '' " id="address_2"
                                       placeholder="Please enter an address" v-model="form.address_2">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex">
                                <label for="city" class="form-label fw-bold">City</label>
                                <div v-if="form.errors.city" v-text="' - ' + form.errors.city"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="city" class="form-control"
                                       :class="form.errors.city ? 'border-danger' : '' " id="city"
                                       placeholder="Please enter a city" v-model="form.city">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="county" class="form-label fw-bold">County</label>
                                <div v-if="form.errors.county" v-text="' - ' + form.errors.county"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="county" class="form-control"
                                       :class="form.errors.county ? 'border-danger' : '' " id="county"
                                       placeholder="Please enter a county" v-model="form.county">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="postcode" class="form-label fw-bold">Postcode</label>
                                <div v-if="form.errors.postcode" v-text="' - ' + form.errors.postcode"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="postcode" class="form-control"
                                       :class="form.errors.postcode ? 'border-danger' : '' " id="postcode"
                                       placeholder="Please enter a postcode" v-model="form.postcode">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 box d-none">
                <div class="card shadow mt-4">
                    <div class="position-relative d-flex justify-content-between mx-3 arrows">
                        <span class="prev"><a href="#" @click="prev($event.target)">&#10094;</a></span>
                        <span class="next"><a href="#" @click="next($event.target)">&#10095;</a></span>
                    </div>
                    <div class="card-body row justify-content-center">
                        <h4 class="mb-2 text-center">Working Hours</h4>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="monday_start" class="form-label fw-bold">Monday Start Time</label>
                                <div v-if="form.errors.monday_start" v-text="' - ' + form.errors.monday_start"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="monday_start" class="form-select " v-model="form.monday_start"
                                        :class="form.errors.monday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="monday_start">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="monday_end" class="form-label fw-bold">Monday End Time</label>
                                <div v-if="form.errors.monday_end" v-text="' - ' + form.errors.monday_end"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="monday_end" class="form-select " v-model="form.monday_end"
                                        :class="form.errors.monday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="monday_end">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="tuesday_start" class="form-label fw-bold">Tuesday Start Time</label>
                                <div v-if="form.errors.tuesday_start" v-text="' - ' + form.errors.tuesday_start"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="tuesday_start" class="form-select " v-model="form.tuesday_start"
                                        :class="form.errors.tuesday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="tuesday_start">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="tuesday_end" class="form-label fw-bold">Tuesday End Time</label>
                                <div v-if="form.errors.tuesday_end" v-text="' - ' + form.errors.tuesday_end"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="tuesday_end" class="form-select " v-model="form.tuesday_end"
                                        :class="form.errors.tuesday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="tuesday_end">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="wednesday_start" class="form-label fw-bold">Wednesday Start Time</label>
                                <div v-if="form.errors.wednesday_start" v-text="' - ' + form.errors.wednesday_start"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="wednesday_start" class="form-select " v-model="form.wednesday_start"
                                        :class="form.errors.wednesday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="wednesday_start">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="wednesday_end" class="form-label fw-bold">Wednesday End Time</label>
                                <div v-if="form.errors.wednesday_end" v-text="' - ' + form.errors.wednesday_end"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="wednesday_end" class="form-select " v-model="form.wednesday_end"
                                        :class="form.errors.wednesday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="wednesday_end">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="thursday_start" class="form-label fw-bold">Thursday Start Time</label>
                                <div v-if="form.errors.thursday_start" v-text="' - ' + form.errors.thursday_start"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="thursday_start" class="form-select " v-model="form.thursday_start"
                                        :class="form.errors.thursday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="thursday_start">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="thursday_end" class="form-label fw-bold">Thursday End Time</label>
                                <div v-if="form.errors.thursday_end" v-text="' - ' + form.errors.thursday_end"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="thursday_end" class="form-select " v-model="form.thursday_end"
                                        :class="form.errors.thursday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="thursday_end">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="friday_start" class="form-label fw-bold">Friday Start Time</label>
                                <div v-if="form.errors.friday_start" v-text="' - ' + form.errors.friday_start"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="friday_start" class="form-select " v-model="form.friday_start"
                                        :class="form.errors.friday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="friday_start">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="friday_end" class="form-label fw-bold">Friday End Time</label>
                                <div v-if="form.errors.friday_end" v-text="' - ' + form.errors.friday_end"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="friday_end" class="form-select " v-model="form.friday_end"
                                        :class="form.errors.friday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="friday_end">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="saturday_start" class="form-label fw-bold">Saturday Start Time</label>
                                <div v-if="form.errors.saturday_start" v-text="' - ' + form.errors.saturday_start"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="saturday_start" class="form-select " v-model="form.saturday_start"
                                        :class="form.errors.saturday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="saturday_start">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="saturday_end" class="form-label fw-bold">Saturday End Time</label>
                                <div v-if="form.errors.saturday_end" v-text="' - ' + form.errors.saturday_end"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="saturday_end" class="form-select " v-model="form.saturday_end"
                                        :class="form.errors.saturday_end ? 'border-danger' : '' "
                                        aria-label="Default select example" id="saturday_end">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="sunday_start" class="form-label fw-bold">sunday Start Time</label>
                                <div v-if="form.errors.sunday_start" v-text="' - ' + form.errors.sunday_start"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="sunday_start" class="form-select " v-model="form.sunday_start"
                                        :class="form.errors.sunday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="sunday_start">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="sunday_end" class="form-label fw-bold">sunday End Time</label>
                                <div v-if="form.errors.sunday_end" v-text="' - ' + form.errors.sunday_end"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="sunday_end" class="form-select " v-model="form.sunday_end"
                                        :class="form.errors.sunday_start ? 'border-danger' : '' "
                                        aria-label="Default select example" id="sunday_end">
                                    <option disabled value="">Please select a Time</option>
                                    <option v-for="hour in hours" v-text="hour"></option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-1 offset-md-10">
                <button class="btn btn-success" :disabled="form.processing">Submit</button>
            </div>
        </div>

    </form>
</template>

<script setup>
import {useForm, usePage} from "@inertiajs/inertia-vue3"
import TitleLayout from "../../Shared/TitleLayout";

defineProps({
    hours: Array,
})
let emit = defineEmits(["prev", 'next']);
let form = useForm({
    name: '',
    address_1: '',
    address_2: '',
    city: '',
    county: '',
    postcode: '',
    telephone: '',
    email: '',
    url: '',
    monday_start: '',
    monday_end: '',
    tuesday_start: '',
    tuesday_end: '',
    wednesday_start: '',
    wednesday_end: '',
    thursday_start: '',
    thursday_end: '',
    friday_start: '',
    friday_end: '',
    saturday_start: '',
    saturday_end: '',
    sunday_start: '',
    sunday_end: '',
});
let submit = () => {

    form.post('/company', form);
}
let prev = (e) => {
    let currentCard = e.parentElement.parentElement.parentElement.parentElement;
    let prevCard = currentCard.previousElementSibling;
    if (prevCard !== null) {
        currentCard.classList.add('d-none');
        prevCard.classList.remove('d-none')
    }


}
let next = (e) => {
    let currentCard = e.parentElement.parentElement.parentElement.parentElement;
    let nextCard = currentCard.nextElementSibling;
    if (nextCard !== null) {
        currentCard.classList.add('d-none');
        nextCard.classList.remove('d-none')
    }
}
</script>
