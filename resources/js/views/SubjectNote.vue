<template>
  <v-card flat>
    <v-container >
      <div class="pa-9"></div>
      <v-card flat tile class="d-flex flex-row-reverse pa-3" app>
        <v-row>
          <v-col class="d-flex" cols="12" sm="3">
            <v-select v-model="semester" :items="semesterItems" label="Semester" outlined @change="sortBySemester"></v-select>
          </v-col>
          <v-col class="d-flex" cols="12" sm="4">
            <v-select v-model="branch" :items="branchItems" label="Branch" outlined @change="sortByBranch"></v-select>
          </v-col>
          <v-spacer></v-spacer>
          <v-col class="d-flex" cols="12" sm="2">
            <AddNotes/>
          </v-col>
        </v-row>
      </v-card>
      
        <!-- <v-layout row wrap align-center class="grey" v-if="filteredItems"> 
          <v-flex xs12 sm6 md4 lg4 v-for="item in filteredItems" :key="item.sub_code" >
            <v-card elevation="5" class="ma-10 " max-width="800" link :to="toSubPage(item.branch, item.sem, item.sub_code)">
              <v-card-title>{{ item.sub_code }}</v-card-title> 
              <v-card-text>
              <div>Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.</div>
              </v-card-text>             
            </v-card>
          </v-flex>
        </v-layout>
        <v-layout v-else>
              <p>Oops! Subjects unavailable....</p> 
        </v-layout> -->
        
    </v-container>
    <v-fab-transition >
      <v-btn fab large dark bottom right fixed  @click="showAddNotesPopup" :disabled="dialog">
        <v-icon>exit_to_app</v-icon>
      </v-btn>
    </v-fab-transition> 
  </v-card> 
</template>

<script>

import AddNotes from "../components/AddNotes";

export default {
  components:{
AddNotes
  },
  data: () => ({
      dialog: false,
    semester: '',
    semesterItems: [
        '1','2','3','4','5','6','7','8'
      ],
      branch: '',
    branchItems: [
        'Computer Science', 
        'Information Science', 
        'Eletronics and Communication', 
        'Civil', 
        'Mechanical'
      ],
    items: []
  }),
  methods:{
    showAddNotesPopup(){
      this.$root.$emit('showAddNotesPopup', "true");
    },
  },
  mounted(){
    
  }
}
</script>