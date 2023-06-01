<template>
  <div class="container mt-5 ">
    <div class="main-body">
      <div class="row gutters-sm">
        <div  class="col-md-4 mb-3">
          <div style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;" class="card">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <div class="account p-1 mt-5">
                   <img class="account_image"
                   :src="dataAdmin.profile_image!=null?dataAdmin.profile_image:avataImage"
                    alt=""  >
                    <div class="update"> 
                      <label for="profile_image">
                        <img 
                        src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/camera-512.png" 
                        alt="" width="30" height="30" >
                      </label>
                       <input 
                       type="file" 
                       hidden="true"
                       id="profile_image"
                       @change="changeProfile">
                    </div>
                </div>
                <div>
                  <h4><strong> {{ dataAdmin.first_name }} {{ dataAdmin.last_name }}</strong></h4>
                  <p class="text-muted font-size-sm">
                    <strong>University: Passerell numeriques Cambodia </strong>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div  class="col-md-8">
          <div style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;" class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0"><strong>Full Name</strong></h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <strong>{{ dataAdmin.first_name }} {{ dataAdmin.last_name }}</strong>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0"><strong>Email</strong></h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <strong>{{ dataAdmin.email }}</strong>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0"><strong>age</strong></h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <strong>{{ dataAdmin.age }}</strong>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class=" d-flex ">
                  <div class="m-2">
                    <resetPasswordAdmin  ></resetPasswordAdmin>
                  </div>
                  <div class="m-2 mt-5">
                    <editAdminProfile @studentId="getUpdateId"></editAdminProfile>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Swal from 'sweetalert2'
import editAdminProfile from "./edit/EditAdminProfile.vue"
import resetPasswordAdmin from "./edit/ResetPasswordAdmin.vue"
import axios from "../axios-http";
export default {
  data() {
    return {
      url: null,
      dataAdmin: {},
      token:{headers:{ Authorization: `Bearer ${localStorage.getItem('admin_token')}`}},
      adminID:null,
    };
  },
  components:{
    resetPasswordAdmin,
    editAdminProfile
  },
  methods: {
    getUpdateId(id){
        this.adminID=id
        this.getAdminIntoProfile()
    },
    getAdminIntoProfile() {
      axios.get("/admin/" + this.adminID ,this.token).then((res) => {
        this.dataAdmin = res.data;
      });
    },
    // Select Image
    async changeProfile(event){
      console.log(this.dataAdmin.profile_image)
          Swal.fire({
              title: 'Are you want to choose this picture?',
              showCancelButton: true,
              confirmButtonText: 'Confirm',
              customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2 left-gap',
              }
            }).then((result) => {
              if (result.isConfirmed) {
                Swal.fire('Saved!', '', 'success')
                this.onUpload(event.target.files[0])
              }
          })
    },
    // uplaod image
    onUpload(profile_image){
      const profileAdmin = new FormData();
            profileAdmin.append('profile_image', profile_image)
            profileAdmin.append('_method', 'PUT')
      axios.post('/uploadProfileAdmin/'+this.adminID,profileAdmin)
      .then((response)=>{
          console.log(response)
          this.getAdminIntoProfile()
        })
    },
   
  },
  mounted() {
  
  }
};
</script>
<style scoped>
.hidden {
  display: none;
}
.border-radius {
  border-radius: 40px;
}
.account_image{
  display: block;
  width: 200px;
  height: 150px;
  height: auto;
}
</style>
