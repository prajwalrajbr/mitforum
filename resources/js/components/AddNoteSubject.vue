<template>
  <v-row justify="end" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog">
            <span class="grey--text text--darken-4 font-weight-bold">+ Add Subject</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Add Subject</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-text-field v-model="form.subject_name" :error-messages="subject_nameErrors" label="Subject Name" required @input="$v.form.subject_name.$touch()" @blur="$v.form.subject_name.$touch()"></v-text-field>
            </v-col>
            
            <v-col cols="12">  
              <v-autocomplete v-model="form.branch" :items="form.branchItems" :error-messages="branchErrors" label="Branch*" required @change="$v.form.branch.$touch()" @blur="$v.form.branch.$touch()"></v-autocomplete>  
            </v-col>
            
            <v-col cols="12" sm="6" md="6" >
              <v-text-field v-model="form.subject_code" :error-messages="subject_codeErrors" label="Subject Code" required @input="$v.form.subject_code.$touch()" @blur="$v.subject_code.usn.$touch()"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6" >  
              <v-select v-model="form.semester" :items="form.semesterItems" :error-messages="semesterErrors" label="Semester*" required @change="$v.form.semester.$touch()" @blur="$v.form.semester.$touch()"></v-select>
            </v-col>

          </v-row>
        </v-card-text>
        <v-card-actions>  
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-sm-flex" @click.prevent="submit">Create</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

import user from "../apis/user";

import { validationMixin } from 'vuelidate'
import { required, maxLength, minLength} from 'vuelidate/lib/validators'

export default{
  mixins: [validationMixin],
  validations: {
    form: { 
      subject_name: { required, maxLength: maxLength(40) },
      subject_code: { required, minLength: minLength(6), maxLength: maxLength(10) },
      semester: { required },
      branch: { required },
    }
  },
  data: () => ({
    dialog: false,
    user: null,
    form:{ 
      subject_name: '',
      subject_code: '',
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
    },     
  }),
  computed: {
    subject_nameErrors () {
      const errors = []
      if (!this.$v.form.subject_name.$dirty) return errors
      !this.$v.form.subject_name.maxLength && errors.push('This field must be at most 40 characters long')
      !this.$v.form.subject_name.required && errors.push('This field is required.')
      return errors
    },
    subject_codeErrors () {
      const errors = []
      if (!this.$v.form.subject_code.$dirty) return errors
      !this.$v.form.subject_code.maxLength && errors.push('This field must be at most 10 characters long')
      !this.$v.form.subject_code.minLength && errors.push('This field must be at least 6 characters')
      !this.$v.form.subject_code.required && errors.push('This field is required.')
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
    submit () {
      this.$v.$touch()
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
        this.$root.$emit('loggedOut', "true");
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
    this.$root.$on('showCreateSubjectPopup', () =>{
      this.dialog = true
    });
  }
}
</script>