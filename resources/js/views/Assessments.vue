<template>
<div>
  <v-card flat>
    <v-container >
      <div class="pa-9"></div>
      <v-card flat tile class="d-flex flex-row-reverse pa-3" app>
        <v-row>
          <v-spacer></v-spacer>
          <v-col class="d-flex" cols="12" sm="2" v-if="is_f">
            <AddAssessment 
            :subjects='subjects' 
            :userId='userId' 
            :userName='userName'
            :is_f='is_f'
            :branch='branch'
            :sem='sem'
            :nowDate='nowDate'
            />
          </v-col>
        </v-row>
      </v-card>
      
        <v-layout row wrap align-center class="grey pa-4" v-if="filteredItems"> 
          <v-flex xs12 v-for="item in filteredItems" class="pa-4" :key="item.id" >
            <v-expansion-panels>
              <v-expansion-panel>
                <v-expansion-panel-header disable-icon-rotate>
                    
                    <v-list-item three-line>
                        <v-list-item-content>
                            <v-list-item-title>Assessment Name : {{item.name}}</v-list-item-title>
                            <v-list-item-subtitle>
                            Created By : {{item.created_by_name}}
                            </v-list-item-subtitle>
                            <v-list-item-subtitle>
                            Sem : {{item.sem}}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-spacer></v-spacer>
                    <v-list-item three-line>
                        <v-list-item-content>
                            <v-list-item-title>Date : {{item.date}}</v-list-item-title>
                            <v-list-item-subtitle>
                            Start time : {{item.startTime}}
                            </v-list-item-subtitle>
                            <v-list-item-subtitle>
                            End time : {{item.endTime}}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item> 

                    <template v-slot:actions v-if="is_f">
                        <v-icon color="primary" v-if="item.assessment == 1">
                        $expand
                        </v-icon>
                        <v-icon color="teal" v-else-if="item.allSubmitted == 'true'">
                        mdi-check
                        </v-icon>
                        <v-icon color="error" v-else>
                        mdi-alert-circle
                        </v-icon>
                    </template>
                    <template v-slot:actions v-else>
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
                            <div class="text-start" v-if="item.assessment == 0">
                              Started
                            <v-btn rounded color="primary" dark @click="toPDFViewPage(item.id)">View Questions</v-btn>
                            </div>
                            <div class="text-start" v-else-if="item.assessment == 1 && is_f">
                              Starts in : {{item.startsin}}
                            <v-btn rounded color="primary" dark @click="toPDFViewPage(item.id)">View Questions</v-btn>
                            </div>
                            <div class="text-start" v-else-if="item.assessment == -1 && is_f">
                              Ended
                            <v-btn rounded color="primary" dark @click="toPDFViewPage(item.id)">View Questions</v-btn>
                            </div>
                            <div class="text-start" v-else-if="item.assessment == -1">
                            Ended
                            <v-btn rounded color="primary" dark @click="toPDFViewPage(item.id)">View Questions</v-btn>
                            </div>
                            <div class="text-start" v-else>
                            Starts in : {{item.startsin}}
                            </div>
                            <v-spacer></v-spacer>  
                            <div v-if="!is_f && item.assessment == 0">
                              <div class="text-end" v-if="item.uploaded == 'true'">
                              <v-btn rounded color="success" dark >Submitted</v-btn>
                              </div>
                              <div class="text-end" v-else>
                              <AddAssessmentAnswer :uploaded_Assessment_id='item.id'/>
                              </div>
                            </div>
                        </v-row>
                        <div v-if="is_f">
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
    <v-btn rounded color="success" dark @click="toPDFViewPageAnswer(u[item.id+'l'])">
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
                        </v-layout></div>
                  </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
            
          </v-flex>
        </v-layout>
        <v-layout v-else>
              <p>Oops! Assessment unavailable....</p> 
        </v-layout>
     



<!-- <div v-for="item in filteredItems" :key="item.id">
<v-card class="grey d-flex" flat tile >
    <v-flex >
      <v-card  elevation="5" class="mx-10 my-5 " max-width="800" >
              <v-card-title>
                <v-btn depresse color="grey lighten-1">
                  {{ item.name }}
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn depressed color="blue lighten-1" @click="toPDFViewPage(item.id)" v-if="item.fileLink">
                  View
                  </v-btn>
                  </v-card-title> 
              <v-card-text>
                <div class="">{{item.created_at}}</div>
              <div>{{item.description}} --{{ item.username }}</div>
              </v-card-text>             
            </v-card>
    </v-flex>
    </v-card>
</div> -->

    </v-container>
    <v-fab-transition >
      <v-btn fab large dark bottom right fixed  @click="showAddAssessmentPopup" :disabled="dialog">
        <v-icon>exit_to_app</v-icon>
      </v-btn>
    </v-fab-transition> 
  </v-card>
  </div>
</template>

<script>

import AddAssessment from "../components/AddAssessment";
import AddAssessmentAnswer from "../components/AddAssessmentAnswer";
import user from "../apis/user";

export default {
  components: {
AddAssessment,AddAssessmentAnswer
  },
  data: () => ({
    userName: '',
    is_f: false,
    branch: null,
    sem: null,
    userId: null,
    subjects: [],
    dialog: false,
    time: null,
    nowDate: new Date().toISOString().slice(0,10),
    items: [],
    users: [],
    assessmenta: []
  }),
  computed: {
    filteredItems () { 
      
      var t = new Date();
      this.time = t.toString().substring(16, 21)
      this.items.forEach(item =>{
        
          item['uploaded'] = 'false';
        this.users.forEach(u=>{
                  if(item.uploaded_by==u.id)
                    item['username']=u.full_name
        })
        this.assessmenta.forEach(r=>{
            if(this.is_f){
                this.users.forEach((u)=>{
                  if(r.uploaded_by==u.id && r.Assessment_id==item.id){
                  item['uploaded']='true';
                  u[item.id]='true'
                  u[item.id+'c']=r.created_at
                  u[item.id+'l']=r.id}
                })
            }
            else{
              if(r.uploaded_by==this.userId && r.Assessment_id==item.id){
            item['uploaded']='true';}
            }
        })
        item['startsin'] = this.timeSub(item.startTime,this.time,item.date,item)
      })
      if(this.is_f){
      for(var i=0;i<this.items.length;i++){
        for(var j=0;j<this.users.length;j++){
          if(!this.users[j].is_faculty)
          if(this.users[j][this.items[i].id] == 'true'){
            this.items[i]['allSubmitted']='true'
          }else{
            this.items[i]['allSubmitted']='false'
            break
          }
        }
      }}
      let fItems = this.items.sort(function(a, b) {
  var keyA = a.id,
    keyB = b.id;
  // Compare the 2 dates
  if (keyA > keyB) return -1;
  if (keyA < keyB) return 1;
  return 0;
});
      if (fItems.length == 0)
        return null;
      return fItems
    },
  },
  methods:{
    toPDFViewPageAnswer(id){
this.$router.push('/pdfview/assessments-answers/'+id)
    },
    toPDFViewPage(id){
      this.$router.push('/pdfview/assessments/'+id)
    },
    timeSub(start,b,date,i){
        let res = ''       
   
    var today = new Date(this.nowDate.substring(0,4), this.nowDate.substring(5,7), this.nowDate.substring(8,10));
    var d = new Date(date.substring(0,4), date.substring(5,7), date.substring(8,10));
    var days = Math.round((d-today)/(1000*60*60*24));
    var startsin = this.diff_time(start,b)
if(days>0){
  i['assessment']=1
      var startsin = this.diff_time(b,start)
      res = String(days)+'Day(s) '+String(startsin.substring(0,2))+' Hour(s) '+String(startsin.substring(3,5))+' Minute(s)';
      return res;
}else if(days==0){
  if((i.startTime) <= (this.time) && (this.time) <= (i.endTime))
            i['assessment']=0
          else if((i.startTime) > (this.time))
            i['assessment']=1
          else
            i['assessment']=-1 
    if(start>b){
      var startsin = this.diff_time(b,start)
      res = String(startsin.substring(0,2))+' Hour(s) '+String(startsin.substring(3,5))+' Minute(s)';
      return res;
    }else{
      return res;
    }
}else{
  
  i['assessment']=-1
    return res;
}

// }


          
    },
    diff_time(start, end) {
start = start.split(":");
end = end.split(":");
var startDate = new Date(0, 0, 0, start[0], start[1], 0);
var endDate = new Date(0, 0, 0, end[0], end[1], 0);
var diff = endDate.getTime() - startDate.getTime();
var hours = Math.floor(diff / 1000 / 60 / 60);
diff -= hours * 1000 * 60 * 60;
var minutes = Math.floor(diff / 1000 / 60);

// If using time pickers with 24 hours format, add the below line get exact hours
if (hours < 0)
   hours = hours + 24;

return (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
},
    showAddAssessmentPopup(){
      this.$root.$emit('showAddAssessmentPopup', "true");
    },
    todo: function(){           
    this.intervalid1 = setInterval(function(){
        
      var t = new Date();
      this.time = t.toString().substring(16, 21)
    }.bind(this), 10000);
}
    
  },
  mounted(){  
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
    axios.get('/api/get-all-users')
    .then((res)=>{
        this.users = res.data
    }).catch((err)=>{
      console.log(error)
    })
    axios.get('/api/assessmentq')
                .then((res)=>{
                    this.items = res.data
                })
                .catch((error) =>{
                console.log(error)
                })
    axios.get('/api/assessmenta')
                .then((res)=>{
                    this.assessmenta = res.data
                })
                .catch((error) =>{
                console.log(error)
                })
        var tzoffset = (new Date()).getTimezoneOffset() * 60000;  
        this.nowDate = (new Date(Date.now() - tzoffset)).toISOString().slice(0, 10);
    // this.refreshAandQ();
    // this.$root.$on('addAandQ', (data) =>{
    //   this.refreshAandQ();
    // });
    this.$root.$on('addAssessment', (data) =>{
      var i = new Object();
      i['date']=data[0].date;
      i['branch']=data[0].branch;
      i['created_at']=data[0].created_at;
      i['created_by_id']=data[0].created_by_id;
      i['created_by_name']=data[0].created_by_name;
      i['endTime']=data[0].endTime;
      i['fileLink']=data[0].fileLink;
      i['fileName']=data[0].fileName;
      i['id']=data[0].id;
      i['is_f']=data[0].is_f;
      i['name']=data[0].name;
      i['sem']=data[0].sem;
      i['startTime']=data[0].startTime;
      i['sub_code']=data[0].sub_code;
      i['subject_id']=data[0].subject_id;
      i['subject_name']=data[0].subject_name;
      i['updated_at']=data[0].updated_at;
      this.items.push(i)
    });
  
  this.$root.$on('AssessmentUploaded', (data) =>{
    this.$router.push('/')
  })
  this.todo()     
  }
}
</script>