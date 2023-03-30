<template>

<v-container>
<v-row align="center" justify="space-around" dense >
    <v-btn depressed color="primary"  @click="CollectionEntry()">Collection Entry</v-btn>
    <v-btn depressed color="primary"   @click="RefundEntry()">Refund Entry</v-btn>
    <v-btn depressed color="primary"   @click="RefundScan()">Refund Scan</v-btn>
  </v-row>



</v-container>




</template>

<script>
export default {
  data() {
    return {

    };
  },
  created() {},
  methods: {



    // User Validation Server+Client Side
    CollectionEntry() {this.$router.push({path: "collection-entry/add-collection-entry"});},
    RefundEntry() {this.$router.push({path: "refund-entry/add-refund-entry"});},
    RefundScan() {this.$router.push({path: "refund-entry/add-refund-entry-by-number"});},





  }
};
</script>
