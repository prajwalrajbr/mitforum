<template>
    <v-app> 
            <Navbar/>
            <router-view></router-view>
    </v-app> 

</template>

<script>
import Navbar from "./components/Navbar.vue";
export default{
    components: {
        Navbar
    }
}
</script>