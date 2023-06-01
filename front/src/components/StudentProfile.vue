<template>
  <div class="container mt-5" >
    <div class="main-body">
      <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
          <div class="card card-profile">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <div class="account p-1 ">
                  <h3>Personal Data</h3>
                   <img  class="account_image"
                   :src="studentData.profile_image!=null?studentData.profile_image:avataImage"
                    alt="" >
                    <div class="update">
                      <label for="profile_image">
                        <img 
                        src="https://www.freeiconspng.com/thumbs/camera-icon/camera-icon-21.png" 
                        alt="" width="30" height="30" >
                      </label>
                       <input 
                       type="file" 
                       hidden="true"
                       id="profile_image"
                       @change="changeProfileStudent">
                    </div>
                </div>
                <div class="mt-3">
                  <h4>
                    {{ studentData.first_name }} {{ studentData.last_name }}
                  </h4>
                  <p class="text-primary mb-1">Major: IT</p>
                  <p class="text-muted font-size-sm ">
                    <strong>University: Passerell numeriques Cambodia </strong>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card mb-3 card-list-info">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0"><strong>Full Name:</strong></h6>
                </div>
                <div class="col-sm-9 text-primary">
                 <strong> {{ studentData.first_name }} {{ studentData.last_name }}</strong>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3  ">
                  <h6 class="mb-0 mr-5"><strong>Email:</strong></h6>
                </div>
                <div class="col-sm-9 text-primary">
                  <strong>{{ studentData.email }}</strong> 
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0"><strong>Sex:</strong></h6>
                </div>
                <div class="col-sm-9 text-primary">
                  <strong>{{ studentData.gender }}</strong>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0"><strong>Batch:</strong></h6>
                </div>
                <div class="col-sm-9 text-primary">
                  <strong>{{ studentData.batch }}</strong>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0"><strong>Phone:</strong></h6>
                </div>
                <div class="col-sm-9 text-primary">
                  <strong>{{ studentData.phone }}</strong>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-12  ">
                  <resetPasswordStudent></resetPasswordStudent>
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
import axios from "../axios-http";
import Swal from 'sweetalert2'
import resetPasswordStudent from "../components/edit/ResetPasswordStudent.vue";
export default {
  data() {
    return {
      url: null,
      studentData: {},
      name_img: "",
      imageToDisplay:
        "https://cahsi.utep.edu/wp-content/uploads/kisspng-computer-icons-user-clip-art-user-5abf13db5624e4.1771742215224718993529.png",

      imageFile: null,
      studentId: localStorage.getItem("student_id"),
      token: {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("student_token")}`,
        },
      },
    };
  },
  components: {
    resetPasswordStudent,
  },
  methods: {
    // getEmitIdStudent(){

    // },
    getStudentIntoProfile() {
      axios.get("/students/" + this.studentId, this.token).then((res) => {
        this.studentData = res.data[0];
      });
    },
    // Select Image
    async changeProfileStudent(event){
      console.log(this.studentData.profile_image)
          Swal.fire({
              title: 'Are you sure, to select it?',
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
              }else {
                console.log('Cancled')
              }
          })
    },
    // uplaod image
    onUpload(profile_image){
      const profileStudent = new FormData();
            profileStudent.append('profile_image', profile_image)
            profileStudent.append('_method', 'PUT')
      axios.post('/updateProfile/'+this.studentData.id,profileStudent)
      .then((response)=>{
          console.log(response)
          this.getStudentIntoProfile()
        })
    },
  },
  mounted() {
    this.getStudentIntoProfile();
  },
};
</script>
<style scoped>
.hidden {
  display: none;
}
.border-radius {
  border-radius: 40px;
}
.card-profile {
  height: 77vh;
  border-top: 5px solid #0073ff;

  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
}
.card-list-info {
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  border-left: 5px solid #0073ff;
}
.account_image{
  display: inline-block;
  width: 150px;
  height: 150px;
  object-fit: fill;
}
</style>
