<template>
    <nav>
      <v-toolbar app color="blue">

          <v-app-bar-nav-icon @click.stop="drawer = !drawer">
              <v-icon class="black--text">menu</v-icon>
          </v-app-bar-nav-icon>

          <v-toolbar-title class="black--text" style="font-size: 0">
                  <span class="font-weight-medium text-h6">MIT</span>
                  <span class="font-weight-bold text-h6">Forum</span>
          </v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn>
              <span class="grey--text text--darken-4 font-weight-bold">Sign Out</span>
              <v-icon right class="font-weight-bold">exit_to_app</v-icon>
          </v-btn>

      </v-toolbar>

      <v-navigation-drawer v-model="drawer" absolute bottom temporary dark>
        <v-list nav dense>

          <v-list-item-group v-model="group" active-class="light-blue--text text--accent-4">       
            <v-list-item v-for="item in items" :key="item.title" link :to=item.to>         
                <v-list-item-content>
                  <v-list-item-title class="font-weight-medium text-h6 ">
                    <v-icon class="pb-1 px-2">{{ item.icon }}</v-icon>
                    {{ item.title }}
                  </v-list-item-title>    
                </v-list-item-content>    
            </v-list-item>      
          </v-list-item-group>
          
        </v-list>

        <template v-slot:append>
        <div class="pa-3">
          <v-btn block class="white" v-bind:color="type==='guest' ? 'white' : 'grey'">
            <span class="black--text font-weight-bold">Sign Out</span>
            <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
          </v-btn>
        </div>
      </template>
      </v-navigation-drawer>

    </nav>
</template>


<script>
export default{
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