<template>
    <div class="pa-9">
    </div>
</template>

<script>
export default {
  mounted(){
    this.$root.$emit('showSnackbar', "E-Mail Successfully Verified");
    this.$router.push('/')
  }
}
</script>