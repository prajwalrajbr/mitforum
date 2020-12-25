<template>
    <div class="">
        <div class="pa-9"></div>
        <iframe :src=url width="100%" class="myIframe"></iframe>
    </div> 
</template>

<script>
import user from "../apis/user";
export default {
    data() {
        return {url:'',
            userName: null,
            fileName: '',
            name: '',

    }},
    mounted(){


      
        $('.myIframe').css('height', $(window).height()+'px');
        axios.put('/api/get-notes-link',{'id':this.$route.params.id})
        .then((res)=>{          
          this.url = res.data[0].fileLink
        })
        .catch((error) =>{
          console.log(error)
        })


    }
  }

</script>
