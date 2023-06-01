<template>
  <v-row class="p-4">
    <v-btn
      color="primary"
      dark
      @click.stop="dialog = true"
      @click="onModalPopUp()"
    >
      Reset Password
    </v-btn>

    <v-dialog v-model="dialog" max-width="1000">
      <v-card width="500">
        <v-card-title class="text-h5 text-white bg-head-change-password">
          Reset Password
        </v-card-title>
        <form @submit.prevent="resetPassword" class="m-3">
          <div class="pnclogo mb-3">
            <v-img :src="require('@/assets/reset.png')" class="pnclo"></v-img>
          </div>
        <div>
            <input
              class="form-control"
              type="password"
              placeholder="Old Password"
              v-model="oldPassword"
            />
            <span v-if="isPasswordOldNotMatch" class="text-red text-center"
              ><i class="fa-solid fa-circle-xmark"></i> Old Password is not match !!</span
            >
          </div>
          <div>
            <input
              class="form-control mt-3"
              type="password"
              placeholder="New Password"
              v-model="newPassword"
            />
          </div>
          <div>
            <input
              class="form-control mt-3"
              type="password"
              placeholder="Confirmed Password"
              v-model="confirmPassword"
            />
            <span v-if="isNotMatch" class="text-red text-center"
              ><i class="fa-solid fa-circle-xmark"></i> Password Not Match</span
            >
          </div>
          <hr />
          <div class="d-flex justify-center text-white ">
            <div>
              <button class="rounded">Reset Password</button>
            </div>
          </div>
        </form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import axios from "../../axios-http";
export default {
  data() {
    return {
      dialog: false,
      token: {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
        },
      },
      adminID: localStorage.getItem("user_id"),
      newPassword: null,
      confirmPassword: null,
      isNotMatch: false,
      isPasswordOldNotMatch:false,
      oldPassword:'',
    };
  },
  methods: {
    onModalPopUp() {
      this.dialog = true;
    },
    resetPassword() {
      if (this.newPassword != null && this.confirmPassword != null) {
        if (this.newPassword == this.confirmPassword) {
          axios.post(
            "/resetPaswordAdmin/" + this.adminID,
            { password: this.oldPassword, new_password: this.newPassword},
            
          ).then((response) => {
            if(response.data.sms == "Password updated!"){
              axios.put("/resetPaswordAdmin/"+this.adminID,
              {password:this.newPassword})
            }
            else{
              this.isPasswordOldNotMatch = true;
               this.dialog = true;
            }
          });
          this.dialog = false;
        } else {
          this.isNotMatch = true;
          this.newPassword = "";
          this.dialog = true;
          this.confirmPassword = "";
        }
      }
    },
  },
};
</script>
<style scoped>
button {
  outline: none;
  border: none;
  list-style: none;
  cursor: pointer;
  padding: 10px;
  background:  #0073ff;
}
.bg-head-change-password {
  background:  #0073ff;
}
.pnclo { 
  width: 150px;
  margin-left: 160px;
}
v-img {
  width: 90px;
}
</style>
