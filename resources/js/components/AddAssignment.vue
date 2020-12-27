<template>
  <v-row justify="end" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog">
            <span class="grey--text text--darken-4 font-weight-bold">+ Add Assignment</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Add Assignment</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-text-field v-model="form.name" :error-messages="nameErrors" label="Assignment Name" required @input="$v.form.name.$touch()" @blur="$v.form.name.$touch()"></v-text-field>
            </v-col>

            <v-col cols="12"  >  
              <v-select v-model="form.sem" :items="form.semesterItems" :error-messages="semErrors" label="Semester*" required @change="filteredSubjects" @blur="$v.form.sem.$touch()"></v-select>
            </v-col>
                
            <v-col cols="12" >
                <v-datetime-picker label="Last day to Submit [Default : 1 week]" v-model="form.datetime" @change="$v.form.datetime.$touch()" @blur="$v.form.datetime.$touch()"> </v-datetime-picker>
            </v-col>
            <v-col cols="12" >  
              <v-select v-model="form.subject" :items="sub" :error-messages="subErrors" label="Subject*" required @change="$v.form.subject.$touch()" @blur="$v.form.subject.$touch()"></v-select>
            </v-col>

            <v-col>
              <v-file-input show-size label="File input" :error-messages="fileErrors" @change="selectFile" ></v-file-input>
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
      sem: { required },
      subject: { required },
      fileName: { required },
    }
  },
  props: ['subjects'],
  data: () => ({
    dialog: false,
    userID: null,
    sub: [],
    form:{ 
        name: '',
        fileName: null,
        sem: '',
        semesterItems: [
            '1','2','3','4','5','6','7','8'
        ],
        datetime: null,
        subject: '',
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
    semErrors () {
      const errors = []
      if (!this.$v.form.sem.$dirty) return errors
      !this.$v.form.sem.required && errors.push('This field is required')
      return errors
    },
    subErrors () {
      const errors = []
      if (!this.$v.form.subject.$dirty) return errors
      !this.$v.form.subject.required && errors.push('This field is required')
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
filteredSubjects(){
          this.sub = [];
          if(parseInt(this.form.sem)){
              this.subjects.forEach((i)=>{
                  if(i.sem == parseInt(this.form.sem)){
                      this.sub.push(i.subject_name+'['+i.sub_code+']')
                  }
          })
          }
      },

    submit () {
      this.$v.$touch();
    //   this.formTouched = !this.$v.form.$anyDirty;
    //   this.errors = this.$v.form.$anyError;
    //    if (this.errors === false && this.formTouched === false) {
          var data = new FormData()
          if(this.form.datetime==null){
                var d = new Date();
                d.setDate(d.getDate()+7);
                data.append('last_date_time', String(d));
          }else{
            data.append('last_date_time', String(this.form.datetime));
          }
        data.append('name', this.form.name);
            data.append('fileName', this.form.fileName)
            data.append('created_by', this.userID);
            this.subjects.forEach((i)=>{
                  if(i.subject_name+'['+i.sub_code+']' == this.form.subject){
                    data.append('subject_id', String(i.id));
                  }
            })
          axios.post('/api/assignmentq',data ,{headers:{'Content-Type': 'multipart/form-data'}})
            .then((res)=>{
              console.log(res.data);
            this.$root.$emit('refreshAssignments', "true");
            this.dialog = false
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
        this.branch = res.data.branch;
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
    this.$root.$on('showAddAssignmentPopup', () =>{
      this.dialog = true
    });
    this.$root.$on('cancelshowAddAssignmentPopupPopup', () =>{
      this.dialog = false
    });
  }
}
</script>