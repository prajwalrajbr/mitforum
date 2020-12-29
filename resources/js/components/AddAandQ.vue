<template>
  <v-row justify="end" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog">
            <span class="grey--text text--darken-4 font-weight-bold">+ Add Announcement or Query</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Add Announcement or Query</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-text-field v-model="form.name" :error-messages="nameErrors" label="Announcement or Query Name" required @input="$v.form.name.$touch()" @blur="$v.form.name.$touch()"></v-text-field>
            </v-col>
            <v-col cols="12">
            <v-textarea
              v-model="form.description"
              rows="3"
            >
              <template v-slot:label>
                <div>
                  Description <small>(optional)</small>
                </div>
              </template>
            </v-textarea>
          </v-col>
          <v-col cols="6">
              <v-checkbox
      label="include Files"
          v-model="includeFiles"
          hide-details
          class="shrink mr-2 mt-0"
    ></v-checkbox>
          </v-col>
            <v-col cols="12">
              <v-file-input :disabled="!includeFiles" show-size label="File input" @change="selectFile" ></v-file-input>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>  
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-sm-flex" @click.prevent="submit">Submit</v-btn>
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
    }
  },
  data: () => ({
    dialog: false,
    userID: null,
    is_f: false,
    includeFiles: false,
    form:{ 
        name: '',
        description: '',
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
  },
  methods: {
    submit () {
      this.$v.$touch()
      this.formTouched = !this.$v.form.$anyDirty;
      this.errors = this.$v.form.$anyError;
      if (this.errors === false && this.formTouched === false) {
          if(this.includeFiles){
            if(this.form.fileName===null){}else
          this.AddAnnouncementOrQuery()

          }else
          this.AddAnnouncementOrQuery()
    //     
      }
    },
    AddAnnouncementOrQuery(){
var data = new FormData()
            data.append('name', this.form.name);
            data.append('fileName', this.form.fileName)
            data.append('uploaded_by', this.userID);
            data.append('is_f', this.is_f);
            data.append('description', this.form.description);
            data.append('includeFiles', this.includeFiles);
          axios.post('/api/announcements-and-queries',data ,{headers:{'Content-Type': 'multipart/form-data'}})
          .then((res)=>{
        this.$root.$emit('addAandQ', data);
            this.dialog = false;
          })
          .catch((error) =>{
            this.errors = error.response.data.errors;
            console.log(this.errors);
          })
    },
    selectFile(file) {
      this.form.fileName = file;
    },
    updateUserData () {
      user.auth()
      .then((res)=>{
        this.userID = res.data.id;
        this.is_f = res.data.is_faculty;
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
    this.$root.$on('showAddAandQPopup', () =>{
      this.dialog = true
    });
    this.$root.$on('cancelshowAddAandQPopup', () =>{
      this.dialog = false
    });
  }
}
</script>