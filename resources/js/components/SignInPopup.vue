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
          <v-form>
            <v-text-field v-model="form.email" :error-messages="emailErrors" label="Email/USN" required @input="$v.form.email.$touch()" @blur="$v.form.email.$touch()"></v-text-field>
            <v-text-field v-model="form.password" :append-icon="form.show ? 'visibility' : 'visibility_off'" :error-messages="passwordErrors" :type="form.show ? 'text' : 'password'" label="Password" required counter @input="$v.form.password.$touch()" @blur="$v.form.password.$touch()" @click:append="form.show = !form.show"></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <RegisterPopup />
          <div class="d-none d-sm-flex">
          <ForgotPassword/>
          </div>    
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-sm-flex" @click="submit">Sign-in</v-btn>
        </v-card-actions>
        <v-card-actions class="d-flex d-sm-none">
          <ForgotPassword/>
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5" @click="submit">Sign-in</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>


<script>
import ForgotPassword from "./ForgotPassword";
import RegisterPopup from "./RegisterPopup";

import { validationMixin } from 'vuelidate'
import { required, maxLength, minLength} from 'vuelidate/lib/validators'
export default{
  mixins: [validationMixin],
  validations: {
    form: { 
      email: { required, minLength: minLength(5), maxLength: maxLength(20) },
      password: { required, minLength: minLength(8), maxLength: maxLength(20) },
    }
  },
  components: {
    RegisterPopup,
    ForgotPassword
  },
  data: () => ({
    dialog: false,
    form:{ 
      email: '',
      password: '',
      show: false,
    },     
  }),
  computed: {
    emailErrors () {
      const errors = []
      if (!this.$v.form.email.$dirty) return errors
      !this.$v.form.email.maxLength && errors.push('Email/USN must be at most 20 characters long')
      !this.$v.form.email.minLength && errors.push('Email/USN must be at least 5 characters')
      !this.$v.form.email.required && errors.push('Email/USN is required.')
      return errors
    },
    passwordErrors () {
      const errors = []
      if (!this.$v.form.password.$dirty) return errors
      !this.$v.form.password.maxLength && errors.push('Password must be at most 20 characters long')
      !this.$v.form.password.minLength && errors.push('Password must be at least 8 characters')
      !this.$v.form.password.required && errors.push('Password is required.')
      return errors
    },
  },
  methods: {
    submit () {
      this.dialog = false
      this.$v.$touch()
    },
  },
}
</script>