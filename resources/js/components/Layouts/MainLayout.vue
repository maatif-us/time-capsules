<template>
    <Nav></Nav>
    <div class="container-fluid mt-3 text-center">
        <router-view></router-view>
    </div>
</template>

<script>

import Nav from './Nav.vue'
export default {
    name:"default-layout",
    components: {
        Nav,
    },
}
</script>
