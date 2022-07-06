<template>
    <Head>
        <title>Login</title>
        <meta type="description" content="Logging into My App" head-key="description">
    </Head>
    <main class="font-sans text-gray-900 antialiased bg-dark container-fluid vh-100 d-flex">
        <div class="  h-50 w-50 mx-auto my-auto row justify-content-center">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <h1 class="text-center mb-5 text-white">Bookings App</h1>
                    <div class="col-md-6 mx-auto text-center mt-5 bg-light p-4 rounded">
                        <div class="mb-4 d-flex flex-column input-group">
                            <div class="d-flex">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div v-if="form.errors.email" v-text="' - ' + form.errors.email"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control" required
                                       :class="form.errors.email ? 'border-danger' : '' " id="email"
                                       placeholder="Please enter a valid email" v-model="form.email">
                            </div>
                        </div>
                        <div class="mb-4 d-flex flex-column input-group">
                            <div class="d-flex">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div v-if="form.errors.password" v-text="' - ' + form.errors.password"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" required class="form-control"
                                       :class="form.errors.password ? 'border-danger' : '' " id="password"
                                       placeholder="Please enter a Password" v-model="form.password">
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>

<script setup>
import {useForm} from "@inertiajs/inertia-vue3";

let form = useForm({
    email: '',
    password: '',
});
let submit = () => {

    form.post('/login' ,form);
}
</script>
<script>
import GuestLayout from "../../Shared/Guest-Layout";

export default {
    layout: GuestLayout,
}
</script>

