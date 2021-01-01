<template>
  <v-container>
    <div class="pa-5"></div>
    <v-layout row wrap align-center>
      <v-flex xs12 sm12 md6 lg6 v-for="item in items" :key="item.name" >
        <v-card elevation="5" class="ma-10 " max-width="800" link :to=item.to>
          <v-img height="300" :src='item.img'></v-img>
          <v-card-title :class='item.color'>{{ item.name }}</v-card-title> 
          <v-card-text :class='item.color'>
          <div></div>
          </v-card-text> 
        </v-card>
      </v-flex>
    </v-layout>
  </v-container> 
</template>

<script>

import user from "../apis/user";

export default {
  data: () => ({
      userName: null,
      items: [
        { name: 'Notes', img: 'https://bit.ly/3nRLZEh', to:'/notes', color:'grey darken-1' },
        { name: 'Assignments', img: 'https://bit.ly/3aH7m7v', to:'/assignments', color:'yellow accent-4' },
        { name: 'Assessments', img: 'https://bit.ly/2M08Jnu', to:'/assessments', color:'light-green darken-3' },
        { name: 'Announcements & Queries', img: 'https://bit.ly/3nTuyTR', to:'/announcements-queries', color:'light-blue darken-3' }
      ],
  }),
  mounted(){
    user.auth()
    .then((res)=>{
        this.userName = res.data.full_name;
    }).catch((err)=>{
      this.$root.$emit('showSnackbar', "Please log-in to continue");
    })
  }
}
</script>