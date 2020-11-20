<template>
    <div class="pa-9">
        <v-btn @click="mounted">cl</v-btn>
        <div class="" v-if="userName">
            <h3>{{ userName }}</h3>
        </div>
    </div>
</template>

<script>
export default{
    data() {
        return {
            userName: 'gg'
    }},
  }
</script>  