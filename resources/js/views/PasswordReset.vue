<template>
    <div class="pa-9">
    </div>
</template>

<script>
export default {
  mounted(){
    this.$root.$emit('showSnackbar', "Password Successfully changed");
    this.$router.push('/')
  }
}
</script>