<template>
  <v-row justify="center" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <div v-if="loggedIn">
          <v-btn class="white mr-5" @click='logout'>
              <span class="grey--text text--darken-4 font-weight-bold">logout</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
          </v-btn>
        </div>
        <div v-else>
          <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog">
              <span class="grey--text text--darken-4 font-weight-bold">Sign In</span>
              <v-icon right class="black--text font-weight-bold">exit_to_app</v-icon>
          </v-btn>
        </div>
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
          <RegisterPopup/>
          <div class="d-none d-sm-flex">
            <ForgotPassword/>
          </div>    
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-sm-flex" @click.prevent="submit">Sign-in</v-btn>
        </v-card-actions>
        <v-card-actions class="d-flex d-sm-none">
          <ForgotPassword/>
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5" @click.prevent="submit">Sign-in</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

import ForgotPassword from "./ForgotPassword";
import RegisterPopup from "./RegisterPopup";

import user from "../apis/user";

import { validationMixin } from 'vuelidate'
import { required, maxLength, minLength} from 'vuelidate/lib/validators'

export default{
  mixins: [validationMixin],
  validations: {
    form: { 
      email: { required, minLength: minLength(5), maxLength: maxLength(40) },
      password: { required, minLength: minLength(8), maxLength: maxLength(20) },
    }
  },
  components: {
    RegisterPopup,
    ForgotPassword
  },
  data: () => ({
    dialog: false,
    userName: null,
    loggedIn: false,
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
      !this.$v.form.email.maxLength && errors.push('Email/USN must be at most 40 characters long')
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
    resetForm () {
      this.formHasErrors = false
      this.$v.$reset();
      var self = this;
      Object.keys(this.form).forEach(function(key,index) {
        if(typeof self.form[key] === "string") 
          self.form[key] = ''; 
        else if (typeof self.form[key] === "boolean") 
          self.form[key] = false;
      });
    },
    submit () {
      this.$v.$touch()
      this.formTouched = !this.$v.form.$anyDirty;
      this.errors = this.$v.form.$anyError;
      if (this.errors === false && this.formTouched === false) {
      user.login(this.form)
      .then(()=>{
        this.dialog = false
        localStorage.setItem("auth","true");
        this.loggedIn = true
        this.$root.$emit('loggedIn', "true");
        this.updateUserData();
        this.resetForm();
        this.$root.$emit('showSnackbar', "Successfully logged in");
      })
      .catch((error) =>{
        this.$root.$emit('showSnackbar', "Incorrect Username or Password");
        console.log(error);
      })}
    },
    logout () {
        user.logout().then(()=>{
          localStorage.removeItem("auth");
          this.loggedIn = false
          this.$root.$emit('loggedOut', "true");
          this.userName = "";
          this.$root.$emit('userName', this.userName);
          this.$root.$emit('showSnackbar', "Successfully logged out");
        })
      },
    updateUserData () {
      user.auth()
      .then((res)=>{
        this.userName = res.data.full_name;
        this.$root.$emit('userName', this.userName);
        this.loggedIn = true;
        this.$root.$emit('loggedIn', "true");
      })
      .catch((error) =>{
        this.userName = "";
        this.$root.$emit('showLogInPopup', "true");
        this.$root.$emit('userName', this.userName);
        this.loggedIn = false;
      })
    }
  },
  mounted(){
    this.updateUserData();
    this.$root.$on('loggedIn', () =>{
      this.loggedIn = true
    });
    this.$root.$on('loggedOut', () =>{
      this.loggedIn = false
    });
    this.$root.$on('showLogInPopup', () =>{
      this.dialog = true
    });
  }
}
</script>