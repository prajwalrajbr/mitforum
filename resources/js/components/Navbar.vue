<template>
    <nav>
      <v-app-bar app color="blue" >

          <v-app-bar-nav-icon @click.stop="drawer = !drawer">
              <v-icon class="black--text">menu</v-icon>
          </v-app-bar-nav-icon>

          <v-toolbar-title class="black--text" style="font-size: 0">
                  <span class="font-weight-medium text-h6">MIT</span>
                  <span class="font-weight-bold text-h6">Forum</span>
          </v-toolbar-title>

          <v-spacer></v-spacer>
    <SignInPopup/>
    <RegisterPopup/>
          <v-btn>
              <span class="grey--text text--darken-4 font-weight-bold">Sign In</span>
              <v-icon right class="font-weight-bold">exit_to_app</v-icon>
          </v-btn>

          <v-btn>
              <span class="grey--text text--darken-4 font-weight-bold">Sign Out</span>
              <v-icon right class="font-weight-bold">exit_to_app</v-icon>
          </v-btn>

      </v-app-bar>

      <div class="d-none d-sm-flex">
      <v-navigation-drawer v-model="drawer" dark fixed temporary>
        <v-list nav dense>
          <v-list-item v-model="group" active-class="light-blue--text text--accent-4" v-for="item in items" :key="item.title" link :to=item.to  >
            <v-list-item-icon class="font-weight-medium text-h6 ">
              <v-icon class="pa-2 px-1">{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content >
              <v-list-item-title class="font-weight-medium text-h6 ">{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <template v-slot:append >
          <div class="pa-3">
            <v-btn block class="white" v-bind:color="type==='guest' ? 'white' : 'grey'">
              <span class="black--text font-weight-bold">Sign Out</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
            </v-btn>
          </div>
          <div class="pa-3">
            <v-btn block class="white" v-bind:color="type==='guest' ? 'white' : 'grey'">
              <span class="black--text font-weight-bold">Sign In</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
            </v-btn>
          </div>
        </template>
        
      </v-navigation-drawer>
      </div>
      
      <div class="d-flex d-sm-none">
      <v-navigation-drawer v-model="drawer" dark fixed temporary bottom>
        <v-list nav dense>
          <v-list-item v-model="group" active-class="light-blue--text text--accent-4" v-for="item in items" :key="item.title" link :to=item.to  >
            <v-list-item-icon class="font-weight-medium text-h6 ">
              <v-icon class="pa-2 px-1">{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content >
              <v-list-item-title class="font-weight-medium text-h6 ">{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <template v-slot:append >
          <div class="pa-3">
            <v-btn block class="white" v-bind:color="type==='guest' ? 'white' : 'grey'">
              <span class="black--text font-weight-bold">Sign Out</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
            </v-btn>
          </div>
        </template>
      </v-navigation-drawer>
      </div>
  
  
    </nav>
    
</template>


<script>
import SignInPopup from "./SignInPopup";
import RegisterPopup from "./RegisterPopup";
export default{
  components: {
      SignInPopup,
      RegisterPopup
    },
    data(){
        return{
            drawer: false,
            items: [
              { title: 'Home', icon: 'home', to:'/' },
              { title: 'About', icon: 'help_center', to:'/about' },
            ]
        }
    }
}
</script>

<style>

</style>