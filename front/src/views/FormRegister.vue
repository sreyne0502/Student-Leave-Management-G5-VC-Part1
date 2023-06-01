<template>
  <div
    class="modal fade"
    id="exampleModalToggle"
    aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel"
    tabindex="-1"
    data-bs-keyboard="false"
    data-bs-backdrop="static"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background: #0073ff">
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="clearInfo()"
          ></button>
        </div>
        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 mt-4 text-center">
          Registration Form
        </h3>
        <form class="p-4" @submit.prevent="addStudent">
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <input
                  type="text"
                  id="firstName"
                  class="form-control form-control-lg"
                  placeholder="First Name"
                  required
                  v-model="firstName"
                />
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <input
                  type="text"
                  id="lastName"
                  class="form-control form-control-lg"
                  placeholder="Last Name"
                  required
                  v-model="lastName"
                />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-4 d-flex align-items-center">
              <select
                class="form-select form-select-lg"
                required
                v-model="batch"
              >
                <option
                  :value="batch"
                  v-for="batch in batchCategories"
                  :key="batch"
                >
                  {{ batch }}
                </option>
              </select>
            </div>
            <div class="col-6 mb-4 text-left">
              <h5 class="mb-2">Gender:</h5>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="inlineRadioOptions"
                  id="femaleGender"
                  value="female"
                  v-model="gender"
                />
                <label class="form-check-label" for="femaleGender"
                  >Female</label
                >
              </div>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="inlineRadioOptions"
                  id="maleGender"
                  value="male"
                  v-model="gender"
                />
                <label class="form-check-label" for="maleGender">Male</label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="inlineRadioOptions"
                  id="otherGender"
                  value="other"
                  v-model="gender"
                />
                <label class="form-check-label" for="otherGender">Other</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-4 pb-2">
              <div class="form-outline">
                <input
                  type="email"
                  id="emailAddress"
                  class="form-control form-control-lg"
                  placeholder="Email"
                  required
                  v-model="email"
                />
              </div>
              <p class="text-danger" v-if="checkExist[0]">
                This email already exist.
              </p>
              <p class="text-danger" v-if="!checkPasserelles">
                Need to be passerelles mail.
              </p>
            </div>
            <div class="col-md-6 mb-4 pb-2">
              <div class="form-outline">
                <div class="d-flex align-center">
                  <div class="rounded-left bg-secondary number">
                    <span class="text-white leading">+855</span>
                  </div>
                  <input
                    type="text"
                    id="phoneNumber"
                    class="form-control number"
                    placeholder="Phone Number"
                    v-model="phoneNumber"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    required
                    maxlength="9"
                  />
                </div>
                <p class="text-danger" v-if="checkExist[1]">
                  This phone number already exist.
                </p>
              </div>
            </div>
          </div>
          <div class="mt-4 pt-2 text-center">
            <input
              class="btn btn-primary btn-lg"
              type="submit"
              value="Register"
              data-bs-dismiss="modal"
              :disabled="!checkAll"
            />
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="">
    <a
      class="btn btn-primary text-white"
      data-bs-toggle="modal"
      href="#exampleModalToggle"
      role="button"
      >Create Student</a
    >
  </div>
</template>

<script>
// import router from "@/router"
import axios from "../axios-http.js";
import swal from "sweetalert";
export default {
  data() {
    return {
      batchCategories: [
        "WEP-2022-A",
        "WEP-2022-B",
        "SNA-2022",
        "WEP-2023-A",
        "WEP-2023-B",
        "SNA-2023",
      ],
      firstName: "",
      lastName: "",
      email: "",
      phoneNumber: "",
      batch: "",
      gender: "",
      password: "12345678",
      profile: "",
      admin_id: localStorage.getItem("user_id"),
      isRequired: false,
      existEmail: false,
      existPhone: false,
      allRequired: false,
      alreadyExistMail: false,
      alreadyExistPhone: false,
      isPasserelles:false,
      token: {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
        },
      },
    };
  },
  props: ["studentNames"],
  methods: {
    onEmitData(){
        axios
        .get("/studentsInAdmin/", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
          },
        })
        .then((res) => {
          this.$emit('sendStudents',res.data)
        });
    },
    checkMail(){
      let index = this.email.indexOf('@');
      let endEmail = this.email.substring(index,this.email.length)
      if(endEmail=="@student.passerellesnumeriques.org"){
        this.isPasserelles=true
      }
      return this.isPasserelles;
    },
    clearInfo() {
      this.firstName = "";
      this.lastName = "";
      this.email = "";
      this.phoneNumber = "";
      this.batch = "";
      this.gender = "";
    },
    smlsMail(){
      axios.post("/account-smls",
      {
        'email':this.email,
      })
      .then((response)=>{
        console.log(response.data);
      })
    },
    addStudent() {
      if (this.isRequired) {
        if (this.gender == "female") {
          this.profile = "https://cdn4.iconfinder.com/data/icons/people-avatar-filled-outline/64/girl_female_young_people_woman_teenager_avatar-512.png";
        } else if (this.gender == "male") {
          this.profile = "https://cdn2.iconfinder.com/data/icons/avatar-32/1000/18-256.png";
        } else {
          this.profile = "https://cdn0.iconfinder.com/data/icons/avatars-3/512/avatar_basketball_guy-512.png";
        }
        if (!this.checkExist[0] && !this.checkExist[1] && this.isPasserelles) {
          axios
            .post(
              "/studentsInAdmin/",
              {
                first_name: this.firstName,
                last_name: this.lastName,
                email: this.email,
                phone: "0" + this.phoneNumber,
                password: this.password,
                batch: this.batch,
                gender: this.gender,
                admin_id: this.admin_id,
                profile_image: this.profile,
              },
              this.token
            )
            .then(() => {
              swal({
                position: "center",
                icon: "success",
                title: "Student Registered Successfully!!",
                showConfirmButton: false,
                timer: 1500,
              });
              this.onEmitData()
            });
              this.smlsMail();
            this.clearInfo();
            this.onEmitData()
        }
      }
    },
    getFilled() {
      if (this.gender != "") {
        this.isRequired = true;
      }
      return this.isRequired;
    },
    checkRequired() {
      if (
        this.getAllData &&
        !this.checkExist[0] &&
        !this.checkExist[1] &&
        this.email != "" &&
        this.phoneNumber != ""
      ) {
        this.allRequired = true;
      }
      return this.allRequired;
    },
    checkExisting() {
      this.studentNames.forEach((student) => {
        if (student.email == this.email) {
          this.existEmail = true;
          this.alreadyExistMail = true;
        } else if (!this.alreadyExistMail) {
          this.existEmail = false;
        }
        if (student.phone == "0" + this.phoneNumber) {
          this.existPhone = true;
          this.alreadyExistPhone = true;
        } else if (!this.alreadyExistPhone) {
          this.existPhone = false;
        }
      });
      this.alreadyExistMail = false;
      this.alreadyExistPhone = false;
      console.log([this.existEmail, this.existPhone]);
      return [this.existEmail, this.existPhone];
    },
  },

  computed: {
    getAllData() {
      return this.getFilled();
    },
    checkExist() {
      return this.checkExisting();
    },
    checkAll() {
      return this.checkRequired();
    },
    checkPasserelles(){
      return this.checkMail();
    }
  },
};
</script>

<style scoped>
.number {
  padding: 13px;
}
</style>
