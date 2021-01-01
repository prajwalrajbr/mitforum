<template>
  <v-row justify="end" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog" large>
            <span class="grey--text text--darken-4 font-weight-bold">+ Upload Notes</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Upload Notes</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-text-field v-model="form.name" :error-messages="nameErrors" label="Notes Name" required @input="$v.form.name.$touch()" @blur="$v.form.name.$touch()"></v-text-field>
            </v-col>
            <v-col>
              <v-file-input v-model="form.fileName" show-size label="File input" :error-messages="fileErrors" @change="selectFile" ></v-file-input>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>  
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-sm-flex" @click.prevent="submit">Upload</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

import user from "../apis/user";

import { validationMixin } from 'vuelidate';
import { required, maxLength} from 'vuelidate/lib/validators';

export default{
  mixins: [validationMixin],
  validations: {
    form: { 
      name: { required, maxLength: maxLength(30) },
      fileName: { required },
    }
  },
  props: ['uploaded_subject_id'],
  data: () => ({
    dialog: false,
    userID: null,
    form:{ 
        name: '',
        fileName: null,
    },     
  }),
  computed: {
    nameErrors () {
      const errors = []
      if (!this.$v.form.name.$dirty) return errors
      !this.$v.form.name.maxLength && errors.push('This field must be at most 30 characters long')
      !this.$v.form.name.required && errors.push('This field is required')
      return errors
    },
    fileErrors () {
      const errors = []
      if (!this.$v.form.fileName.$dirty) return errors
      !this.$v.form.fileName.required && errors.push('This field is required')
      return errors
    },
  },
  methods: {
    resetForm () {
      this.formHasErrors = false
      this.$v.$reset();
      var self = this;
      this.form.fileName = null;
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
        var data = new FormData()
            data.append('name', this.form.name);
            data.append('fileName', this.form.fileName)
            data.append('uploaded_by', this.userID);
            data.append('uploaded_subject_id', this.uploaded_subject_id);
          axios.post('/api/notes',data ,{headers:{'Content-Type': 'multipart/form-data'}})
          .then((res)=>{
            this.resetForm();
            this.$root.$emit('refreshNotes', "true");
            this.dialog = false
          })
          .catch((error) =>{
            this.errors = error.response.data.errors;
            console.log(this.errors);
          })
      }
    },
    selectFile(file) {
      this.form.fileName = file;
    },
    updateUserData () {
      user.auth()
      .then((res)=>{
        this.userID = res.data.id;
        this.loggedIn = true;
        this.$root.$emit('loggedIn', "true");
      })
      .catch((error) =>{
        this.userName = "";
        this.$root.$emit('showLogInPopup', "true");
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
    this.$root.$on('showAddNotesPopup', () =>{
      this.dialog = true
    });
    this.$root.$on('cancelAddNotesPopup', () =>{
      
    });
  }
}
</script>