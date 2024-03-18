<template>
  <div class="container">
     <div class="card-header">
       <h2>{{ mode }} Capsule</h2>
     </div>
     <div class="card-body">
       <div class="card shadow-sm">
         <div class="card-body">
           <el-form :model="formData" :rules="formRules" ref="capsuleForm">
             <el-form-item label="Message" prop="message">
               <el-input v-model="formData.message" type="textarea"></el-input>
             </el-form-item>
             <el-form-item label="Opening Time" prop="openeingTime">
               <el-date-picker
                 v-model="formData.openeingTime"
                 type="datetime"
                 placeholder="Select datetime"
                 value-format="YYYY-MM-DD HH:mm:ss"
               ></el-date-picker>
             </el-form-item>
             <el-form-item>
               <el-button size="small" type="primary" @click="submitForm">Submit</el-button>
               <router-link :to="{ name: 'capsules' }">
                 <el-button size="small" type="default">Cancel</el-button>
               </router-link>
             </el-form-item>
           </el-form>
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
  name: "CapsuleForm",
  data() {
    return {
      formData: {
        message: "",
        openeingTime: null,
      },
      formRules: {
        message: [{ required: true, message: "Please enter message", trigger: "blur" }],
        openeingTime: [
          { required: true, message: "Please enter openeingTime", trigger: "blur" },
        ],
      },
    };
  },
  computed: {
    ...mapGetters("capsule", ["isLoading", "editCapsule", "errorMessage"]),
    mode() {
      return this.$route.name === "edit" ? "Edit" : "Create";
    },
  },
  watch: {
    editCapsule: {
      handler(editCapsule) {
        if (editCapsule) {
          this.formData = { ...editCapsule };
        }
      },
      immediate: true,
    },
  },
  created() {
    this.resethForm();
    const capsuleId = this.$route.params.id;
    if (capsuleId) {
      this.loadCapsuleData(capsuleId);
    }
  },
  methods: {
    ...mapActions("capsule", ["createCapsule", "updateCapsule", "fetchCapsuleById", "resethForm"]),
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
    async submitForm() {
      try {
        await this.$refs.capsuleForm.validate();
        if (this.mode === "Create") {
          await this.createCapsule({ ...this.formData });
          toastr.success("Capsule  Created.");
          this.$router.push({ name: "capsules" });
        } else {
          await this.updateCapsule({ ...this.formData });
          toastr.success("Capsule  Updated.");
          this.$router.push({ name: "capsules" });
        }
      } catch (error) {
        if (error.isAxiosError) {
          toastr.error(error.response.data.error);
        }
      }
    },
  },
};
</script>
