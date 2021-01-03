<template>
<div>
  <v-card flat>
    <v-container >
      <div class="pa-9"></div>
      <v-card flat tile class="d-flex flex-row-reverse pa-3" app>
        <v-row>
          <v-spacer></v-spacer>
          <v-col class="d-flex" cols="12" sm="2">
            <AddAandQ/>
          </v-col>
        </v-row>
      </v-card>
      
            
<div 
      v-for="item in filteredItems" :key="item.id">
<v-card
      :class="check(item.is_f)"
      flat
      tile
      v-if="item.branch == branch"
    >
    <v-flex xs8 >
      <v-card  elevation="5" class="mx-10 my-5 " max-width="800" >
              <v-card-title>
                <v-btn depresse color="grey lighten-1">
                  {{ item.name }}
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn depressed color="blue lighten-1" @click="toPDFViewPage(item.id)" v-if="item.fileLink">
                  View File
                  </v-btn>
                  </v-card-title> 
              <v-card-text>
                <div class=""><spam class="font-weight-black">Date :-</spam> {{item.uploaded_at.substring(0, 10)}} <spam class="font-weight-black"> Time :-</spam> {{item.uploaded_at.substring(11, 19)}}</div>
              <div>{{item.description}}</div>
              <div class="d-flex flex-row-reverse font-weight-black">~{{ item.username }}</div>
              </v-card-text>             
            </v-card>
    </v-flex>
    </v-card>
</div>
    </v-container>
    <v-fab-transition >
      <v-btn fab large dark bottom right fixed  @click="showAddAandQPopup" :disabled="dialog">
        <v-icon>add</v-icon>
      </v-btn>
    </v-fab-transition> 
  </v-card>
  </div>
</template>

<script>

import AddAandQ from "../components/AddAandQ";
import user from "../apis/user";

export default {
  components: {
AddAandQ
  },
  data: () => ({
    userName: '',
    is_f: false,
    dialog: false,
    items: [],
    branch: '',
    users: [],
    classname: 'grey d-flex justify-end mb-6',
  }),
  computed: {
    filteredItems () { 
      let fItems = this.items
      fItems.forEach(item =>{
          this.users.forEach(user =>{
              if(item.uploaded_by==user.id)
              item['username']=user.full_name
              item['branch']=user.branch
          })
      })
      if (fItems.length == 0)
        return null;
      return fItems
    },
  },
  methods:{
    check(is_f){
      if(!is_f)
      return 'grey d-flex flex-row-reverse'
      else
      return 'grey d-flex'
    },
    toPDFViewPage(id){
      
this.$router.push('/pdfview/announcements-queries/'+id)
    },
    showAddAandQPopup(){
      this.$root.$emit('showAddAandQPopup', "true");
    },
    refreshAandQ(){
axios.get('/api/announcements-and-queries')
                .then((res)=>{
                    this.items = res.data
                })
                .catch((error) =>{
                console.log(error)
                })
    },
    todo: function(){           
    this.interval = setInterval(function(){
        this.refreshAandQ()
    }.bind(this), 3000);
}
    
  },
  mounted(){  
    axios.get('/api/get-all-users')
    .then((res)=>{
        this.users = res.data
    }).catch((err)=>{
      console.log(error)
    })
    user.auth()
    .then((res)=>{
        this.userName = res.data.full_name;
        this.is_f = res.data.is_faculty;
        this.branch = res.data.branch;
    }).catch((err)=>{
      this.$root.$emit('showSnackbar', "Please log-in to continue");
    })
    this.refreshAandQ();
    this.$root.$on('addAandQ', (data) =>{
      this.refreshAandQ();
    });
    
  this.todo()   
  },
  beforeDestroy () {
       clearInterval(this.interval)
    },
  
}
</script>