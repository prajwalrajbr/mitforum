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
          <v-col class="d-flex" cols="12" sm="2" v-if="is_f">
            <AddNoteSubject/>
          </v-col>
        </v-row>
      </v-card>
      
        <v-layout row wrap align-center class="grey" v-if="filteredItems"> 
          <v-flex xs12 sm6 md4 lg4 v-for="item in filteredItems" :key="item.id" >
            <v-card elevation="5" class="ma-10 " max-width="800" link :to="toSubPage(item.id)">
              <v-card-title>{{ item.sub_code }}</v-card-title> 
              <v-card-text>
              <div>{{ item.subject_name }}</div>
              <div>Created by :- {{ item.created_by_name }}</div>
              </v-card-text>             
            </v-card>
          </v-flex>
        </v-layout>
        <v-layout v-else>
              <p>Oops! Subjects unavailable....</p> 
        </v-layout>
        
    </v-container>
    <v-fab-transition v-if="is_f">
      <v-btn fab large dark bottom right fixed  @click="showCreateSubjectPopup" :disabled="dialog">
        <v-icon large>add</v-icon>
      </v-btn>
    </v-fab-transition> 
  </v-card>
</template>

<script>

import AddNoteSubject from "../components/AddNoteSubject";
import user from "../apis/user";

export default {
  components: {
AddNoteSubject
  },
  data: () => ({
    userName: '',
    userID: null,
    is_f: false,
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
    items: [],
    users: [],
  }),
  computed: {
    filteredItems () {
      const sem= this.semester 
      const branch= this.branch 
      let i = this.items.filter(function(i){
        return i.sem == sem && i.branch == branch;
      })
      if(i.length==0)
      return null
      return i
    },
  },
  methods:{
    toSubPage(id){
      return "/note/"+id
    },
    showCreateSubjectPopup(){
      this.$root.$emit('showCreateSubjectPopup', "true");
    },
    addCreatedBy(){
      this.items.forEach((i)=>{
        for(var j=0;j<this.users.length;j++){
          if(this.users[j].id == i.created_by){
i['created_by_name'] = this.users[j].full_name;
break;
          }
        }
      })
    }
  },
  mounted(){
  axios.get('/api/get-all-users')
    .then((res)=>{
      this.users = res.data
    })
    .catch((error) =>{
        console.log(error)
      })
    axios.get('/api/subject')
    .then((res)=>{
      this.items = res.data
      this.addCreatedBy();
    })
    .catch((error) =>{
        console.log(error)
      })
    user.auth()
    .then((res)=>{
        this.userName = res.data.full_name;
        this.userID = res.data.id;
        this.is_f = res.data.is_faculty;
    }).catch((err)=>{
      this.$root.$emit('showSnackbar', "Please log-in to continue");
    })
    this.$root.$on('addSubject', (data) =>{
      var i = new Object();
      i['branch']=data[0].branch;
      i['created_by']=this.userID;
      i['created_by_name']=this.userName;
      i['sub_code']=data[0].sub_code;
      i['subject_name']=data[0].subject_name;
      i['sem']=data[0].sem;
      i['id']=data[0].id
      this.items.push(i)
    });
  }
}
</script>