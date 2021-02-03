<template>
  <v-row justify="center" block>
    <v-dialog v-model="dialog">
      <template v-slot:activator="{ on, attrs }">
        <div>
          <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog" hidden>
              <span class="grey--text text--darken-4 font-weight-bold">p</span>
          </v-btn>
        </div>
      </template>
    <v-layout row justify-center>
      <v-dialog v-model="loading" persistent fullscreen>
        <v-container fill-height>
          <v-layout row justify-center align-center>
            <v-progress-circular indeterminate :size="90" :width="7" color="primary"></v-progress-circular>
          </v-layout>
        </v-container>
      </v-dialog>
    </v-layout>
    </v-dialog>
  </v-row>
</template>

<script>
export default{
  data: () => ({
    dialog: false,loading: true,
  }),
  mounted(){
    this.$root.$on('showProgressBar', () =>{
      this.dialog = true
      this.loading = true
    });
    this.$root.$on('stopProgressBar', () =>{
      this.dialog = false
      this.loading = false
    });
  }
}
</script>