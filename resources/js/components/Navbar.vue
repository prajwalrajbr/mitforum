<template>
    <nav>
        <v-toolbar app color="blue">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
                <v-icon class="black--text">menu</v-icon>
            </v-app-bar-nav-icon>
            <v-toolbar-title class="black--text" style="font-size: 0">
                    <span class="font-weight-medium text-lg-h6" id="mit">MIT</span>
                    <span class="font-weight-bold text-lg-h6" id="forum">Forum</span>
            </v-toolbar-title>
            <router-link to='/'>Home</router-link>
            <router-link to='/about'>About</router-link>
            <v-spacer></v-spacer>
            <v-btn>
                <span class="grey--text text--darken-4 font-weight-bold">Sign Out</span>
                <v-icon right class="font-weight-bold">exit_to_app</v-icon>
            </v-btn>
        </v-toolbar>
        <v-navigation-drawer v-model="drawer" absolute bottom temporary>
            <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          
            <router-link to='/about'><v-list-item>
            <v-list-item-title>About</v-list-item-title></v-list-item></router-link>
            <router-link to='/'><v-list-item>
            <v-list-item-title>home</v-list-item-title></v-list-item></router-link>
          

          <v-list-item>
            <v-list-item-title>Bar</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Fizz</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Buzz</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
        </v-navigation-drawer>
    </nav>
</template>


<script>
export default{
    data(){
        return{
            drawer: false
        }
    }
}
</script>

<style>
#mit{
    padding-right: 0;
}
#forum{
    padding-left: 0;
}

</style>