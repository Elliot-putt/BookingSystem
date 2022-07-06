<template>
    <Link :class="active ? 'btn-dark' : 'text-black'" class="text-decoration-none btn" ><slot/></Link>
</template>

<script setup>

defineProps({
    active:Boolean,
})
</script>

