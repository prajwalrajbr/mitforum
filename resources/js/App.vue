<template>
    <v-app> 
        <div class="">
            <Navbar/>
            <v-content>
                
                <router-view></router-view>
            </v-content>
        </div>
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