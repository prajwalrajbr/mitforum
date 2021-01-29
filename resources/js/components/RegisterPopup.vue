<template>
  <v-row justify="start">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="info darken-1" class="ma-5 " :disabled="dialog" text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold ">C</div><div class="text-lowercase font-weight-bold ">reate account</div></v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Create account</span>
        </v-card-title>
        <v-card-text>     
          <v-row>
            <v-col cols="12" sm="6" md="6" >
              <v-text-field v-model="form.full_name" :error-messages="full_nameErrors" label="Full Name*" required @input="$v.form.full_name.$touch()" @blur="$v.form.full_name.$touch()"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6" >
              <v-text-field v-model="form.usn" :error-messages="usnErrors" label="USN/FID*" counter="10" required @input="$v.form.usn.$touch()" @blur="$v.form.usn.$touch()"></v-text-field>
            </v-col>
            
            <v-col cols="12" sm="6" md="6" >
              <v-text-field v-model="form.email" :error-messages="emailErrors" label="Email*" required @input="$v.form.email.$touch()" @blur="$v.form.email.$touch()"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6" >  
              <v-autocomplete v-model="form.branch" :items="form.branchItems" :error-messages="branchErrors" label="Branch*" required @change="$v.form.branch.$touch()" @blur="$v.form.branch.$touch()"></v-autocomplete>  
            </v-col>

            <v-col cols="8" sm="6" md="6" >  
              <v-select v-model="form.semester" :items="form.semesterItems" :error-messages="semesterErrors" label="Semester*" required @change="$v.form.semester.$touch()" @blur="$v.form.semester.$touch()"></v-select>
            </v-col>
            <v-col cols="4" sm="6" md="6" >  
              <v-checkbox v-model="form.is_faculty" :error-messages="is_facultyErrors" label="Faculty" @change="$v.form.is_faculty.$touch()" @blur="$v.form.is_faculty.$touch()"></v-checkbox>
            </v-col>

            <v-col cols="12" sm="6" md="6" >  
              <v-text-field v-model="form.password" :append-icon="form.show1 ? 'visibility' : 'visibility_off'" :error-messages="passwordErrors" :type="form.show1 ? 'text' : 'password'" label="Password*" required counter @input="$v.form.password.$touch()" @blur="$v.form.password.$touch()" @click:append="form.show1 = !form.show1"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6" >  
              <v-text-field v-model="form.repeatPassword" :append-icon="form.show2 ? 'visibility' : 'visibility_off'" :error-messages="repeatPasswordErrors" :type="form.show2 ? 'text' : 'password'" label="Confirm Password*" required counter @input="$v.form.repeatPassword.$touch()" @blur="$v.form.repeatPassword.$touch()" @click:append="form.show2 = !form.show2"></v-text-field>
            </v-col>
          </v-row>
          <v-divider class="mt-1"></v-divider>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-btn class="font-weight-bold" @click="cancelForm" text>Cancel</v-btn>
          <v-spacer></v-spacer>
          <v-slide-x-reverse-transition>
            <v-tooltip v-if="formHasErrors" left>
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon class="my-0" v-bind="attrs" @click.prevent="resetForm" v-on="on">
                  <v-icon>mdi-refresh</v-icon>
                </v-btn>
              </template>
              <span>Refresh form</span>
            </v-tooltip>
          </v-slide-x-reverse-transition>
          <v-btn color="primary" text @click.prevent="submitForm">Submit</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

import user from "../apis/user";

import { validationMixin } from 'vuelidate'
import { required, maxLength, minLength, email, sameAs } from 'vuelidate/lib/validators'

export default{
  mixins: [validationMixin],
  validations: {
    form: {
      full_name: { required, minLength: minLength(1), maxLength: maxLength(20) },
      usn: { required, minLength: minLength(10), maxLength: maxLength(10) },
      email : { required, email },
      password: { required, minLength: minLength(8), maxLength: maxLength(20) },
      repeatPassword: { required, sameAsPassword: sameAs('password') },
      semester: { required },
      branch: { required },
    }
  },
  data: () => ({
    dialog: false,
    existingEmailAndUSN: [],
    facultyList: [],
    form:{ 
      full_name: '',
      usn: '',
      email: '',
      emailTaken: false,
      password: '',
      show1: false,
      repeatPassword: '',
      show2: false,
      semester: '',
      semesterItems: [
        '1','2','3','4','5','6','7','8'
      ],
      branch: '',
      branchItems: [
        'Computer Science', 
        'Information Science', 
        'Eletronics and Communication', 
        'Civil', 
        'Mechanical'
      ],
      is_faculty: false,
    },   
    formHasErrors: false,
  }),
  computed: {
    full_nameErrors () {
      const errors = []
      if (!this.$v.form.full_name.$dirty) return errors
      !this.$v.form.full_name.maxLength && errors.push('This field must be at most 20 characters long')
      !this.$v.form.full_name.minLength && errors.push('This field must be at least 5 characters')
      !this.$v.form.full_name.required && errors.push('This field is required.')
      return errors
    },
    usnErrors () {
      const errors = []
      if (!this.$v.form.usn.$dirty) return errors
      !this.$v.form.usn.maxLength && errors.push('This field must be 10 characters long')
      !this.$v.form.usn.minLength && errors.push('This field must be 10 characters long')
      !this.$v.form.usn.required && errors.push('This field is required.')
      this.existingEmailAndUSN.forEach((usn)=>{
        if (usn['usn'] === this.form.usn){
          errors.push('A user with this USN already exists.')
        }
      })
      return errors
    },
    emailErrors () {
        const errors = []
        if (!this.$v.form.email.$dirty) return errors
        !this.$v.form.email.email && errors.push('Must be valid e-mail')
        !this.$v.form.email.required && errors.push('E-mail is required')
        this.existingEmailAndUSN.forEach((email)=>{
          if (email['email'] === this.form.email){
            errors.push('A user with this Email already exists.')
          }
        })
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
    repeatPasswordErrors () {
      const errors = []
      if (!this.$v.form.repeatPassword.$dirty) return errors
      !this.$v.form.repeatPassword.sameAsPassword && errors.push('Passwords must be identical.')
      !this.$v.form.password.required && errors.push('This field is required.')
      return errors
    },
    semesterErrors () {
      const errors = []
      if (!this.$v.form.semester.$dirty) return errors
      !this.$v.form.semester.required && errors.push('This field is required')
      return errors
    },
    branchErrors () {
      const errors = []
      if (!this.$v.form.branch.$dirty) return errors
      !this.$v.form.branch.required && errors.push('This field is required')
      return errors
    },
  },
  methods: {
    cancelForm() {
      this.dialog = false
      this.resetForm()
    },
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
    submitForm () {
      this.$v.$touch()
      this.formTouched = !this.$v.form.$anyDirty;
      this.errors = this.$v.form.$anyError;
      if (this.errors === false && this.formTouched === false) {
        var matches=false
        this.facultyList.forEach(f=>{
          if(this.form.usn == f.FID && this.form.email == f.email)
          matches = true
        })
        if(!this.form.is_faculty)
        matches=true
        if(matches === true){
          user.register(this.form)
          .then(()=>{
            this.dialog = false
            this.initializeEmailAndUSN()
        this.resetForm();
            this.$root.$emit('showSnackbar', "User created successfully");
          })
          .catch((error) =>{
            this.errors = error.response.data.errors
            console.log(this.errors);
          })
        }else{
          this.$root.$emit('showSnackbar', "Wrong Faculty Details");
        }
      }else{
        this.formHasErrors = true
      }           
    },
    initializeEmailAndUSN(){
        user.getAllEmailAndUSN()
        .then((res)=>{
          this.existingEmailAndUSN = res.data
        })
        .catch((error) =>{
          this.errors = error.response.data.errors
          console.log(this.errors);
        })
    }
  },
  created(){
    this.initializeEmailAndUSN();   
    axios.get('/api/get-faculty-table')
    .then((res)=>{
      this.facultyList = res.data;
    })
    .catch((error) =>{
        console.log(error)
      })
  },
  mounted(){
    
  }
}
</script>