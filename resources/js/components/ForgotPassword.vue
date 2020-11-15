<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">Forgot</v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Forgot</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Email/USN" required></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions >
            <v-spacer></v-spacer>
          <v-btn color="info darken-1 font-weight-bold ma-5" @click="dialog = false">Send Reset</v-btn>
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