<template>
  <v-row justify="start">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="info darken-1" class="ma-5 " text v-bind="attrs" v-on="on"><div class="text-uppercase font-weight-bold ">C</div><div class="text-lowercase font-weight-bold ">reate account</div></v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Create account</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="First Name*" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Middle Name"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Last Name*" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field label="USN*" required></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field label="Email*" type="email" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password*" type="password" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Confirm Password*" type="password" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select :items=sem label="Semester*" required></v-select>
              </v-col>
              <v-col cols="12" sm="6">
                <v-autocomplete :items=branches label="Branch*"></v-autocomplete>
              </v-col>
            </v-row>
          </v-container>
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
export default{
    data: () => ({
      dialog: false,
      sem: [
        '1','2','3','4','5','6','7','8'
      ],
      branches: [
        'Computer Science', 
        'Information Science', 
        'Eletronics and Communication', 
        'Civil', 
        'Mechanical'
      ]
    }),
}
</script>