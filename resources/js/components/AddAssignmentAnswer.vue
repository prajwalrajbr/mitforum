<template>
  <v-row justify="end" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="white mr-5 text-end" rounded color="success" dark :disabled="dialog">
            <span class="grey--text text--darken-4 font-weight-bold">+ Upload Assignment Answer</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Upload Assignment Answer</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col>
              <v-file-input show-size label="File input" :error-messages="fileErrors" @change="selectFile" ></v-file-input>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>  
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-flex" @click.prevent="submit">Submit</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

import user from "../apis/user";

import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';

export default{
  mixins: [validationMixin],
  validations: {
    form: { 
      fileName: { required },
    }
  },
  props: ['uploaded_Assignment_id'],
  data: () => ({
    dialog: false,
    userID: null,
    form:{ 
        fileName: null,
    },     
  }),
  computed: {  
    
    fileErrors () {
      const errors = []
      if (!this.$v.form.fileName.$dirty) return errors
      !this.$v.form.fileName.required && errors.push('This field is required')
      return errors
    },
  },
  methods: {
    submit () {
      this.$v.$touch();
       this.formTouched = !this.$v.form.$anyDirty;
       this.errors = this.$v.form.$anyError;
        if (this.errors === false && this.formTouched === false) {
      this.$root.$emit('showProgressBar', true);
          var data = new FormData()
          
        data.append('uploaded_by', this.userID);
            data.append('fileName', this.form.fileName)
            data.append('uploaded_at', this.nowDate = (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString());
            data.append('Assignment_id', this.uploaded_Assignment_id);
            
          axios.post('/api/assignmenta',data ,{headers:{'Content-Type': 'multipart/form-data'}})
            .then((res)=>{
        this.$root.$emit('stopProgressBar', true);
            this.$root.$emit('refreshAssignmentsUploaded', "true");
        this.$root.$emit('showSnackbar', "Successfully Uploaded");
            this.$router.push('/')
            this.dialog = false
            })
            .catch((error) =>{
        this.$root.$emit('stopProgressBar', true);
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
        this.$root.$emit('showLogInPopup', "true");
        this.$root.$emit('loggedOut', "true");
        this.loggedIn = false;
      })
      
    }
  },
  mounted(){
    this.updateUserData();
    console.log(this.uploaded_Assignment_id);
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