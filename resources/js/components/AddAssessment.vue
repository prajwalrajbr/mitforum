<template>
  <v-row justify="end" block>
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="white mr-5" :disabled="dialog">
            <span class="grey--text text--darken-4 font-weight-bold">+ Add Assessment</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Add Assessment</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-text-field v-model="form.name" :error-messages="nameErrors" label="Assessment Name" required @input="$v.form.name.$touch()" @blur="$v.form.name.$touch()"></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" >  
              <v-select v-model="form.sem" :items="form.semesterItems" :error-messages="semErrors" label="Semester*" required @change="filteredSubjects" @blur="$v.form.sem.$touch()"></v-select>
            </v-col>

            <v-col cols="12" sm="6">
      <v-menu v-model="menu3" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px" >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field v-model="date" label="Select date" :error-messages="dateErrors" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" ></v-text-field>
        </template>
        <v-date-picker v-model="date" @input="menu3 = false" :min="nowDate"></v-date-picker>
      </v-menu>
    </v-col>  

<v-col cols="12" sm="6" >
      <v-menu ref="menu1" v-model="menu1" :close-on-content-click="false" :nudge-right="40" :return-value.sync="startTime" transition="scale-transition" offset-y max-width="290px" min-width="290px">
        <template v-slot:activator="{ on, attrs }">
          <v-text-field v-model="startTime" label="Select start time" :error-messages="startTimeErrors" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" ></v-text-field>
        </template>
        <v-time-picker :max="endTime" v-if="menu1" v-model="startTime" full-width @click:minute="$refs.menu1.save(startTime)" ></v-time-picker>
      </v-menu>
    </v-col>

<v-col cols="12" sm="6" >
      <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false" :nudge-right="40" :return-value.sync="endTime" transition="scale-transition" offset-y max-width="290px" min-width="290px">
        <template v-slot:activator="{ on, attrs }">
          <v-text-field v-model="endTime" label="Select end time" :error-messages="endTimeErrors" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" ></v-text-field>
        </template>
        <v-time-picker :min="startTime" v-if="menu2" v-model="endTime" full-width @click:minute="$refs.menu2.save(endTime)" ></v-time-picker>
      </v-menu>
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
    },
      startTime: { required },
      endTime: { required },
      date: { required },
  },
  props: ['subjects','userName','is_f','branch','sem','userId','nowDate'],
  data: () => ({
    dialog: false,
    sub: [],
    startTime: null,
    endTime: null,
    date: null,
    menu1: false,
    menu2: false,
    menu3: false,
    form:{ 
        name: '',
        fileName: null,
        sem: '',
        semesterItems: [
            '1','2','3','4','5','6','7','8'
        ],
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
    dateErrors () {
      const errors = []
      if (!this.$v.date.$dirty) return errors
      !this.$v.date.required && errors.push('This field is required')
      return errors
    },
    startTimeErrors () {
      const errors = []
      if (!this.$v.startTime.$dirty) return errors
      !this.$v.startTime.required && errors.push('This field is required')
      return errors
    },
    endTimeErrors () {
      const errors = []
      if (!this.$v.endTime.$dirty) return errors
      !this.$v.endTime.required && errors.push('This field is required')
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
          data.append('name', this.form.name);
          data.append('fileName', this.form.fileName)
            data.append('created_by_id', this.userId);
            data.append('branch', this.branch);
            data.append('sem', this.sem);
            data.append('created_by_name', this.userName);
            data.append('is_f', this.is_f);
            this.subjects.forEach((i)=>{
                    if(i.subject_name+'['+i.sub_code+']' == this.form.subject){
                    data.append('subject_id', String(i.id));
                    data.append('subject_name', String(i.subject_name));
                    data.append('sub_code', String(i.sub_code));
                    }
            })
            data.append('startTime', String(this.startTime));
            data.append('endTime', String(this.endTime));
            data.append('date', String(this.date));
           axios.post('/api/assessmentq',data ,{headers:{'Content-Type': 'multipart/form-data'}})
             .then((res)=>{
               console.log(res.data);
               this.$root.$emit('addAssessment', res.data);

        //     this.$root.$emit('refreshAssignments', "true");
        // this.$root.$emit('showSnackbar', "Successfully Created");
        //     this.$router.push('/')
             this.dialog = false
             })
             .catch((error) =>{
               this.errors = error.response.data.errors;
               console.log(this.errors);
             })
        console.log(data)
        
    },
    selectFile(file) {
      this.form.fileName = file;
    },
    
  },
  mounted(){
      
    this.$root.$on('showAddAssessmentPopup', () =>{
      this.dialog = true
    });
    this.$root.$on('cancelshowAddAssessmentPopup', () =>{
      this.dialog = false
    });
  }
}
</script>