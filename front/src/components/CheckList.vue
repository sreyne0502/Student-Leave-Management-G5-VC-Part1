<template>
  <AdminStatusVue
    :studentName="listStudent"
    :listLeaves="allLeave"
    @sendAdminStatus="getStatusFromAdmin"
  ></AdminStatusVue>
  <div class="m-5">
    <v-card height="450" class="overflow-auto w-100 box-shadow-color">
      <div id="accordion" class="card-group-collapse pa-10">
        <div v-if="isRejected">
          <CardAdminAllow
            v-for="(reject, index) in listRejected"
            :key="index"
            :index="index"
            class="border-left-color"
          >
            <template #icon-confirm>
              <span class="m-4"
                ><i class="fa-solid fa-circle-xmark fa-2xl text-red"></i
              ></span>
            </template>
            <template #displayName>
              <div
                class="d-flex"
                v-for="getStudentId in listStudent"
                :key="getStudentId"
              >
                <v-img
                  src="https://mpng.subpng.com/20180404/sqe/kisspng-computer-icons-user-profile-clip-art-big-5ac5283827d286.2570974715228703281631.jpg"
                ></v-img>
                <div class="d-flex justify-content-center flex-column">
                  <li v-if="reject.student_id == getStudentId.id">
                    <span class="fw-bold">
                      <strong
                        >{{ getStudentId.first_name }}
                        {{ getStudentId.last_name }}</strong
                      >
                    </span>
                  </li>
                  <li
                    v-if="reject.student_id == getStudentId.id"
                    class="fw-bold text-green"
                  >
                    <strong>{{ getStudentId.batch }}</strong>
                  </li>
                </div>
              </div>
            </template>
            <template #alert>
              <span class="text-red"
                >You had <strong>rejected</strong> your student</span
              >
            </template>
            <template #startDate>{{ reject.start_date }}</template>
            <template #endDate>{{ reject.end_date }}</template>
            <template #cause>{{ reject.cause }}</template>
            <template #duration>{{ reject.duration }}</template>
            <template #type>{{ reject.type }}</template>
            <template #requestDate> {{ reject.created_at }}</template>
          </CardAdminAllow>
        </div>
        <div v-if="isApproved">
          <CardAdminAllow
            v-for="(approve, index) in listApproved"
            :key="index"
            :index="index"
            class="border-top-approved"
          >
            <template #icon-confirm>
              <span class="m-4"
                ><i class="fa-solid fa-circle-check fa-2xl text-green"></i
              ></span>
            </template>
            <template #displayName>
              <div
                class="d-flex"
                v-for="getStudentId in listStudent"
                :key="getStudentId"
              >
                <v-img v-if="approve.student_id == getStudentId.id">{{
                  getStudentId.profile_img
                }}</v-img>

                <div class="d-flex justify-content-center flex-column">
                  <li v-if="approve.student_id == getStudentId.id">
                    <span class="fw-bold">
                      <strong
                        >{{ getStudentId.first_name }}
                        {{ getStudentId.last_name }}</strong
                      >
                    </span>
                  </li>
                  <li
                    v-if="approve.student_id == getStudentId.id"
                    class="fw-bold text-green"
                  >
                    <strong>{{ getStudentId.batch }}</strong>
                  </li>
                </div>
              </div>
            </template>
            <template #alert>
              <span class="text-green"
                >You had <strong>approved</strong> your student</span
              >
            </template>
            <template #startDate>{{ approve.start_date }}</template>
            <template #endDate>{{ approve.end_date }}</template>
            <template #cause>{{ approve.cause }}</template>
            <template #duration>{{ approve.duration }}</template>
            <template #type>{{ approve.type }}</template>
            <template #requestDate>{{ approve.request_date }}</template>
            <template #statusAllow>
              <button class="bg-success btn fw-bold text-white">
                {{ approve.status }}
              </button></template>
        
          </CardAdminAllow>
        </div>

        <div v-if="isPending" >
          <div
            class="card"
            v-for="(value, index) in listPendingLeave"
            :key="value"
          >
            <v-progress-linear
              color="green"
              indeterminate
              reverse
            ></v-progress-linear>
            <div class="card-header color-style" id="headingOne">
              <div class="d-flex justify-content-between">
                <ul class="space-img">
                  <div class="textli" v-for="getId in listStudent" :key="getId">
                    <div class="d-flex">
                      <li v-if="value.student_id == getId.id">
                        <img
                          class="profile mt-3"
                          :src="getId.profile_image"
                        >
                      </li>
                      <div
                        class="d-flex justify-content-center mt-3 flex-column"
                      >
                        <li>
                          <span
                            class="fw-bold"
                            v-if="value.student_id == getId.id"
                            >{{ getId.first_name }} {{ getId.last_name }}</span
                          >
                        </li>
                        <li
                          class="fw-bold text-green"
                          v-if="value.student_id == getId.id"
                        >
                          {{ getId.batch }}
                        </li>
                      </div>
                    </div>
                  </div>
                </ul>
                <div class="button ">
                  <a
                    class="btn btn-link nav-button"
                    data-toggle="collapse"
                    :data-target="'#' + index"
                    aria-expanded="true"
                    aria-controls="index"
                  >
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <button
                    class="bg-danger btn text-white"
                    @click="changeStatus('rejected', value.id,value.student_id)"
                  >
                    Rejected
                  </button>

                  <button
                    class="bg-success btn"
                    @click="changeStatus('approved', value.id,value.student_id)"
                  >
                    Approved
                  </button>
                </div>
              </div>
            </div>

            <div
              :id="index"
              class="collapse hidden"
              aria-labelledby="headingOne"
              data-parent="#accordion"
            >
                    <div class="row p-3">
                      <div class="col-sm-5 d-flex">
                        <p class="fw-bold m-1">Star Date: </p> <p class="m-1">{{ value.start_date }}</p>
                      </div>
                      <div class="col-sm-5 d-flex">
                        <p class="fw-bold m-1">End Date: </p> <p class="m-1">{{ value.end_date }}</p>
                      </div>
                      <div class="col-sm-5 ml-left d-flex">
                        <p class="fw-bold m-1">Duration: </p> <p class="m-1">{{ value.duration }}</p>
                      </div>
                      <div class="col-sm-5 d-flex">
                        <p class="fw-bold m-1">Leave Type: </p> <p class="m-1">{{ value.type }}</p>
                      </div>
                      <div class="col-sm-5 d-flex">
                        <p class="fw-bold m-1">Request Date: </p> <p class="m-1">{{ value.created_at }}</p>
                      </div>
                      <div class="col-sm-5 d-flex">
                        <p class="fw-bold m-1">Reason: </p> <p class="m-1">{{ value.cause }}</p>
                      </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </v-card>
  </div>
<div class="ma-auto">
          <v-row class="d-flex justify-content-center">
            <v-dialog
              v-model="dialogDelete"
              class="w-dialog-confirmed mlp4 m-auto"
            >
              <v-card>
                <v-card-title class="text-h5 color-confirmed">
                  Confirmed
                </v-card-title>

                <v-card-text class="text-red">
                  Are you sure want to delete student?
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>

                  <v-btn
                    color="green darken-1"
                    text
                    @click="dialogDelete = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn @click="onDeleteStudent()">
                    <p>DELETE</p>
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </div>      
</template>
<script>
  import Swal from 'sweetalert2'
import CardAdminAllow from "./status/CardAdminAllow.vue";
import AdminStatusVue from "./AdminStatus.vue";
import axios from "../axios-http";
export default {
  name:'checkList',
  components: {
    CardAdminAllow,
    AdminStatusVue,
  },
  data() {
    return {
      listPendingLeave: [],
      allLeave: [],
      listApproved: [],
      listRejected: [],
      listStudent: [],
      dialog: false,
      isApproved: false,
      isRejected: false,
      isPending: true,
      isPendingTry: localStorage.getItem("sendPending"),
      isGet:null,
    
    };
  },

  methods: {
    onGetAllStudent() {
      axios.get("/students",{headers:{ Authorization: `Bearer ${localStorage.getItem('admin_token')}`}}).then((res) => {
        this.listStudent = res.data;
        for (let studentData of res.data) {
          for (let leaveStudent of studentData.leave) {
            this.allLeave.push(leaveStudent);
            if (leaveStudent.status == "pending") {
              this.listPendingLeave.push(leaveStudent);
            } else if (leaveStudent.status == "approved") {
              this.listApproved.push(leaveStudent);
            } else if (leaveStudent.status == "rejected") {
              this.listRejected.push(leaveStudent);
            }
          }
        }
      });
    },
    getStatusFromAdmin(status) {
      if (status == "Rejected") {
        localStorage.setItem("sendPending", false);
        this.isApproved = false;
        this.isRejected = true;
        this.isPending = false;
      } else if (status == "Approved") {
        this.isApproved = true;
        this.isRejected = false;
        this.isPending = false;
        localStorage.setItem("sendPending", false);
      }else if (status == "Student"){
        this.$router.push('/listStudent')
      }
    },
    rejectEmail(id){
      let body =  {
        email: this.email,
      }
      axios.post('/reject-mail/'+ id, body)
      .then((response) =>{
        console.log(response.data)
      })
    },
    approvedEmail(id)
    {
      let body = {
        email: this.email,
      }
      axios.post('/approved-mail/'+ id, body)
      .then((response) =>{
        console.log(response.data);
      })
    },
    changeStatus(statusLeave, index,studentId) {
      if (statusLeave == "rejected") {
        Swal.fire({
          title: 'Are you sure you want to reject?',
          showCancelButton: true,
          confirmButtonText: 'Rejected',
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire('Rejected is successful !', '', 'success')
            this.listPendingLeave.splice(statusLeave,1)
            axios.put("/leaves/" + index, { status: statusLeave },{headers:{ Authorization: `Bearer ${localStorage.getItem('admin_token')}`}});
            this.rejectEmail(studentId);
          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }
        })
      } else {
        this.listPendingLeave.splice(statusLeave,1)
        axios.put("/leaves/" + index, { status: statusLeave },{headers:{ Authorization: `Bearer ${localStorage.getItem('admin_token')}`}});
        this. approvedEmail(studentId)
      }
    },
    getPending() {
      console.log(localStorage.getItem("sendPending"))
    },
  },
  mounted() {
    this.onGetAllStudent();
  },
  computed: {
    getPend(){
      return this.isPendingTry
    }
  },
  watch:{
    isPendingTry(){
      this.isApproved=false
      this.isRejected= false
      this.isPending=true
    }
  },
};
</script>

<style scoped>
h2 {
  height: 10vh;
}
ul {
  display: flex;
}
.btn {
  padding: 5px;
}
.button {
  display: flex;
  align-items: center;
  font-weight: 60px;
  padding: 14px;
}
button {
  margin-left: 20px;
  border: none;
}
.nav-button {
  text-decoration: none;
}
.profile {
  display: inline-block;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
}
ul.space-img {
  list-style: none;
}
span {
  margin-top: 5px;
  font-size: 18px;
}
.card-group-collapse {
  margin: 20px 60px 60px 60px;
}
.color-style {
  border-left: 3px blue solid;
}
li {
  list-style-type: none;
}
.border-left-color {
  border-top: 5px solid red;
}
.border-top-approved {
  border-top: solid green 5px;
}
.box-shadow-color {
  background: rgb(245, 241, 241);
}
</style>
