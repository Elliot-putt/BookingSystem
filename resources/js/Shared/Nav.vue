<template>
    <nav class="navbar navbar-expand-lg navbar-light py-4 px-2 justify-content-between" style="background: #fd5c63; ">
        <div class="d-flex">
            <Link class="mx-2 m-auto  text-decoration-none text-black" href="/" >Booking System |</Link>
            <p class="navbar-brand fs-6 m-auto ">Welcome Back , {{username}} !</p>
        </div>
        <div>
            <NavLink class="mx-2" href="/" :active="$page.component === 'Home'">Home</NavLink>
            <NavLink class="mx-2" href="/bookings" :active="$page.component === 'Bookings/View'">Bookings</NavLink>
            <NavLink class="mx-2" href="/company" :active="$page.component === 'Companies/View'">Companies</NavLink>
            <NavLink class="mx-2" href="/users" :active="$page.component === 'Users/View'">Users</NavLink>
            <NavLink class="mx-2" method="post" as="button"  href="/logout" >Logout</NavLink>
        </div>
    </nav>

</template>

<script setup>
import NavLink from './NavLInk';
import {usePage} from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

const username = computed(() => {
    return usePage().props.value.auth.user.username
});
</script>

