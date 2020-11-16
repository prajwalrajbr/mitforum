<template>
  <v-row justify="start">
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="info darken-1" class="ma-5 d-none d-sm-flex" text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold d-none d-sm-flex">F</div><div class="text-lowercase font-weight-bold d-none d-sm-flex">orgot password?</div></v-btn>
        <v-btn color="info darken-1" class="ma-5 d-flex d-sm-none" text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold d-flex d-sm-none">F</div><div class="text-lowercase font-weight-bold d-flex d-sm-none">orgot password</div></v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Reset password</span>
        </v-card-title>
        <v-card-text>
          <form>
            <v-text-field v-model="name" :error-messages="nameErrors" :counter="10" label="Name" required @input="$v.name.$touch()" @blur="$v.name.$touch()"></v-text-field>
            <v-btn class="mr-4" @click="submit">Submit</v-btn>
            <v-btn @click="clear">Clear</v-btn>
          </form>
        </v-card-text>
        <v-card-actions >
            <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5" @click="dialog = false">Submit</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>


<script>
import { validationMixin } from 'vuelidate'
import { required, maxLength, email } from 'vuelidate/lib/validators'
export default{
  data: () => ({
    dialog: false
  }),
  
}
</script>