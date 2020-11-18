<template>
    <div class="pa-9">
        <v-btn @click="a">cl</v-btn>
        <div class="" v-if="user">
            <h3>{{ user.email }}</h3>
        </div>
    </div>
</template>

<script>

import user from "../apis/user";
export default{
    data() {
        return {
            user: null
    }},
    methods:{ 
        
    },
    mounted(){
        user.auth().then((res)=>{
            this.user = res.data;
        })
    }
  }

</script>