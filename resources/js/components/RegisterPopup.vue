<template>
  <v-row justify="start">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="info darken-1" class="ma-5 " text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold ">C</div><div class="text-lowercase font-weight-bold ">reate account</div></v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Create account</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-row>
              <v-col cols="12" sm="6" md="6" >
                <v-text-field v-model="form.fullName" :error-messages="fullNameErrors" label="Full Name*" required @input="$v.form.fullName.$touch()" @blur="$v.form.fullName.$touch()"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6" >
                <v-text-field v-model="form.usn" :error-messages="usnErrors" label="USN*" required @input="$v.form.usn.$touch()" @blur="$v.form.usn.$touch()"></v-text-field>
              </v-col>
              
              <v-col cols="12" sm="6" md="6" >
                <v-text-field v-model="form.email" :error-messages="emailErrors" label="Email*" required @input="$v.form.email.$touch()" @blur="$v.form.email.$touch()"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6" >  
                <v-autocomplete v-model="form.branch" :items="form.branchItems" :error-messages="branchErrors" label="Branch*" required @change="$v.form.branch.$touch()" @blur="$v.form.branch.$touch()"></v-autocomplete>  
              </v-col>

              <v-col cols="8" sm="6" md="6" >  
                <v-select v-model="form.sem" :items="form.semItems" :error-messages="semErrors" label="Semester*" required @change="$v.form.sem.$touch()" @blur="$v.form.sem.$touch()"></v-select>
              </v-col>
              <v-col cols="4" sm="6" md="6" >  
                <v-checkbox v-model="form.isFaculty" :error-messages="isFacultyErrors" label="Faculty" @change="$v.form.isFaculty.$touch()" @blur="$v.form.isFaculty.$touch()"></v-checkbox>
              </v-col>

              <v-col cols="12" sm="6" md="6" >  
                <v-text-field v-model="form.password" :append-icon="form.show1 ? 'visibility' : 'visibility_off'" :error-messages="passwordErrors" :type="form.show1 ? 'text' : 'password'" label="Password*" required counter @input="$v.form.password.$touch()" @blur="$v.form.password.$touch()" @click:append="form.show1 = !form.show1"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6" >  
                <v-text-field v-model="form.repeatPassword" :append-icon="form.show2 ? 'visibility' : 'visibility_off'" :error-messages="repeatPasswordErrors" :type="form.show2 ? 'text' : 'password'" label="Confirm Password*" required counter @input="$v.form.repeatPassword.$touch()" @blur="$v.form.repeatPassword.$touch()" @click:append="form.show2 = !form.show2"></v-text-field>
              </v-col>
            </v-row>    
          </v-form><v-divider class="mt-1"></v-divider>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-btn class="font-weight-bold" @click="dialog = false" text>Cancel</v-btn>
          <v-spacer></v-spacer>
          <v-slide-x-reverse-transition>
            <v-tooltip v-if="formHasErrors" left>
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon class="my-0" v-bind="attrs" @click="resetForm" v-on="on">
                  <v-icon>mdi-refresh</v-icon>
                </v-btn>
              </template>
              <span>Refresh form</span>
            </v-tooltip>
          </v-slide-x-reverse-transition>
          <v-btn color="primary" text @click="submit">Submit</v-btn>


          <!-- <v-btn color="info darken-1 " text @click="dialog = false"><div class="text-uppercase font-weight-bold">S</div><div class="text-lowercase font-weight-bold">ign-in instead</div></v-btn>
          <v-spacer></v-spacer>
          <v-btn color="error darken-1 font-weight-bold" @click="dialog = false">Close</v-btn>
          <v-btn color="success darken-1 font-weight-bold" @click="dialog = false">Register</v-btn> -->
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>


<script>
import { validationMixin } from 'vuelidate'
import { required, maxLength, minLength, email, sameAs } from 'vuelidate/lib/validators'
export default{
  mixins: [validationMixin],
  validations: {
    form: {
      fullName: { required, minLength: minLength(1), maxLength: maxLength(20) },
      usn: { required, minLength: minLength(10), maxLength: maxLength(10) },
      email : { required, email },
      password: { required, minLength: minLength(8), maxLength: maxLength(20) },
      repeatPassword: { required, sameAsPassword: sameAs('password') },
      sem: { required },
      branch: { required },
    }
  },
  data: () => ({
    dialog: false,
    form:{ 
      fullName: '',
      usn: '',
      email: '',
      password: '',
      show1: false,
      repeatPassword: '',
      show2: false,
      sem: '',
      semItems: [
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
      isFaculty: false,
    },   
    formHasErrors: false,
  }),
  computed: {
    fullNameErrors () {
      const errors = []
      if (!this.$v.form.fullName.$dirty) return errors
      !this.$v.form.fullName.maxLength && errors.push('This field must be at most 20 characters long')
      !this.$v.form.fullName.minLength && errors.push('This field must be at least 5 characters')
      !this.$v.form.fullName.required && errors.push('This field is required.')
      return errors
    },
    usnErrors () {
      const errors = []
      if (!this.$v.form.usn.$dirty) return errors
      !this.$v.form.usn.maxLength && errors.push('This field must be 10 characters long')
      !this.$v.form.usn.minLength && errors.push('This field must be 10 characters long')
      !this.$v.form.usn.required && errors.push('This field is required.')
      return errors
    },
    emailErrors () {
        const errors = []
        if (!this.$v.form.email.$dirty) return errors
        !this.$v.form.email.email && errors.push('Must be valid e-mail')
        !this.$v.form.email.required && errors.push('E-mail is required')
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
    semErrors () {
      const errors = []
      if (!this.$v.form.sem.$dirty) return errors
      !this.$v.form.sem.required && errors.push('This field is required')
      return errors
    },
    branchErrors () {
      const errors = []
      if (!this.$v.form.branch.$dirty) return errors
      !this.$v.form.branch.required && errors.push('This field is required')
      return errors
    },
    form () {
      return {
        fullName: this.fullName,
        usn: this.usn,
      }
    },

  },
  methods: {
    resetForm () {
        this.formHasErrors = false
        this.$v.$reset();
        this.form.fullName= ''
        this.form.usn= ''
        this.form.email= ''
        this.form.password= ''
        this.form.show1= false
        this.form.repeatPassword= ''
        this.form.show2= false
        this.form.sem= ''
        this.form.branch= ''
        this.form.isFaculty= false
      },
      submit () {
        
        this.formHasErrors = true
      this.$v.$touch()
        
      },
  },
}
</script>