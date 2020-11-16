<template>
  <v-row justify="end">
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="mr-5">
            <span class="grey--text text--darken-4 font-weight-bold">Sign In</span>
            <v-icon right class="font-weight-bold">exit_to_app</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Sign-in</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Email/USN" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password" type="password" required></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <RegisterPopup />
          <div class="d-none d-sm-flex">
            <ForgotPassword/>
          </div>    
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-sm-flex" @click="dialog = false">Sign-in</v-btn>
        </v-card-actions>
        <v-card-actions class="d-flex d-sm-none">
          <ForgotPassword/>
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5" @click="dialog = false">Sign-in</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>


<script>
import ForgotPassword from "./ForgotPassword";
import RegisterPopup from "./RegisterPopup";
export default{
  components: {
      RegisterPopup,
      ForgotPassword
    },
    data: () => ({
      dialog: false
    }),
}
</script>