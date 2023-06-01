<template>
  <div class="bg-shodow rounded p-3 mt-5 text-white font-weight-bold">
    LIST STUDENTS
  </div>
  <!--search button-->
  <div class="ml-5 d-flex">
    <div>
      <div class="input-group mb-3 pa-3 mt-3 text-white">
        <input
          type="test"
          id="gsearch"
          class="p-2 box-shadow"
          name="gsearch"
          placeholder="Search by name"
          v-model="searchName"
        />
        <button @click="onSearchByName()"  class="bg-blue p-1 ">
          <span class="text-white">search</span>
        </button>
      </div>
    </div>
    <!-- search by batch student -->
    <div class="w-50 d-flex p-4">
      <label for="" class="w-50 mt-5">Search by batch </label>
      <select
        class="form-select p-2 box-shadow"
 
        v-model="searchByBatch"
        aria-label="Default select"
   
      >
        <option selected>All</option>
        <option value="WEP-2022-A">WEP-2022-A</option>
        <option value="WEP-2022-B">WEP-2022-B</option>
        <option value="SNA-2022">SNA-2022</option>
        <option value="WEP-2023-A">WEP-2023-A</option>
        <option value="WEP-2023-B">WEP-2023-B</option>
        <option value="SNA-2023">SNA-2023</option>
      </select>
    </div>
  </div>
  <!-- -------/register/-------- -->
  <div class="overflow-auto  w-overflow" style="height: 50vh">
    <div v-if="isBatch">
     
      <div class="m-3" v-if="filterSearchListStudent != null">
        <div
          class="m-2 card-top card h-card"
          v-for="(student, index) of filterSearchListStudent"
          :key="student"
        >
          <div class="d-flex-align h-card">
            <div class="">
              <img
                v-if="student.profile_image != ''"
                class="profile_img"
                :src="student.profile_image"
              />
              <img
                v-else
                class="profile_img"
                src="https://cdn4.iconfinder.com/data/icons/business-and-e-commerce/64/Employee_man-256.png"
                alt=""
              />
            </div>
            <div class="card-body d-flex row">
              <div class="col-sm-4 ml-0">
                <p>{{ student.first_name }} {{ student.last_name }}</p>
              </div>
              <div class="col-sm-4">
                <p class="ml-40">{{ student.batch }}</p>
              </div>
            </div>
            <div class="d-flex">
              <v-btn
                class="bg-red p-1 m-1    "
                @click.stop="dialogDelete = true"
                @click="alertDialog(index, student.id)"
              >
                <strong class="text-white "
                  ><i class="fa-solid fa-trash-can text-white m-1"></i>Delete
                </strong>
              </v-btn>
              <v-btn @click="showPopup(index)" class="bg-blue p-1  m-1  "
                ><strong class="text-white "
                  ><i class="fa-solid fa-user-plus "></i> VIEW
                </strong></v-btn
              >
            </div>
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
        </div>
      </div>
    </div>
    <div class="ml-5">
      <v-dialog v-model="dialog" width="100%">
        <v-card class="modal justify-center w-80 border-style-top" sm="6">
          <div class="img-class relative">
            <div class="d-flex flex-row-reverse">
              <div class="d-flex m-2">
                <EditStudentProfileVue
                  :id="studentnames[index].id"
                  @sendStudentData="getStudentDateEmit"
                ></EditStudentProfileVue>
                <button @click="dialog = false" class="ml-60 p-1">
                  <i class="fa-solid fa-share fa-xl mb-3"></i>
                </button>
              </div>
            </div>
            <div class="profile">
              <div>
                <div>
                  <img
                    v-if="filterSearchListStudent[index].profile_image != ''"
                    class="profile_img_account"
                    :src="filterSearchListStudent[index].profile_image"
                  />
                  <img
                    v-else
                    class="profile_img_account"
                    src="https://cdn4.iconfinder.com/data/icons/business-and-e-commerce/64/Employee_man-256.png"
                    alt=""
                  />
                </div>
                <div class="">
              
                  <p>{{ filterSearchListStudent[index].phone }}</p>
                  <p class="text-caption mt-1">
                    {{ filterSearchListStudent[index].email }}
                  </p>

                </div>
              </div>
            </div>
          </div>
  
          <v-card height="200" class="overflow-auto w-100 ">
            <v-card-text>
              <div class="mb-3 row">
                <table
                  v-if="filterSearchListStudent[index].leave != ''"
                  class="secondary text-no-wrap rounded-t-lg"
                  width="100%"
                  height="100vh"
                >
                  <tr>
                    <th>Star Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Duration</th>
                    <th>Leave Type</th>
                    <th>Status</th>
                    <th>Request Date</th>
                  </tr>
                  <tr
                    v-for="studentDetail of filterSearchListStudent[index].leave"
                    :key="studentDetail"
                  >
                    <td>{{ studentDetail.start_date }}</td>
                    <td>{{ studentDetail.end_date }}</td>
                    <td>{{ studentDetail.cause }}</td>
                    <td>{{ studentDetail.duration }}</td>
                    <td>{{ studentDetail.type }}</td>
                    <td>{{ studentDetail.status }}</td>
                    <td>{{ studentDetail.created_at }}</td>
                  </tr>
                </table>
              </div>
            </v-card-text>
          </v-card>
        </v-card>
      </v-dialog>
    </div>
  <div v-if="isName">

    <div class="m-3" v-if="filterByName != null">
      <div
        class="m-2 card-top card h-card"
        v-for="(student, index) of filterByName"
        :key="student"
      >
        <div class="d-flex-align h-card">
          <div class="">
            <img
              v-if="student.profile_image != ''"
              class="profile_img"
              :src="student.profile_image"
            />
            <img
              v-else
              class="profile_img"
              src="https://cdn4.iconfinder.com/data/icons/business-and-e-commerce/64/Employee_man-256.png"
              alt=""
            />
          </div>
          <div class="card-body d-flex row">
            <div class="col-sm-4 ml-0">
              <p>{{ student.first_name }} {{ student.last_name }}</p>
            </div>
            <div class="col-sm-4">
              <p class="ml-40">{{ student.batch }}</p>
            </div>
          </div>
          <div class="">
            <v-btn
              class="bg-red p-1 m-1"
              @click.stop="dialogDelete = true"
              @click="alertDialog(index, student.id)"
            >
              <strong class="text-white"
                ><i class="fa-solid fa-trash-can text-white m-1"></i>Delete
              </strong>
            </v-btn>
            <v-btn @click="showPopup(index)" class="bg-blue p-1 m-1"
              ><strong class="text-white"
                ><i class="fa-solid fa-user-plus"></i> VIEW
              </strong></v-btn
            >
          </div>
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
      </div>
    </div>
  </div>
  <div class="ml-5">
    <v-dialog v-model="dialog" width="100%">
      <v-card class="modal justify-center w-80 border-style-top" sm="6">
        <div class="img-class relative">
          <div class="d-flex flex-row-reverse">
            <div class="d-flex m-2">
              <EditStudentProfileVue
                :id="studentnames[index].id"
                @sendStudentData="getStudentDateEmit"
              ></EditStudentProfileVue>
              <button @click="dialog = false" class="ml-60 p-1">
                <i class="fa-solid fa-share fa-xl mb-3 "></i>
              </button>
            </div>
          </div>
          <div class="profile">
            <div>
              <div>
                <img
                  v-if="filterByName[index].profile_image != ''"
                  class="profile_img_account"
                  :src="filterByName[index].profile_image"
                />
                <img
                  v-else
                  class="profile_img_account"
                  src="https://cdn4.iconfinder.com/data/icons/business-and-e-commerce/64/Employee_man-256.png"
                  alt=""
                />
              </div>
              <p>{{ filterByName[index].phone }}</p>
              <p class="text-caption mt-1">
                {{ filterByName[index].email }}
              </p>
            </div>
          </div>
        </div>

        <v-card height="200" class="overflow-auto w-100 mt-5">
          <v-card-text>
            <div v-if="!isClick"></div>
            <div class="mb-3 row">
              <table
                v-if="filterByName[index].leave != ''"
                class="secondary text-no-wrap rounded-t-lg"
                width="100%"
                height="100vh"
              >
                <tr>
                  <th>Star Date</th>
                  <th>End Date</th>
                  <th>Reason</th>
                  <th>Duration</th>
                  <th>Leave Type</th>
                  <th>Status</th>
                  <th>Request Date</th>
                </tr>
                <tr
                  v-for="studentDetail of filterByName[index].leave"
                  :key="studentDetail"
                >
                  <td>{{ studentDetail.start_date }}</td>
                  <td>{{ studentDetail.end_date }}</td>
                  <td>{{ studentDetail.cause }}</td>
                  <td>{{ studentDetail.duration }}</td>
                  <td>{{ studentDetail.type }}</td>
                  <td>{{ studentDetail.status }}</td>
                  <td>{{ studentDetail.created_at }}</td>
                </tr>
              </table>
            </div>
          </v-card-text>
        </v-card>
      </v-card>
    </v-dialog>
  </div>
  </div>
  <div class="ml-8 mt-4">
    <FormRegisterVue :studentNames="studentnames" @sendStudents="getEmitData" />
  </div>
  <!------------------------------------------------- cardstudent -------------------------------------->
</template>

<script>
import EditStudentProfileVue from "./edit/EditStudentProfile.vue";
import axios from "../axios-http";
import FormRegisterVue from "../views/FormRegister.vue";
import swal from "sweetalert";
export default {
  name: "listStudent",
  components: {
    FormRegisterVue,
    EditStudentProfileVue,
  },
  data() {
    return {
      searchByName: "",
      searchName: "",
      searchByBatch: null,
      isBatch:true,
      isName:false,
      studentnames: [],
      dialog: false,
      index: null,
      studentid: null,
      popup: false,
      dialogDelete: false,
      aroundPage: null,
    };
  },
  methods: {
    getEmitData(students) {
      this.studentnames = students;
      this.getStudent();
    },
    getStudentDateEmit() {
      this.getStudent();
    },
    getStudent() {
      axios
        .get("/studentsInAdmin/", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
          },
        })
        .then((res) => {
          this.studentnames = res.data;
        });
    },
    onDeleteStudent() {
      this.dialogDelete = false;
      axios
        .delete("/studentsInAdmin/" + this.studentid, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
          },
        })
        .then(() => {
          this.getStudent();
          swal({
            position: "center",
            icon: "success",
            title: "Student Delete Successfully!!",
            showConfirmButton: false,
            timer: 500,
          });
        });
    },
    showPopup(index) {
      this.dialog = true;
      this.index = index;
    },
    alertDialog(index, id) {
      this.popup = true;
      this.index = index;
      this.studentid = id;
    },
    onSearchByName() {
      if (this.searchName!='') {
        this.searchByName = this.searchName;
        this.isBatch=false
        this.isName=true
      }else{
        this.searchByName =''
      }
      // this.searchName=''
    },
  },
  mounted() {
    this.getStudent();
  },
  computed: {
    //
     //search student  by batch in admin//
     //
    filterSearchListStudent() {
      let result = "";
      if (!this.searchByBatch || this.searchByBatch == "All" ) {
        return this.studentnames;
      } else {
        if(this.searchByBatch){
          console.log(this.searchByBatch);
          result = this.studentnames.filter(({ batch }) =>
          batch.toLowerCase().includes(this.searchByBatch.toLowerCase())
          );
        }
       
      }
      return result;
    },
    //
    //search student  by name in admin//
    //
    filterByName() {
      let result = "";
      if (!this.searchByName) {
        return this.studentnames;
      } else if (this.searchByName) {
        result = this.studentnames.filter(({ first_name }) =>
          first_name.toLowerCase().includes(this.searchByName.toLowerCase())
        );
      }
      return result;
    },
  },
  watch:{
    searchByBatch(){
      this.isBatch=true
      this.isName=false
    },
    searchName(){
      this.isBatch=false
      this.isName=true
    }
  }
};
</script>

<style scoped>
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}
.color-confirmed {
  background: rgb(210, 209, 209);
  padding: 10px;
  color: #666666;
}
.w-dialog-confirmed {
  width: 30%;
}
.h-card {
  height: 10vh;
}
.w-overflow {
  width: 95%;
  background: rgb(241, 238, 238);
  margin: auto;
}
li {
  list-style: none;
}
.color-icon {
  color: red;
}
.border-style-top {
  border-top: solid 10px blue;
}
.card-top {
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  border-left: solid 5px blue;
}
.bg-shodow {
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  background: #0073ff;
  width: 95%;
  margin: auto;
}
.v-btn {
  box-shadow: rgb(255, 255, 255) 0px 0px 0px 0px;
}
input {
  outline: none;
  border-bottom: solid 2px rgb(70, 70, 70);
}
.w-80 {
  width: 80%;
  margin-left: 10%;
}
.d-flex-align {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  width: 80%;
  margin: auto;
}
.card-user {
  background: rgb(189, 212, 252);
}

.profile_img {
  display: inline-block;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
}
.profile_img_account {
  display: inline-block;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
}
.card-form {
  justify-content: center;
  margin: auto;
  background: #000;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

tr {
  padding: 12px;
}
td {
  padding: 10px;
}

th {
  background: rgb(57, 57, 244);
  color: #fff;
  padding: 4px;
}
tr:nth-child(even) {
  background-color: #dddddd;
}

.modal {
  padding: 20px;
  height: auto;
  width: 800px;
}

.btn {
  width: 4%;
  margin-left: 700px;
  border-radius: 100px;
}
.btn-delete {
  border-radius: 6px;
  padding: 4px;
}
.img-class {
  height: 26vh;
}
.profile {
  text-align: center;
}

.cencel-delete {
  margin-left: 850px;
  padding: 12px;
}
.cencel {
  background: rgb(65, 117, 222);
  color: #fff;
}
.studentDelete {
  background: rgb(244, 64, 64);
  color: #fff;
}

/*--------------------------------------------- cardstundent--------------------------- */
.card-student {
  border-top: 24px solid rgb(75, 75, 249);
  box-shadow: 2px 2px 6px 1px #cccc;
  width: 90%;
}
.approv-btn {
  border: 10px solid blue;
  background: rgb(47, 47, 209);
  border-radius: 10px;
}
h5 {
  margin-top: 12px;
  color: blue;
  margin-left: 860px;
}
.box-shadow{
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
}
.btn-remove-review {
  padding-left: 10em;
}
</style>
