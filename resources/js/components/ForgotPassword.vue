<template>
  <v-row justify="start">
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="info darken-1" :disabled="dialog" class="ma-5 d-none d-sm-flex" text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold d-none d-sm-flex">F</div><div class="text-lowercase font-weight-bold d-none d-sm-flex">orgot password?</div></v-btn>
        <v-btn color="info darken-1" :disabled="dialog" class="ma-5 d-flex d-sm-none" text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold d-flex d-sm-none">F</div><div class="text-lowercase font-weight-bold d-flex d-sm-none">orgot password</div></v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Reset password</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-text-field v-model="form.email" :error-messages="emailErrors" label="Email/USN" required @input="$v.form.email.$touch()" @blur="$v.form.email.$touch()"></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions >
          <v-spacer></v-spacer>
          <v-btn color="grey lighten-1 font-weight-bold ma-5" @click="clear">Clear</v-btn>
          <v-btn color="info darken-1 font-weight-bold ma-5" @click="submit">Submit</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

import { validationMixin } from 'vuelidate'
import { required, maxLength} from 'vuelidate/lib/validators'

export default{
  mixins: [validationMixin],
  validations: {
    form:{ 
      email: { required, maxLength: maxLength(40) },
    }
  },
  data: () => ({
    dialog: false,
    form:{ 
      email: '',
    },
  }),
  computed: {
      emailErrors () {
        const errors = []
        if (!this.$v.form.email.$dirty) return errors
        !this.$v.form.email.maxLength && errors.push('Email/USN must be at most 40 characters long')
        !this.$v.form.email.required && errors.push('Email/USN is required.')
        return errors
      },
    },
    methods: {
      submit () {
      this.$v.$touch()
      this.formTouched = !this.$v.form.$anyDirty;
      this.errors = this.$v.form.$anyError;
      if (this.errors === false && this.formTouched === false) {
      this.$root.$emit('showProgressBar', true);
        axios.post('/api/password/email',{'email':this.form.email})
        .then((res)=>{
        this.$root.$emit('stopProgressBar', true);
        this.dialog = false
        this.$root.$emit('showSnackbar', "Reset Link Sent to email");
        this.clear()
        })
        .catch((err)=>{
        this.$root.$emit('stopProgressBar', true);
        this.$root.$emit('showSnackbar', "Enter a valid email");
        })}
      },
      clear () {
        this.$v.$reset()
        this.form.email = ''
      },
    },
}
</script>