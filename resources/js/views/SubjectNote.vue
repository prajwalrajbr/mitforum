<template>
  <v-card flat>
    <v-container >
      <div class="pa-9"></div>
      <v-card flat tile class="d-flex flex-row-reverse pa-3" app>
        <v-row>
          <v-spacer></v-spacer>
          <v-col class="d-flex" cols="12" sm="2">
              
            <AddNotes :uploaded_subject_id='uploaded_subject_id' />
          </v-col>
        </v-row>
      </v-card>
      
        <v-layout row wrap align-center class="grey" v-if="filteredItems"> 
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
        </v-layout>
        
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
      uploaded_subject_id:'',
    items: []
  }),
  computed:{
    filteredItems () {
      // const sem= this.semester 
      // const branch= this.branch 
      // let fItems = this.items.filter(function(i){
      //   return i.sem == sem && i.branch == branch;
      // })
      // if (fItems.length == 0)
      //   return null;
      return null
    },
  },
  methods:{
    showAddNotesPopup(){
      this.$root.$emit('showAddNotesPopup', "true");
    },
    add_uploaded_subject_id(){
      let branchUpdated = this.$route.params.branch.replace(/\-/g,' ')
      let sub_codeUpdated = this.$route.params.sub_code.replace(/\-/g,' ')
      axios.put('/api/get-uploaded-subject-id',{'sem':this.$route.params.sem, 'branch':branchUpdated, 'sub_code':sub_codeUpdated})
        .then((res)=>{
          this.uploaded_subject_id = res.data[0].id;
        })
        .catch((error) =>{
          console.log(error)
        })
    },
  },
  mounted(){
    this.add_uploaded_subject_id();
  }
}
</script>