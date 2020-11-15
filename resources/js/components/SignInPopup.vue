<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">Sign In</v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Sign-in</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Email/USN" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password" type="password" required></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="">
          <v-btn color="info darken-1" class="ma-5" text @click="dialog = false"><div class="text-uppercase font-weight-bold ">C</div><div class="text-lowercase font-weight-bold ">reate account</div></v-btn>
          <v-btn color="info darken-1" class="ma-5" text @click="dialog = false"><div class="text-uppercase font-weight-bold d-none d-sm-flex">F</div><div class="text-lowercase font-weight-bold d-none d-sm-flex">orgot password?</div></v-btn>
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5 d-none d-sm-flex" @click="dialog = false">Sign-in</v-btn>
        </v-card-actions>
        <v-card-actions class="d-flex d-sm-none">
          <v-btn color="info darken-1" class="ma-5" text @click="dialog = false"><div class="text-uppercase font-weight-bold">F</div><div class="text-lowercase font-weight-bold">orgot password</div></v-btn>
          <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5" @click="dialog = false">Sign-in</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>


<script>
export default{
    data: () => ({
      dialog: false
    }),
}
</script>