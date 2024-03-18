<template>
    <div class="container">
      <div class="card-header">
        <h2>View Capsule</h2>
      </div>
      <div class="card-body">
        <div class="card shadow-sm">
          <div class="card-body">
            <div><label class="font-weight-bold">Messsage</label><p>{{ editCapsule?.message }}</p> </div>
            <div><label class="font-weight-bold">Opening Time</label><p>{{ editCapsule?.openeingTime }}</p> </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
<script>
  import { mapActions, mapGetters } from "vuex";
  import { useToastr } from "@/notification.js";
  
  const toastr = useToastr();
  
  export default {
    name: "DetailView",
    data() {
      return {
        data: {
          message: "",
          openeingTime: null,
        },
      };
    },
    computed: {
      ...mapGetters("capsule", ["isLoading", "editCapsule", "errorMessage"]),
    },
    created() {
      const capsuleId = this.$route.params.id;
      this.loadCapsuleData(capsuleId);
    },
    methods: {
      ...mapActions("capsule", [ "fetchCapsuleById"]),
      async loadCapsuleData(capsuleId) {
      try {
        await this.fetchCapsuleById(capsuleId);
      } catch (error) {
          if (error.isAxiosError) {
            toastr.error(error.response.data.error);
          }
          this.$router.go(-1);
      }
    },
  },
};
</script>
  