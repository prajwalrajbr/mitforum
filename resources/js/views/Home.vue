<template>
  <v-container>
    <div class="pa-5"></div>
    <v-layout row wrap >
      <v-flex xs12 sm12 md6 lg6 v-for="item in items" :key="item.name" >
        <v-card elevation="5" class="ma-10 " max-width="800" link :to=item.to>
          <v-img height="300" src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
          <v-card-title>{{ item.name }}</v-card-title> 
          <v-card-text>
          <div>Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.</div>
          </v-card-text> 
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      items: [
        { name: 'Notes', img: 'https://bit.ly/3pdRYV0', to:'/notes' },
        { name: 'Assignments', img: 'Graphic designer', to:'/assignments' },
        { name: 'Assessments', img: 'Web developer', to:'/assessments' },
        { name: 'Announcements & Queries', img: 'Social media maverick', to:'/announcements-queries' }
      ]
    }
  }
}
</script>