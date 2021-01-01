<template>
  <v-card flat>
    <v-container >
      <div class="pa-9"></div>
      <v-card flat tile class="d-flex flex-row-reverse pa-3" app>
        <v-row>
          <v-col class="d-flex" cols="12" sm="8">
            <div class="headline" v-if="subject_name">{{subject_name}} [ {{sub_code}} ]</div>
          </v-col>
          <v-spacer></v-spacer>
          <v-col class="d-flex" cols="12" sm="4" v-if="is_f">            
            <AddNotes :uploaded_subject_id='this.$route.params.id' />
          </v-col>
        </v-row>
      </v-card>
      
        <v-layout row wrap align-center class="grey" v-if="items"> 
          <v-flex xs12 sm12 md12 lg12 v-for="item in items" :key="item.id" >
            <v-card elevation="5" class="mx-10 my-5 mb-3 " max-width="1100" link :to="toPDFViewPage(item.id)">
              <v-card-title>{{ item.name }}</v-card-title> 
              <v-card-text>
              <div>Uploaded By :- {{ item.created_by_name }}</div>
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
        <v-icon large>add</v-icon>
      </v-btn>
    </v-fab-transition> 
  </v-card> 
</template>

<script>

import AddNotes from "../components/AddNotes";
import user from "../apis/user";

export default {
  components:{
AddNotes
  },
  data: () => ({
      dialog: false,
      is_f: false,
      users: [],
      sub_code: null,
      subject_name: null,
      users: [],
    items: []
  }),
  methods:{
    toPDFViewPage(id){
      return "/pdfview/notes/"+id
    },
    showAddNotesPopup(){
      this.$root.$emit('showAddNotesPopup', "true");
    },
    initializeItems(items){
      this.items = items
    },
    get_notes(){
      axios.put('/api/get-notes',{'uploaded_subject_id':this.$route.params.id})
        .then((res)=>{
          var items = res.data
          var len = items.length
          items.forEach((i)=>{
            for(var j=0;j<this.users.length;j++){
          if(this.users[j].id == i.uploaded_by){
            i['created_by_name'] = this.users[j].full_name;
            break;
          }
        }
                
            })
            this.initializeItems(items)
          })
        .catch((error) =>{
          console.log(error)
        })
    }
  },
  mounted(){
    axios.get('/api/get-all-users')
    .then((res)=>{
      this.users = res.data
      this.get_notes();
    })
    .catch((error) =>{
        console.log(error)
      })
    this.$root.$on('refreshNotes', () =>{
              this.get_notes();
            });
    user.auth()
    .then((res)=>{
        this.is_f = res.data.is_faculty;
    }).catch((err)=>{
      this.$root.$emit('showSnackbar', "Please log-in to continue");
    })
    axios.put('/api/get-subject-sem-branch',{'id':this.$route.params.id})
        .then((res)=>{
          this.subject_name = res.data[0].subject_name
          this.sub_code = res.data[0].sub_code
        })
        .catch((error) =>{
          console.log(error)
        })
        
              
  }
}
</script>