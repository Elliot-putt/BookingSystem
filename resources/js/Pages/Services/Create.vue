<template>
    <Head>
        <title>Create Service</title>
        <meta type="description" content="Creating a user in my app" head-key="description">
    </Head>
    <TitleLayout title="Create new Service"
                 description=" fill in the details below to create a Service. If you Believe you should have more access  contact test@gmail.com"/>
    <form @submit.prevent="submit" >
        <div class="row justify-content-center h-100">
            <div v-if="Object.keys(form.errors).length > 0"
                 class="d-flex justify-content-center alert alert-danger w-50">
                <p class="text-danger my-auto">You Have Errors in your Form.</p>
            </div>
            <div class="col-8">
                <div class="card shadow mt-4 box">
                    <div class="card-body row justify-content-center">
                        <h4 class="mb-2 text-center">Service Information</h4>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="title" class="form-label fw-bold">Title<span
                                    class="text-danger">*</span></label>
                                <div v-if="form.errors.title" v-text="' - ' + form.errors.title"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="title" class="form-control"
                                       :class="form.errors.title ? 'border-danger' : '' " id="title"
                                       placeholder="Enter a title" v-model="form.title">
                            </div>
                        </div>
                        <div class="col-5">
                            <label for="file" class="mb-2 fw-bold">Select the Image to upload a photo:</label>
                            <div class="mb-2">
                                <input id="file" type="file" @input="form.file = $event.target.files[0]" class="form-control" name="file[]"
                                       accept="file_extension|audio/*|video/*|image/*|media_type">
                            </div>
                        </div>
                        <!--                        service duration-->
                        <div class="col-md-5">
                            <div class="d-flex">
                                <p class="my-auto me-2 fw-bold">Does this Service Need a Duration? (Min)</p>
                                <label for="yesDuration" class="form-label my-auto fw-bold">Yes</label>
                                <input v-model="duration" @change="duration.value = !duration" type="radio"
                                       id="yesDuration" class="my-auto mx-2" name="userInput" :value="true">
                                <label for="noDuration" class="form-label my-auto fw-bold">No</label>
                                <input v-model="duration" @change="duration.value = !duration" type="radio"
                                       id="noDuration"
                                       class="my-auto mx-2" name="userInput" :value="false">
                            </div>
                            <div class="d-flex" v-if="duration">
                                <p class="my-auto me-2 fs-6 text-secondary">Does this Service Require a full working
                                    day?</p>
                                <input type="checkbox" v-model="fullDay" :value="fullDay" @change="fullDay.value = !fullDay">
                                <input name="fullDay" hidden :value="fullDay">
                            </div>
                            <div class="input-group mt-3">
                                <input v-if="!fullDay" type="text" name="duration" class="form-control"
                                       :disabled="!duration"  :class="form.errors.duration ? 'border-danger' : '' "
                                       v-model="form.duration" placeholder="Enter a Duration in Minutes...">
                            </div>
                        </div>
                        <!--user input-->
                        <div class="col-md-5">
                            <div class="d-flex">
                                <p class="my-auto me-2 fw-bold">Can the user decide the Service duration?</p>
                                <label for="yesInput" class="form-label my-auto fw-bold">Yes</label>
                                <input v-model="duration" @change="duration.value = !duration" type="radio"
                                       id="yesInput" class="my-auto mx-2" name="userInputCheck" :value="false">
                                <label for="noInput" class="form-label my-auto fw-bold">No</label>
                                <input v-model="duration" @change="duration.value = !duration" type="radio" id="noInput"
                                       class="my-auto mx-2" name="userInputCheck" :value="true">
                            </div>
                        </div>
                        <div class="col-5 my-4">
                            <div class="d-flex">
                                <p class="my-auto me-2 fw-bold">Does this service have a Price?</p>
                                <label for="yesPrice" class="form-label my-auto fw-bold">Yes</label>
                                <input v-model="price" @change="price.value = !price" type="radio"
                                       id="yesPrice" class="my-auto mx-2" name="priceCheck" :value="true">
                                <label for="noPrice" class="form-label my-auto fw-bold">No</label>
                                <input v-model="price" @change="price.value = !price" type="radio"
                                       id="noPrice"
                                       class="my-auto mx-2" name="priceCheck" :value="false">
                            </div>
                            <div class="input-group mt-3">
                                <input v-if="price" type="text" name="price" class="form-control"
                                       :class="form.errors.price ? 'border-danger' : '' "
                                       v-model="form.price" placeholder="Enter a Service price..." >
                            </div>
                        </div>
                        <div class="col-5 my-4">
                            <div class="d-flex">
                                <p class="my-auto me-2 fw-bold">Does this service have a quantity?</p>
                                <label for="yesQuantity" class="form-label my-auto fw-bold">Yes</label>
                                <input v-model="quantity" @change="quantity.value = !quantity" type="radio"
                                       id="yesQuantity" class="my-auto mx-2" name="quantityCheck" :value="true">
                                <label for="noQuantity" class="form-label my-auto fw-bold">No</label>
                                <input v-model="quantity" @change="quantity.value = !quantity" type="radio"
                                       id="noQuantity"
                                       class="my-auto mx-2" name="quantityCheck" :value="false">
                            </div>
                            <div class="input-group mt-3">
                                <input v-if="quantity" type="text" name="quantity" class="form-control"
                                       :class="form.errors.quantity ? 'border-danger' : '' "
                                       v-model="form.quantity" placeholder="Enter a Quantity amount...">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <div v-if="form.errors.description" v-text="' - ' + form.errors.description"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                    <textarea v-model="form.description" rows="10" cols="10" class="form-control"
                                              id="description" :class="form.errors.description ? 'border-danger' : '' "
                                              placeholder="Enter a Description to describe this service."></textarea>
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
import {ref} from "vue";

defineProps({
    company: Object,
});
let price = ref(false);
let fullDay = ref(false);
let quantity = ref(false);
let duration = ref(true);
let page = usePage().props.value;
let form = useForm({
    file: null,
    title: '',
    price: '',
    duration: '',
    defaultDuration: duration,
    quantity: '',
    description: '',
    fullDay: fullDay,

});

let submit = () => {

    form.post(`/company/${page.company.id}/service/store`, form);
}

</script>

