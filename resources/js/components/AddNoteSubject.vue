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
              <v-text-field v-model="form.subject" :error-messages="subjectErrors" label="Subject Name" required @input="$v.form.subject.$touch()" @blur="$v.form.subject.$touch()"></v-text-field>
            </v-col>
            
            <v-col cols="12">  
              <v-autocomplete v-model="form.branch" :items="form.branchItems" :error-messages="branchErrors" label="Branch*" required @change="$v.form.branch.$touch()" @blur="$v.form.branch.$touch()"></v-autocomplete>  
            </v-col>
            
            <v-col cols="12" sm="6" md="6" >
              <v-text-field v-model="form.sub_code" :error-messages="sub_codeErrors" label="Subject Code" required @input="$v.form.sub_code.$touch()" @blur="$v.sub_code.usn.$touch()"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6" >  
              <v-select v-model="form.sem" :items="form.semesterItems" :error-messages="semErrors" label="Semester*" required @change="$v.form.sem.$touch()" @blur="$v.form.sem.$touch()"></v-select>
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
      subject: { required, maxLength: maxLength(40) },
      sub_code: { required, minLength: minLength(6), maxLength: maxLength(10) },
      sem: { required },
      branch: { required },
    }
  },
  data: () => ({
    dialog: false,
    userID: null,
    form:{ 
      subject: '',
      sub_code: '',
      sem: '',
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
      created_by: '',
    },     
  }),
  computed: {
    subjectErrors () {
      const errors = []
      if (!this.$v.form.subject.$dirty) return errors
      !this.$v.form.subject.maxLength && errors.push('This field must be at most 40 characters long')
      !this.$v.form.subject.required && errors.push('This field is required.')
      return errors
    },
    sub_codeErrors () {
      const errors = []
      if (!this.$v.form.sub_code.$dirty) return errors
      !this.$v.form.sub_code.maxLength && errors.push('This field must be at most 10 characters long')
      !this.$v.form.sub_code.minLength && errors.push('This field must be at least 6 characters')
      !this.$v.form.sub_code.required && errors.push('This field is required.')
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
  },
  methods: {
    submit () {
      this.$v.$touch()
      this.formTouched = !this.$v.form.$anyDirty;
      this.errors = this.$v.form.$anyError;
      if (this.errors === false && this.formTouched === false) {
        this.form.created_by = this.userID
        axios.post('/api/subject',this.form)
        .then(()=>{
          this.dialog = false
          this.$root.$emit('showSnackbar', "Subject Created Successfully");
          this.$root.$emit('addSubject', this.form);
        })
        .catch((error) =>{
          this.errors = error.response.data.errors
          console.log(this.errors);
        })
      }
    },
    updateUserData () {
      
      user.auth()
      .then((res)=>{
        this.userID = res.data.id;
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