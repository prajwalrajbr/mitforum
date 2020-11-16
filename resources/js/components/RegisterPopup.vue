<template>
  <v-row justify="start">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="info darken-1" class="ma-5 " text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold ">C</div><div class="text-lowercase font-weight-bold ">reate account</div></v-btn>
      </template>
      <v-card ref="form">
        <v-card-title>
          <span class="headline">Create account</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-row justify="center">
              <v-col cols="12" sm="6" md="4" >
                <v-text-field ref="fullName" v-model="fullName" :error-messages="fullNameErrors" label="Full Name*" required @input="$v.fullName.$touch()" @blur="$v.fullName.$touch()"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4" >
                <v-text-field ref="usn" v-model="usn" :error-messages="usnErrors" label="USN*" required @input="$v.usn.$touch()" @blur="$v.usn.$touch()"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4" >
                <v-text-field ref="email" v-model="email" :error-messages="emailErrors" label="Email*" required @input="$v.email.$touch()" @blur="$v.email.$touch()"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4" >  
                <v-text-field ref="password" v-model="password" :append-icon="show1 ? 'visibility' : 'visibility_off'" :error-messages="passwordErrors" :type="show1 ? 'text' : 'password'" label="Password*" required counter @input="$v.password.$touch()" @blur="$v.password.$touch()" @click:append="show1 = !show1"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4" >  
                <v-text-field ref="repeatPassword" v-model="repeatPassword" :append-icon="show2 ? 'visibility' : 'visibility_off'" :error-messages="repeatPasswordErrors" :type="show2 ? 'text' : 'password'" label="Confirm Password*" required counter @input="$v.repeatPassword.$touch()" @blur="$v.repeatPassword.$touch()" @click:append="show2 = !show2"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4" >  
                <v-select v-model="sem" :items="semItems" :error-messages="semErrors" label="Semester*" required @change="$v.sem.$touch()" @blur="$v.sem.$touch()"></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="4" >  
                <v-autocomplete v-model="branch" :items="branchItems" :error-messages="branchErrors" label="Branch*" required @change="$v.branch.$touch()" @blur="$v.branch.$touch()"></v-autocomplete>  
              </v-col>
              <v-col cols="12" sm="6" md="4" >  
                <v-checkbox v-model="isFaculty" label="Faculty"></v-checkbox>
                <v-container
    class="px-0"
    fluid
  >
    <v-checkbox
      v-model="checkbox"
      :label="`Checkbox 1: ${checkbox.toString()}`"
    ></v-checkbox>
  </v-container><v-btn
        class="ma-2"
        color="primary"
        dark
      >
        Accept
        <v-icon
          dark
          right
        >
          mdi-checkbox-marked-circle
        </v-icon>
      </v-btn><v-icon
      large
      color="green darken-2"
    >
      mdi-domain
    </v-icon>
              </v-col>
            </v-row>
            
          </v-form>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-btn color="info darken-1 " text @click="dialog = false"><div class="text-uppercase font-weight-bold">S</div><div class="text-lowercase font-weight-bold">ign-in instead</div></v-btn>
          <v-spacer></v-spacer>
          <v-btn color="error darken-1 font-weight-bold" @click="dialog = false">Close</v-btn>
          <v-btn color="success darken-1 font-weight-bold" @click="dialog = false">Register</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>


<script>
import { validationMixin } from 'vuelidate'
import { required, maxLength, minLength, email, sameAs } from 'vuelidate/lib/validators'
import SvgIcon from '@jamescoyle/vue-icon'
import { mdiAccount } from '@mdi/js'
export default{
  components: {
        SvgIcon
    },
  mixins: [validationMixin],
  validations: {
    fullName: { required, minLength: minLength(1), maxLength: maxLength(20) },
    usn: { required, minLength: minLength(10), maxLength: maxLength(10) },
    email : { required, email },
    password: { required, minLength: minLength(8), maxLength: maxLength(20) },
    repeatPassword: { required, sameAsPassword: sameAs('password') },
    sem: { required },
    branch: { required }
  },
  data: () => ({path: mdiAccount,
    dialog: false,
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
    isFaculty: false,checkbox: true
  }),
  computed: {
    fullNameErrors () {
      const errors = []
      if (!this.$v.fullName.$dirty) return errors
      !this.$v.fullName.maxLength && errors.push('This field must be at most 20 characters long')
      !this.$v.fullName.minLength && errors.push('This field must be at least 5 characters')
      !this.$v.fullName.required && errors.push('This field is required.')
      return errors
    },
    usnErrors () {
      const errors = []
      if (!this.$v.usn.$dirty) return errors
      !this.$v.usn.maxLength && errors.push('This field must be 10 characters long')
      !this.$v.usn.minLength && errors.push('This field must be 10 characters long')
      !this.$v.usn.required && errors.push('This field is required.')
      return errors
    },
    emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('E-mail is required')
        return errors
    },
    passwordErrors () {
      const errors = []
      if (!this.$v.password.$dirty) return errors
      !this.$v.password.maxLength && errors.push('Password must be at most 20 characters long')
      !this.$v.password.minLength && errors.push('Password must be at least 8 characters')
      !this.$v.password.required && errors.push('Password is required.')
      return errors
    },
    repeatPasswordErrors () {
      const errors = []
      if (!this.$v.repeatPassword.$dirty) return errors
      !this.$v.repeatPassword.sameAsPassword && errors.push('Passwords must be identical.')
      !this.$v.password.required && errors.push('This field is required.')
      return errors
    },
    semErrors () {
      const errors = []
      if (!this.$v.sem.$dirty) return errors
      !this.$v.sem.required && errors.push('This field is required')
      return errors
    },
    branchErrors () {
      const errors = []
      if (!this.$v.branch.$dirty) return errors
      !this.$v.branch.required && errors.push('This field is required')
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