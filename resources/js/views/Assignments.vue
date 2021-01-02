<template>
  <v-card flat>
    <v-container>
      <div class="pa-9"></div>
      <v-card flat tile class="d-flex flex-row-reverse pa-3" app>
        <v-row>
          <v-spacer></v-spacer>
          <v-col class="d-flex" cols="12" sm="2" v-if="is_f">
            <AddAssignment :subjects='subjects'/>
          </v-col>
        </v-row>
      </v-card>
      <div v-if="is_f">
        <v-layout row wrap align-center class="grey pa-4" v-if="itemss"> 
          <v-flex xs12 v-for="item in itemss" class="pa-4" :key="item.id" >
            
            <v-expansion-panels>
              <v-expansion-panel>
                <v-expansion-panel-header disable-icon-rotate>
                  <v-list-item three-line>
                        <v-list-item-content>
                            <v-list-item-title>Assignment Name : {{item.name}} [ {{item.sub_code}} ]</v-list-item-title>
                            <v-list-item-subtitle>
                              <div class=""><spam class="font-weight-black">Uploaded on, Date :-</spam> {{item.uploaded_at.substring(0, 10)}} <spam class="font-weight-black"> Time :-</spam> {{item.uploaded_at.substring(11, 19)}}</div>
              </v-list-item-subtitle>
                            <v-list-item-subtitle>
                            Created By : {{item.created_by_name}}, Sem : {{item.sem}}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                  <v-spacer></v-spacer>
                  Last Date : {{item.last_date_time}}  
                  <template v-slot:actions>
                    <v-icon color="primary">
                      $expand
                    </v-icon>
                  </template>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <v-row>

<div class="text-start">
    <v-btn
      rounded
      color="primary"
      dark
      @click="toPDFViewPage(item.id)"
    >
      View Questions
    </v-btn>
  </div>
                    </v-row>
<v-layout row wrap align-center  v-if="users"> 
          <v-flex xs12 v-for="u in users" :key="u.id" >
            <div v-if="u.semester == item.sem && u.branch == item.branch && !u.is_faculty">
                  <v-expansion-panels>
              <v-expansion-panel>
                <div v-if="u[item.id] === 'true'">
<v-expansion-panel-header disable-icon-rotate>
                  {{u.full_name}}[ {{u.usn}} ]
                  <template v-slot:actions>
                    <v-icon color="teal">
                      mdi-check
                    </v-icon>
                  </template>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  Uploaded at :- {{u[item.id+'c']}}
                  <v-spacer></v-spacer>  
  <div class="text-end" >
    <v-btn
      rounded
      color="success"
      dark 
      @click="toPDFViewPageAnswer(u[item.id+'l'])"
    >
      View 
    </v-btn></div>
                  </v-expansion-panel-content>
                </div>
                <div v-else>
                  <v-expansion-panel-header disable-icon-rotate>
                  {{u.full_name}}[ {{u.usn}} ]
                  <template v-slot:actions>
                    <v-icon color="error">
                      mdi-alert-circle
                    </v-icon>
                  </template>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  Not Uploaded...
                  </v-expansion-panel-content>
                </div>
              </v-expansion-panel>
            </v-expansion-panels>

</div>
          </v-flex>
        </v-layout>
                  </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
            
          </v-flex>
        </v-layout>
        <v-layout v-else>
              <p>Oops! Assignments unavailable....</p> 
        </v-layout>
     </div>  
     <div v-else-if="!is_f">
        <v-layout row wrap align-center class="grey pa-4" v-if="computed_id"> 
          <v-flex xs12 v-for="item in computed_id"  :key="item.id" >
            <div v-if="item.sem == sem && item.branch == branch">
            <v-expansion-panels class="pa-4">
              <v-expansion-panel>
                <v-expansion-panel-header disable-icon-rotate>
                  <v-list-item three-line>
                        <v-list-item-content>
                            <v-list-item-title>Assignment Name : {{item.name}} [ {{item.sub_code}} ]</v-list-item-title>
                            <v-list-item-subtitle>
                              <div class=""><spam class="font-weight-black">Uploaded on, Date :-</spam> {{item.uploaded_at.substring(0, 10)}} <spam class="font-weight-black"> Time :-</spam> {{item.uploaded_at.substring(11, 19)}}</div>
              </v-list-item-subtitle>
                            <v-list-item-subtitle>
                            Created By : {{item.created_by_name}}, Sem : {{item.sem}}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-spacer></v-spacer>
                  Last Date : {{item.last_date_time}}  
                  <template v-slot:actions>
                    <v-icon color="teal" v-if="item.uploaded == 'true'">
                      mdi-check
                    </v-icon>
                    <v-icon color="error" v-else>
                      mdi-alert-circle
                    </v-icon>
                  </template>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
<v-row>

<div class="text-start">
    <v-btn
      rounded
      color="primary"
      dark
      @click="toPDFViewPage(item.id)"
    >
      View Questions
    </v-btn>
  </div> <v-spacer></v-spacer>  
  <div class="text-end" v-if="item.uploaded == 'true'">
    <v-btn
      rounded
      color="success"
      dark 
    >
      Submitted
    </v-btn>
  </div>
  <div class="text-end" v-else>
    <AddAssignmentAnswer :uploaded_Assignment_id='item.id'/>
  </div>
                    </v-row>
                  </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
            </div>
          </v-flex>
        </v-layout>
        <v-layout v-else>
              <p>Oops! Assignments unavailable....</p> 
        </v-layout>
     </div> 
    </v-container >
    <v-fab-transition >
      <v-btn fab large dark bottom right fixed  @click="showAddAssignmentPopup" :disabled="dialog">
        <v-icon>add</v-icon>
      </v-btn>
    </v-fab-transition> 
  </v-card>
</template>

<script>

import AddAssignment from "../components/AddAssignment";
import AddAssignmentAnswer from "../components/AddAssignmentAnswer";
import user from "../apis/user";

export default {
  components: {
AddAssignment,
AddAssignmentAnswer
  },
  data: () => ({
    userName: '',
    userId: '',
    sem: null,
    is_f: false,
    dialog: false,
    branch: '',
    items: null,
    itemss: null,
    subjects: [],
    users: [],
    assignmentsa: []
  }),computed: {
    computed_id: function() {
      return this.itemss;
    }
  },
  methods:{
    toPDFViewPageAnswer(id){
this.$router.push('/pdfview/assignments-answers/'+id)
    },
    toPDFViewPage(id){
      this.$router.push('/pdfview/assignments/'+id)
    },
    initializeItems(items){
      this.itemss = items
      this.items = items
    },
    showAddAssignmentPopup(){
      this.$root.$emit('showAddAssignmentPopup', "true");
    },
    addCreatedBy(){
      this.items.forEach((i)=>{
        i['last_date_time'] = i['last_date_time'].substr(0,25)
        axios.put('/api/get-fullname',{'id':i.created_by})
        .then((res)=>{
          i['created_by_name'] = res.data[0].full_name;
        })
        .catch((error) =>{
          console.log(error)
        })
      })
      var len = this.items.length
      this.items.forEach((i)=>{
        i['last_date_time'] = i['last_date_time'].substr(0,25)
        axios.put('/api/get-subject-sem-branch',{'id':i.subject_id})
        .then((res)=>{
          i['sem'] = String(res.data[0].sem);
          i['branch'] = res.data[0].branch;
          i['sub_code'] = res.data[0].sub_code;
          len = len - 1
          if(len == 0 )
            this.refreshAssignmentsUploaded();
        })
        .catch((error) =>{
          console.log(error)
        })
      })
    },
    get_assignments(){
          axios.get('/api/assignmentq')
            .then((res)=>{
              this.items = res.data
              this.addCreatedBy();
            })
            .catch((error) =>{
              console.log(this.errors);
            })
          axios.get('/api/get-all-users')
            .then((res)=>{
              this.users = res.data
            })
            .catch((error) =>{;
              console.log(this.errors);
            })
    },
    refreshAssignmentsUploaded(){
      let len = this.items.length
      var z =  this.items
      axios.get('/api/assignmenta')
        .then((res)=>{
          this.assignmentsa = res.data
      z.forEach((i)=>{   
           
          i['uploaded'] = 'false';
          res.data.forEach((r)=>{
            if(this.is_f){
this.users.forEach((u)=>{
  if(r.uploaded_by==u.id && r.Assignment_id==i.id){
            i['uploaded']='true';
            u[i.id]='true'
            u[i.id+'c']=r.uploaded_at
            
            u[i.id+'l']=r.id}
})           
            }
            else{
              if(r.uploaded_by==this.userId && r.Assignment_id==i.id){
            i['uploaded']='true';}
            }            
          })          
          len = len - 1
          if(len == 0 ){           
            this.initializeItems(z)}
        })
      })
      .catch((error) =>{
          console.log(error)
        })
    }
  },
  mounted(){
    this.get_assignments();
            this.$root.$on('refreshAssignments', () =>{
              this.get_assignments();
            });
    user.auth()
    .then((res)=>{
        this.userName = res.data.full_name;
        this.is_f = res.data.is_faculty;
        this.branch = res.data.branch;
        this.sem = String(res.data.semester)
        this.userId = res.data.id;
        axios.put('/api/get-subjects',{'branch':this.branch})
                .then((res)=>{
                    this.subjects = res.data
                })
                .catch((error) =>{
                console.log(error)
                })
    }).catch((err)=>{
      this.$root.$emit('showSnackbar', "Please log-in to continue");
    })
    this.$root.$on('refreshAssignmentsUploaded', () =>{
      this.refreshAssignmentsUploaded();
    });
  }
}
</script>