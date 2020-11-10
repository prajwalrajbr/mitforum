<template>
    <nav>
        <v-toolbar app>
        <v-toolbar-title class="text-uppercase grey--text">
            <span class="font-weight-light">MIT</span>
            <span>Forum</span>
        </v-toolbar-title>
            <router-link to='/'>Home</router-link>
            <router-link to='/about'>About</router-link>
            <v-spacer></v-spacer>
            <v-btn class="grey">
                <span>Sign Out</span>
            </v-btn>
        </v-toolbar>
        
    </nav>
</template>


<script>
export default{
}
</script>