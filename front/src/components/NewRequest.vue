<template>
  <div>
    <form @submit.prevent="addRequest">
      <h3 class="text-center pb-2">Request Leave Form</h3>
      <div class="form">
        <div class="form-input">
          <p>Type leave :</p>
          <select
            class="cars form-select"
            placeholder="Name"
            v-model="typeLeave"
            required
          >
            <option value="Family's event">Family's event</option>
            <option value="Sick leave">Sick leave</option>
            <option value="Brother or Sister Marriage">
              Brother or Sister Marriage
            </option>
          </select>
          <p>Start Date :</p>
          <div class="time">
            <input
              type="date"
              v-model="Start_Day"
              :min="getCurrentDate()"
              required
            />
            <div class="date">
              <select class="time-d form-select" v-model="start_time" required>
                <option value="Morning">Morning</option>
                <option value="Afternoon">Afternoon</option>
              </select>
            </div>
          </div>
          <p>End Date :</p>
          <div class="time">
            <input type="date" v-model="End_Day" :min="Start_Day" required />
            <div class="date">
              <select class="time-d form-select" v-model="end_time" required>
                <option value="Morning" v-if="isValidTime">Morning</option>
                <option value="Afternoon">Afternoon</option>
              </select>
            </div>
          </div>
        </div>
        <div class="reason">
          <h5>
            Duration: <span>{{ calculateDuration }} days</span>
          </h5>
          <p>Cause (Reason)</p>
          <textarea
            class="text-reason"
            placeholder="text"
            v-model="cause"
          ></textarea>
        </div>
      </div>
      <div class="bt text-center">
        <button class="btn btn-primary bg-style-color" type="submit">Submit</button>
      </div>
    </form>
  </div>
</template>
<script>
import router from "@/router";
import axios from "../axios-http.js";
export default {
  data() {
    return {
      typeLeave: "",
      Start_Day: null,
      End_Day: null,
      status: "pending",
      start_time: null,
      end_time: null,
      duration: null,
      cause: null,
      isValidTime: true,
      studentLists:[],
      adminId:null,
      studentId: localStorage.getItem("student_id"),
      token: {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("student_token")}`,
        },
      },
    };
  },
  methods: {
   
    addRequest() {
      if (
        this.typeLeave != null &&
        this.Start_Day != null &&
        this.End_Day != null &&
        this.start_time != null &&
        this.end_time != null
      ) {
        axios
          .post("/leaves",{
            type: this.typeLeave,
            start_date: this.Start_Day,
            end_date: this.End_Day,
            status: this.status,
            duration: this.changeDuration(),
            cause: this.cause,
            student_id: this.studentId,
            admin_id: this.adminId.id,
          },this.token)
          .then(() => {
            console.log("Add successfully");
          });
        router.push("/dashboard");
      }
      this.sendEmail();
    },
    sendEmail() {
      axios.get("/send-mail").then((response) => {
        console.log(response.data);
      });
    },
    changeDuration() {
      const baseTime =
        (new Date(this.End_Day).getTime() -
          new Date(this.Start_Day).getTime()) /
        (1000 * 3600 * 24);
      if (
        this.Start_Day !== null &&
        this.End_Day !== null &&
        this.start_time !== null &&
        this.end_time !== null
      ) {
        if (this.start_time === this.end_time) {
          this.duration = baseTime + 0.5;
        } else if (
          this.Start_Day === this.End_Day &&
          this.start_time === "Morning" &&
          this.end_time === "Afternoon"
        ) {
          this.duration = baseTime + 1;
        } else if (
          this.start_time === "Morning" &&
          this.end_time === "Afternoon"
        ) {
          this.duration = baseTime + 1;
        }
      }
      if (this.Start_Day === this.End_Day && this.start_time === "Afternoon") {
        this.isValidTime = false;
      }
      return this.duration;
    },
    getCurrentDate() {
      var date = new Date();
      var tdate = date.getDate();
      var month = date.getMonth() + 1;
      if (tdate < 10) {
        tdate = "0" + tdate;
      }
      if (month < 10) {
        month = "0" + month;
      }
      var year = date.getFullYear();
      var minDate = year + "-" + month + "-" + tdate;
      return minDate;
    },
    getAdminId(){
      axios.get('/getAdminId',this.token).then((res)=>{{
        this.adminId = res.data[0]
      }})
    }
  },
  computed: {
    calculateDuration() {
      return this.changeDuration();
    },
  },
  mounted(){
    this. getAdminId()
  }
};
</script>

<style scoped>
form {
  margin-top: 30px;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  width: 60%;
  margin: auto;
  padding-bottom: 40px;
  border-radius: 10px;
}
.dateInput {
  border: 1px solid rgba(0, 0, 0, 0.25);
}
.form {
  border-top: blue;
  display: flex;
  margin-top: 20px;
  padding: 40px;
}
.form-input {
  border-radius: 9px;
  width: 70%;
}
.cars,
input[type="date"] {
  border-radius: 4px;
  padding: 5px 5px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 1px solid rgb(111, 111, 140);
  width: 84%;
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
}
.time-d {
  border: 1px solid;
  padding: 5px 5px;
  border-radius: 4px;
}
span {
  color: red;
}
input[type="date"] {
  width: 50%;
}
h3 {
  justify-content: center;
  text-align: center;
  color: blue;
  /* line-height:0.1; */
  display: block;
  margin-top: 30px;
  padding: 10px;
}
.text-reason {
  width: 100%;
  height: 32vh;
  padding: 10px 15px;
  box-sizing: border-box;
  border: 1px solid rgb(8, 8, 8);
  border-radius: 4px;
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
}
.reason {
  width: 60%;
  margin-right: 20px;
}
.time {
  display: flex;
  width: 100%;
}
.form-input {
  margin-top: 25px;
}
.time-d {
  margin-top: 8px;
  margin-left: 20px;
  width: 100%;
}
p {
  /* margin-top: 5px; */
  font-weight: bold;
  line-height: 0.5;
}
bt {
  display: inline-block;
}
.bg-style-color{
  color: white;
}
select{
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
}
h3 {
  background:#0073ff;
  color: azure;
}
</style>
