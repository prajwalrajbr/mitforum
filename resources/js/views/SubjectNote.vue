<template>
  <v-container>
    <div class="pa-5"></div>
    <v-layout row wrap align-center>
      {{$route.params.sem}}
      {{$route.params.sub_code}}
      {{$route.params.branch}}
    </v-layout>
  </v-container> 
</template>

<script>

export default {
  data: () => ({
      
  }),
  mounted(){
    
  }
}
</script>