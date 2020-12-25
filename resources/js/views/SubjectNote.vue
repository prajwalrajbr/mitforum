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
      
        <v-layout row wrap align-center class="grey" v-if="items"> 
          <v-flex xs12 sm12 md12 lg12 v-for="item in items" :key="item.id" >
            <v-card elevation="5" class="mx-10 my-5 mb-3 " max-width="1100" link :to="toPDFViewPage(item.id)">
              <v-card-title>{{ item.name }}</v-card-title> 
              <v-card-text>
              <div>ssssssssssssssss{{ item.uploaded_by_name }}</div>
              </v-card-text>             
            </v-card>
          </v-flex>
        </v-layout>
        <v-layout v-else>
              <p>Oops! Notes unavailable....</p> 
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
      console.log(this.items)
      let fItems = this.items
      if (fItems.length == 0)
        return null;
      return fItems
    },
  },
  methods:{
    toPDFViewPage(id){
      return "/pdfview/"+id
    },
    showAddNotesPopup(){
      this.$root.$emit('showAddNotesPopup', "true");
    },
    add_uploaded_subject_id(){
      let branchUpdated = this.$route.params.branch.replace(/\-/g,' ')
      let sub_codeUpdated = this.$route.params.sub_code.replace(/\-/g,' ')
      axios.put('/api/get-uploaded-subject-id',{'sem':this.$route.params.sem, 'branch':branchUpdated, 'sub_code':sub_codeUpdated})
        .then((res)=>{
          this.uploaded_subject_id = res.data[0].id;
          this.get_notes();
        })
        .catch((error) =>{
          console.log(error)
        })
    },
    initializeItems(items){
      this.items = items
    },
    get_notes(){
      axios.put('/api/get-notes',{'uploaded_subject_id':this.uploaded_subject_id})
        .then((res)=>{
          console.log(res)
          var items = res.data
          var len = items.length
          console.log(len) 
          items.forEach((i)=>{
            axios.put('/api/get-fullname',{'id':i.uploaded_by})
            .then((res)=>{
              i['uploaded_by_name'] = res.data[0].full_name;
              len = len - 1
              if(len == 0 )
                this.initializeItems(items)
            })
            .catch((error) =>{
              console.log(error)
            })
          })
        })
        .catch((error) =>{
          console.log(error)
        })
    }
  },
  mounted(){
    this.add_uploaded_subject_id();
  }
}
</script>