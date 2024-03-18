<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                      <h1 class="text-center mb-4">Login</h1>
                      <hr class="mb-4"/>
                      <el-form class="row g-3" :model="auth" :rules="formRules" ref="login">
                        <el-form-item class="row" prop="email">
                            <div class="col-2">
                              <label>Email *</label>
                            </div>
                            <div class="col-12">
                              <el-input class="form-control" v-model="auth.email" type="text"></el-input>
                            </div>
                        </el-form-item>
                        <el-form-item class="row" prop="password">
                            <div class="col-2">
                              <label>Password *</label>
                            </div>
                            <div class="col-12">
                              <el-input class="form-control" v-model="auth.password" type="password"></el-input>
                            </div>
                        </el-form-item>
                        <div class="col-12">
                            <el-button type="primary" @click="handleLogin" class="btn btn-primary" :disabled="processing">
                              {{ processing ? "Please wait" : "Login" }}
                            </el-button>
                        </div>
                      </el-form>
                      <div class="col-12 text-center mt-3">
                        <label>Don't have an account? <router-link :to="{name:'register'}" class="text-decoration-none">Register Now!</router-link></label>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { useToastr } from "@/notification.js";

const toastr = useToastr();
export default {
  name: "login",
  data() {
    return {
      auth: {
        email: "",
        password: ""
      },
      formRules: {
        email: [{ required: true, message: "Please enter email", trigger: "blur" }],
        password: [
          { required: true, message: "Please enter password", trigger: "blur" },
        ],
      },
      processing: false
    };
  },
  computed: {
    ...mapGetters({
      processing: 'processing',
    })
  },
  methods: {
    
      ...mapActions('auth', ['login']),
    async handleLogin() {
      try {
        await this.login(this.auth);
      } catch (error) {
        toastr.error(error.error);
        console.log(error);
      }
    }
  }
};
</script>