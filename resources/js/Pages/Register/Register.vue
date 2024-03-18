<template>
 <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 col-md-6 offset-md-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h1 class="text-center">Register</h1>
            <hr/>
            <el-form class="row g-3 mt-4" :model="user" :rules="formRules" ref="registerForm" @submit.native.prevent="register">
              <el-form-item class="row" prop="fullName">
                <div class="col-12">
                 <label>Full Name *</label>
                </div>
                <div class="col-12">
                 <el-input class="form-control" v-model="user.fullName" placeholder="Enter full name"></el-input>
                </div>
              </el-form-item>
              <el-form-item class="row" prop="email">
                <div class="col-12">
                 <label>Email *</label>
                </div>
                <div class="col-12">
                 <el-input class="form-control" v-model="user.email" placeholder="Enter Email"></el-input>
                </div>
              </el-form-item>
              <el-form-item class="row" prop="password">
                <div class="col-12">
                 <label>Password *</label>
                </div>
                <div class="col-12">
                 <el-input class="form-control" v-model="user.password" type="password" placeholder="Enter Password"></el-input>
                </div>
              </el-form-item>
              <el-form-item class="row" prop="password_confirmation">
                <div class="col-12">
                 <label>Confirm Password *</label>
                </div>
                <div class="col-12">
                 <el-input class="form-control" v-model="user.password_confirmation" type="password" placeholder="Enter Password"></el-input>
                </div>
              </el-form-item>
              <div class="col-12">
                <el-button type="primary" @click="handleRegister" :disabled="processing" class="btn btn-primary">
                 {{ processing ? "Please wait" : "Register" }}
                </el-button>
              </div>
              <div class="col-12 text-center">
                <label>Already have an account? <router-link :to="{name:'login'}">Login Now!</router-link></label>
              </div>
            </el-form>
          </div>
        </div>
      </div>
    </div>
 </div>

</template>

<script>
import { mapActions } from 'vuex'
import { useToastr } from "@/notification.js";

const toastr = useToastr();
export default {
    name:'register',
    data(){
        return {
            user:{
                fullName:"",
                email:"",
                password:"",
                password_confirmation:""
            },
            formRules: {
                fullName: [{ required: true, message: "Please enter full name", trigger: "blur" }],
                email: [{ required: true, message: "Please enter email", trigger: "blur" }],
                password: [{ required: true, message: "Please enter password", trigger: "blur" }],
                password_confirmation: [
                    { required: true, message: "Please enter confirm password", trigger: "blur" },
                ],
            },
            processing:false
        }
    },
    methods:{
        ...mapActions('auth', ['register']),
        async handleRegister() {
            try {
                await this.register(this.user);
                toastr.success('Register Successfully');
            } catch (error) {
                toastr.error(error.error);
                console.error(error);
            }
        }
    }
}
</script>