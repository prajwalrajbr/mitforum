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
        return {url:'https://drive.google.com/file/d/1vFGkQRMxtHvh_8KQtpjTe5BOvixz5X6O/preview',
            userName: null,
            fileName: '',
            name: '',

    }},
    mounted(){


      
        $('.myIframe').css('height', $(window).height()+'px');
        axios.put('/api/get-notes-name',{'id':this.$route.params.id})
        .then((res)=>{
          this.fileName = res.data[0].fileName
          var filename = String(this.fileName).substring(0, String(this.fileName).indexOf('.'))           
          this.url = 'https://drive.google.com/uc?id=14fE5tpCL2n9Ssm3rAWRazw5_ple3aka2&export=media'
          console.log(this.url)
          this.name = res.data[0].name
        })
        .catch((error) =>{
          console.log(error)
        })
  user.getFile()
          .then((res)=>{
            console.log(res);
          })
          .catch((error) =>{
          console.log(error)
        })


    }
  }

</script>
