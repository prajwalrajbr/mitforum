<template>
    <nav>
      <v-snackbar v-model="snackbar" :timeout="4000" top dark color="success" outlined >
        <span class=" text--darken-4 font-weight-bold">{{ snackbarText }}</span>
        <template v-slot:action="{ attrs }">
          <v-btn color="error font-weight-bold" text v-bind="attrs" @click="snackbar = false">Close</v-btn>
        </template>
      </v-snackbar>
      <v-app-bar app color="blue" >
        <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            <v-icon class="black--text">menu</v-icon>
        </v-app-bar-nav-icon>
        <v-toolbar-title class="black--text" style="font-size: 0">
                <span class="font-weight-medium text-h6">MIT</span>
                <span class="font-weight-bold text-h6">Forum</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <div v-if="userName">
          <spam class="font-weight-bold text-title pr-10">Logged in as {{ userName }}</spam>
        </div>
        <div>
          <SignInPopup />
        </div>  
      </v-app-bar>
      <div v-if="$vuetify.breakpoint.name === 'xs' || $vuetify.breakpoint.name === 'sm'">
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
          <div class="pa-3" v-if="loggedIn">
            <v-btn class="white mr-5" @click='logout' block>
              <span class="grey--text text--darken-4 font-weight-bold" >logout</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
            </v-btn>
          </div>
          <div class="pa-3" v-else>
            <v-btn class="white mr-5" @click='login' block>
              <span class="grey--text text--darken-4 font-weight-bold">Log In</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
            </v-btn>
          </div>
        </template>
      </v-navigation-drawer>
      </div>
      <div v-else>
      <v-navigation-drawer v-model="drawer" dark fixed temporary v-bind:width="375">
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
          <div class="pa-3" v-if="loggedIn">
            <v-btn class="white mr-5" @click='logout' block>
              <span class="grey--text text--darken-4 font-weight-bold" >logout</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
            </v-btn>
          </div>
          <div class="pa-3" v-else>
            <v-btn class="white mr-5" @click='login' block>
              <span class="grey--text text--darken-4 font-weight-bold">Log In</span>
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
import ForgotPassword from "./ForgotPassword";

import user from "../apis/user";

export default{
  components: {
      SignInPopup,
      RegisterPopup,
      ForgotPassword
    },
  data(){
    return{
      snackbarText: "",
      snackbar: false,
      loggedIn:false,
      drawer: false,
      userName: null,
      items: [
        { title: 'Home', icon: 'home', to:'/' },
        { title: 'Notes', icon: 'import_contacts', to:'/notes' },
        { title: 'Assignments', icon: 'assignment', to:'/assignments' },
        { title: 'Assessments', icon: 'border_color', to:'/assessments' },
        { title: 'Announcements and Queries', icon: 'info', to:'/announcements-queries' },
        { title: 'About', icon: 'help_center', to:'/about' },
      ]
    }
  },
  methods: {
    logout () {
      user.logout().then(()=>{
        localStorage.removeItem("auth");
        this.loggedIn = false
        this.$root.$emit('loggedOut', "true");
        this.userName = "";
        this.$root.$emit('userName', this.userName);
        this.$root.$emit('showSnackbar', "Successfully logged out");
      })
    },
    login(){
      this.$root.$emit('showLogInPopup', "true");
    },
  },
  mounted(){
    user.auth()
    .then((res)=>{
        this.userName = res.data.full_name;
    }).catch((err)=>{
      this.$root.$emit('showSnackbar', "Please log-in to continue");
    })
    this.$root.$on('showSnackbar', (text) =>{
      this.snackbarText = text;
      this.snackbar = true;
    });
    this.$root.$on('loggedIn', () =>{
      this.loggedIn = true
    });
    this.$root.$on('loggedOut', () =>{
      this.loggedIn = false
    });
  }
}
</script>
