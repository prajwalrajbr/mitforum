<template>
    <div v-if="url">
        <div class="pa-9"></div>
        <iframe :src='url' width="100%" :height="height" class="myIframe"></iframe>
    </div> 
</template>

<script>
import user from "../apis/user";
export default {
    data() {
        return {url:null,
            userName: null,
            fileName: '',
            name: '',
            height: '',
            prevRoute: null,
    }},
    methods: {
      showNotes(){
axios.put('/api/get-notes-link',{'id':this.$route.params.id})
        .then((res)=>{          
          this.url = res.data[0].fileLink
        })
        .catch((error) =>{
          console.log(error)
        })
      },
      showAssignmentsQ(){
axios.put('/api/get-assignmentq-link',{'id':this.$route.params.id})
        .then((res)=>{          
          this.url = res.data[0].fileLink
        })
        .catch((error) =>{
          console.log(error)
        })
      },
      showAssignmentsA(){
var id=this.$route.params.id
axios.get('/api/assignmenta')
        .then((res)=>{     
          res.data.forEach((r)=>{
            if(r.id==id)
            this.url = r.fileLink
          })     
          
        })
        .catch((error) =>{
          console.log(error)
        })
      },
      showAnnouncementsAndQueries(){
var id=this.$route.params.id
        axios.get('/api/announcements-and-queries')
                .then((res)=>{
                    res.data.forEach((r)=>{
            if(r.id==id)
            this.url = r.fileLink
          }) 
                })
                .catch((error) =>{
                console.log(error)
                })
      },
      showAssessmentsQ(){
var id=this.$route.params.id
axios.get('/api/assessmentq')
        .then((res)=>{     
          res.data.forEach((r)=>{
            if(r.id==id)
            this.url = r.fileLink
          })     
          
        })
        .catch((error) =>{
          console.log(error)
        })
      },
      showAssessmentsA(){
var id=this.$route.params.id
axios.get('/api/assessmenta')
        .then((res)=>{     
          res.data.forEach((r)=>{
            if(r.id==id)
            this.url = r.fileLink
          })     
          
        })
        .catch((error) =>{
          console.log(error)
        })
      },
    },
    mounted(){this.height= $(window).height()-80
    if(this.$route.params.type=='notes'){
      this.showNotes()
    }else if(this.$route.params.type=='assignments'){
      this.showAssignmentsQ()
    }else if(this.$route.params.type=='assignments-answers'){
      this.showAssignmentsA()
    }else if(this.$route.params.type=='announcements-queries'){
      this.showAnnouncementsAndQueries()
    }else if(this.$route.params.type=='assessments'){
      this.showAssessmentsQ()
    }else if(this.$route.params.type=='assessments-answers'){
      this.showAssessmentsA()
    }
    }
  }

</script>
