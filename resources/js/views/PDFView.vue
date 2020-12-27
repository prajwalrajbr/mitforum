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
      }
    },
    mounted(){this.height= $(window).height()-80
    if(this.$route.params.type=='notes'){
      this.showNotes()
    }
           

        
    }
  }

</script>
