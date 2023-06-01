<template>
  <div class="container d-flex justify-content-center">
    <div class="pnclogo mt-2">
      <v-img :src="require('@/assets/logo.jpg')" class="pnclo"></v-img>
      <h2>SMLS</h2>
    </div>
    <form @submit.prevent="loginUser">
      <div>
        <h2>Student Leave Management System</h2>
      </div>
      <div class="inp">
        <input
        class="border"
          type="text"
          id="email"
          name="Email"
          placeholder="Email"
          v-model="email"
        />
        <div class="d-flex ">
          <input 
          class="border"
            type="password"
            id="myInput"
            name="Password"
            placeholder="Password"
            v-model="password"
          />
          
          <span class="mt-2 mb-2 border-eye d-flex flex-column justify-content-center" @click="myFunction()">
            <i
              class="fas"
              :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"
            ></i
          ></span>

        </div>
        <button class="mt-3">login</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "../axios-http.js";
import Swal from "sweetalert2"
export default {
  components: {},
  data() {
    return {
      email: null,
      emailEnter: null,
      isTrue: false,
      password: "",
      admin: [],
      students: [],
      studentId:{},
      dataCheck: [],
      role: "",
      isStudent: false,
      isTeacher: false,
      studentIndex: null,
      token: null,
      showPassword:false
    };
  },
  methods: {
    loginUser() {
      if (this.email !== "" && this.password !== "") {
        let loginInfo = { email: this.email, password: this.password };
        this.checkStudent();
        if (this.admin[0].email == this.email) {
          axios.post("/login", loginInfo).then((response) => {
            console.log(response.data.sms)
            if(response.data.sms == "Invalid Password"){
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Invalid Password',
                showConfirmButton: false,
                timer: 1000
              })
            }else{
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Login Successfully',
                showConfirmButton: false,
                timer: 1000
              })
              this.$router.push("/listStudent");
              localStorage.setItem("user_id", this.admin[0].id);
              localStorage.setItem("admin_token", response.data.token);
            }
          });
        } else if (this.isStudent) {
          axios.post("/loginStudent", loginInfo).then((response) => {
            if(response.data.sms == "Invalid Password"){
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Invalid Password',
                showConfirmButton: false,
                timer: 1000
              })
            }else if(response.data.sms == "Invalid Email"){
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Invalid Email',
                showConfirmButton: false,
                timer: 1000
              })
            }else{
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Login Successfully',
                showConfirmButton: false,
                timer: 1000
              })
              console.log(response,"token student");
              localStorage.setItem("student_id",this.studentId.id);
              localStorage.setItem("student_token", response.data.token);
              this.$router.push("/dashboard");
            }
          });
        }else{
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Invalid Email',
            showConfirmButton: false,
            timer: 1000
          })
        }
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Need to fill in all required fields',
          showConfirmButton: false,
          timer: 1000
        })
      }
    },
    myFunction() {
      let x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
        this.showPassword =true;
      } else {
        x.type = "password";
        this.showPassword =false ;
      }
    },
    getStudents() {
      axios.get("/studentCompare").then((response) => {
        this.students = response.data;
      });
    },
    getAdmin() {
      axios.get("/admin").then((response) => {
        this.admin = response.data;
      });
    },
    checkStudent() {
      this.students.forEach((student) => {
        if (student.email == this.email) {
          this.studentId = student
          this.isStudent = true;
      
        }
      });
    },
  },
  computed: {
    getAllStudents() {
      return this.getStudents();
    },
    getAllAdmin() {
      return this.getAdmin();
    },
  },
  mounted() {
    this.getAdmin();
    this.getStudents();
  },
};

</script>

<style scoped>
*{
  background-image: url();
}
.pnclo {
  width: 150px;
}
.pnclogo {
  padding: 20px;
}
v-img {
  width: 90px;
}
p {
  font-weight: bold;
  text-align: center;
}
h2 {
  text-align: center;
  color: blue;
  padding-bottom: 20px;
}
input[type="text"],
input[type="password"],
select {
  width: 100%;
  padding: 10px 20px;
  margin: 8px 0;
  display: inline-block;

  border-radius: 5px;
  box-sizing: border-box;
  outline: none;
}
input:hover {
  background: rgb(224, 229, 255);
}
.showpassword {
  margin-right: 5px;
  background-color: red;
}
button {
  width: 40%;
  background-color: #2600ff;
  color: white;
  padding: 10px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-left: 30%;
}
button:hover {
  background-color: #000000;
  color: white;
}
.container {
  width: 60%;
  padding: 30px;
  border-radius: 12px;
  border-top: 10px solid blue;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px,
    rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  margin-top: 180px;
}
.border-eye{
  border: solid 1px rgb(161, 161, 161);
  border-radius:0px 5px 5px 0px;
}
.border-left{
  
  border-radius:5px 0px 5px 0px;
}
</style>
