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
        <div v-if="authenticated() == true">
          <SignInPopup :dialog=dialogA />
        </div>
        <div v-else>
          <v-btn @click='logout'>logout</v-btn>
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
          <div class="pa-3">
            <SignInPopup :dialog=dialogB />
          </div>
        </template>
      </v-navigation-drawer>
      </div>

      <div v-else>
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
            <SignInPopup :dialog=dialogB />
          </div>
        </template>
      </v-navigation-drawer>
      </div>
  
  
    </nav>
    
</template>


<script>
import user from "../apis/user";
import SignInPopup from "./SignInPopup";
import RegisterPopup from "./RegisterPopup";
import ForgotPassword from "./ForgotPassword";
export default{
  components: {
      SignInPopup,
      RegisterPopup,
      ForgotPassword
    },
    data(){
        return{
          bottom: 'null',
          dialogA: true,
          dialogB: false,
            drawer: false,
            items: [
              { title: 'Home', icon: 'home', to:'/' },
              { title: 'About', icon: 'help_center', to:'/about' },
            ]
        }
    },
    computed: {
    },
    methods:{
      logout () {
        user.logout().then(()=>{
          localStorage.removeItem("auth");
          authenticated()
          this.$router.push({ name: "Home" })
        })
      },
      authenticated() {
        user.authenticated()
                .then(() => {
                  console.log('show logout')
                    return true;
                })
                .catch(()=>{
                  console.log('show login')
                    return false;
                })
      }
    },
    mounted(){
      authenticated()
    }
}
</script>

<style>
</style>