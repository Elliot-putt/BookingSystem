<template>
    <nav class="navbar navbar-expand-lg navbar-light py-4 px-2 justify-content-between  bg-blue sidebar" style="border-radius: 0">
        <div class="d-flex">
            <Link class="mx-2 m-auto  text-decoration-none text-white fs-4" href="/"><img class="img-small-nav" :src="imageSmall"><img class="img" :src="image"> |</Link>
            <p class="navbar-brand fs-6 m-auto text-white fs-4">Welcome Back , {{ username }} !</p>
        </div>
        <div>
            <label  for="check" class="bar">
                <input v-model="isPanelOpen" id="check" type="checkbox">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
            </label>
        </div>
    </nav>
    <Sidebar :is-panel-open="isPanelOpen" :img="image">
        <NavLink class="mx-2" href="/" :active="$page.component === 'Home'">Home</NavLink>
        <NavLink class="mx-2" href="/bookings" :active="$page.component === 'Bookings/View'">My Bookings</NavLink>
        <NavLink class="mx-2" href="/company" :active="$page.component === 'Companies/View'">Companies</NavLink>
        <NavLink class="mx-2" href="/company" :active="$page.component === 'Companies/View'">Search Companies</NavLink>
        <NavLink class="mx-2" href="/companies" :active="$page.component === 'Companies/View'">Join a Company</NavLink>
        <NavLink class="mx-2" href="/serv" :active="$page.component === 'Services/View'">Services</NavLink>
        <NavLink class="mx-2" href="/users" :active="$page.component === 'Users/View'">Users</NavLink>
        <NavLink class="mx-2 border-top mt-2"  method="post" as="button"  href="/logout" >Logout</NavLink>
    </Sidebar>
    <div class="sidebar-backdrop" @click="isPanelOpen = !isPanelOpen" v-if="isPanelOpen"></div>

</template>

<script setup>
import imageSmall from "../../../public/images/simplycentrawhitel.png"
import image from "../../../public/images/simplycentraljusttext.png"
import NavLink from './NavLInk';
import {usePage} from '@inertiajs/inertia-vue3'
import {computed, ref} from 'vue'
import Sidebar from "../Components/Sidebar";

let isPanelOpen = ref(false);
const username = computed(() => {
    return usePage().props.value.auth.user.username
});

</script>

