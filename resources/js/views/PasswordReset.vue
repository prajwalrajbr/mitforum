<template>
    <div class="pa-9">
    </div>
</template>

<script>
import user from "../apis/user";
export default {
  mounted(){
    this.$root.$emit('showSnackbar', "Password Successfully changed");
    user.logout().then(()=>{
          this.loggedIn = false
          this.$root.$emit('loggedOut', "true");
          this.$root.$emit('userName', null);
          this.$root.$emit('showLogInPopup', "true");
        })
    this.$router.push('/')
  }
}
</script>