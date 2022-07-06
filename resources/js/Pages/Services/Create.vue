<template>
    <Head>
        <title>Create Service</title>
        <meta type="description" content="Creating a user in my app" head-key="description">
    </Head>
    <TitleLayout title="Create new Service"
                 description="Please fill in the details below to create a Service. If you Believe you should have more access please contact test@gmail.com"/>
    <form @submit.prevent="submit">
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
                                       placeholder="Please enter a title" v-model="form.title">
                            </div>
                        </div>
                        <div class="col-5">
                            <label for="file" class="mb-2">Select the Image to upload a photo:</label>
                            <div class="mb-2">
                                <input id="file" type="file" class="form-control" name="file[]"
                                       accept="file_extension|audio/*|video/*|image/*|media_type">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <label for="duration" class="form-label fw-bold">Duration(Minutes)<span
                                    class="text-danger">*</span></label>
                                <div v-if="form.errors.duration" v-text="' - ' + form.errors.duration"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="title" class="form-control"
                                       :class="form.errors.duration ? 'border-danger' : '' " id="duration"
                                       placeholder="Please enter a duration" v-model="form.duration">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex">
                                <div>
                                    <label for="price" class="form-label fw-bold">Price</label>
                                    <input v-model="price" v-if="price" class="mx-2" type="checkbox"
                                           @change="price.value = true">
                                </div>
                                <div v-if="form.errors.price" v-text="' - ' + form.errors.price"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <div v-if="!price" class="d-flex my-auto">
                                    <label for="price-toggle" class="mx-2">Does this Item Need a Price?</label>
                                    <input v-model="price" type="checkbox" id="price-toggle"
                                           @change="price.value = false">
                                </div>
                                <input v-if="price" type="text" name="price" class="form-control"
                                       :class="form.errors.price ? 'border-danger' : '' " id="price"
                                       placeholder="Please enter a price" v-model="form.price">
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
                                              placeholder="Please enter a Description to describe this service."></textarea>
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
let page = usePage().props.value;
let form = useForm({
    file: '',
    title: '',
    price: '',
    duration: '',
    description: '',

});
let submit = () => {

    form.post(`/company/${page.company.id}/service/store`, form);
}

</script>

