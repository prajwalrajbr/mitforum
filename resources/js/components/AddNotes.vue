<template>
  <v-row justify="end" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog">
            <span class="grey--text text--darken-4 font-weight-bold">+ Upload Notes</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Upload Notes</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col>
              <v-file-input show-size label="File input" @change="selectFile"></v-file-input>
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

import { validationMixin } from 'vuelidate'
import { required} from 'vuelidate/lib/validators'

export default{
  mixins: [validationMixin],
  validations: {
    form: { 
    }
  },
  props: ['uploaded_subject_id'],
  data: () => ({
    dialog: false,
    userID: null,
    form:{ 
        fileName: null,
        uploaded_by: 1
    },     
  }),
  computed: {
    
  },
  methods: {
    submit () {
      this.$v.$touch()
    //   this.formTouched = !this.$v.form.$anyDirty;
    //   this.errors = this.$v.form.$anyError;
    //   if (this.errors === false && this.formTouched === false) {
    //     this.form.created_by = this.userID
            console.log(this.form.fileName);
            var data = new FormData()
    data.append('fileName', this.form.fileName)
    data.append('uploaded_by', this.userID)
    data.append('uploaded_subject_id', this.uploaded_subject_id)
        axios.post('/api/notes',data ,{headers:{'Content-Type': 'multipart/form-data'}})
        .then((res)=>{
            console.log(res);
            console.log(this.form.fileName);
        //   this.dialog = false
        //   this.$root.$emit('showSnackbar', "Subject Created Successfully");
        //   this.$root.$emit('addSubject', this.form);
        })
    //     .catch((error) =>{
    //       this.errors = error.response.data.errors
    //       console.log(this.errors);
    //     })
    //   }
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
  }
}
</script>