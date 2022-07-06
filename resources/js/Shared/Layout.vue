<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>
    <div class="col-md-12">
        <Nav/>
    </div>
    <div class="col-md-11 my-2 mx-auto">
        <slot/>
    </div>
</template>

<script setup>
import Nav from "./Nav";

</script>

