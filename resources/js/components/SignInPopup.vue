<template>
    <v-dialog max-width="600px">
        <v-btn slot="activator" class="success">Sign In</v-btn>
        <v-card>
            <v-card-title>
                <h2>LOG-IN</h2>
            </v-card-title>
        </v-card>
    </v-dialog>
</template>

<script>
export default{
    data: () => ({
      dialog: false,
    }),
}
</script>