<template>
  <StudentStatusVue @sendStatus="checkStatus" :listLeaves="studentLists">
  </StudentStatusVue>
  <div class="ml-5 d-flex  ">
    <div class="w-25 d-flex p-2 ml-8">
      <select style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;"
        class="form-select p-2 box-shadow"
        v-model="searchByType"
        aria-label="Default select"
        
      >
        <option  selected>All</option>
        <option value="Sick leave">Sick leave</option>
        <option value="Family's event">Family's event</option>
        <option value="Brother or Sister Marriage">Brother or Sister Marriage</option>
        <option value="Party">Party</option>
      </select>
    </div>

  </div>
  <div class="row col-sm-5 ">

    <div class=" row  col-md-11 ">
      <div class=" col-sm-7  bg-list-type-style p-2 rounded ">
        <span class=" text-white"><strong>List Types</strong> </span>
    
      </div>
    
    </div>
  </div>

  <div class="mt-3" v-if="!isType">
    <div id="wrapper" class="d-flex justify-content-center">
      <table>
        <thead>
          <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Duration</th>
            <th>Types</th>
            <th>Status</th>
            <th>Request Date</th>
          </tr>
        </thead>
        <tbody class="">
          <tr v-for="student in filterSearchListStudent" :key="student">
            <td>{{ student.end_date }}</td>
            <td>{{ student.start_date }}</td>
            <td>{{ student.cause }}</td>
            <td>{{ student.duration }}</td>
            <td>{{ student.type }}</td>
            <td>
              <span :style="changeColorStatus(student.status)">{{
                student.status
              }}</span>
            </td>
            <td>{{ student.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="" v-if="isStatus">
    <div id="wrapper" class="d-flex justify-content-center">
      <table>
        <thead>
          <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Duration</th>
            <th>Types</th>
            <th>Status</th>
            <th>Request Date</th>
          </tr>
        </thead>
        <tbody class="">
          <tr v-for="student in filterCheckStatus" :key="student">
            <td>{{ student.end_date }}</td>
            <td>{{ student.start_date }}</td>
            <td>{{ student.cause }}</td>
            <td>{{ student.duration }}</td>
            <td>{{ student.type }}</td>
            <td>
              <span class="box-Shadonw-status" :style="changeColorStatus(student.status)">{{
                student.status
              }}</span>
            </td>
            <td>{{ student.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import StudentStatusVue from "./StudentStatus.vue";
import axios from "../axios-http.js";
export default {
  components: {
    StudentStatusVue,
  },
  data() {
    return {
      studentLists: [],
      searchByType: null,
      searchStatus: null,
      isType:false,
      isStatus:false,
      padding: null,
      studentId: localStorage.getItem("student_id"),
      token: {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("student_token")}`,
        },
      },
    };
  },
  methods: {
    changeColorStatus(status) {
      if (status == "rejected") {
        return {
          backgroundColor: "red",
          color: "white",
          fontWeight: "bold",
          paddingLeft: 9+ "px",
          paddingTop: 4+ "px",
          paddingBottom: 4+ "px",
          paddingRight: 9+ "px",
          borderRadius: 4 + "px",
        };
      } else if (status == "approved") {
        return {
          backgroundColor: "green",
          color: "white",
          fontWeight: "bold",
          padding: 4 + "px",
          borderRadius: 4 + "px",
        };
      } else if (status == "pending") {
        return {
          backgroundColor: "orange",
          color: "white",
          padding: 4 + "px",
          borderRadius: 4 + "px",
          paddingLeft: 9+ "px",
          paddingTop: 4+ "px",
          paddingBottom: 4+ "px",
          paddingRight: 9+ "px",
        };
      }
    },
    checkStatus(status) {
      this.searchStatus = status;
      this.isStatus = true;
    },
    fetchDataStudent() {
      axios.get("/leaves/", this.token).then((res) => {
        for (let leave of res.data) {
          if (leave.student_id == this.studentId) {
            this.studentLists.push(leave);
          }
        }
      });
    },
  },

  computed: {
    filterSearchListStudent() {
      if (!this.searchByType || this.searchByType == "All") {
        return this.studentLists;
      } else {
        return this.studentLists.filter(({ type }) =>
          type.toLowerCase().includes(this.searchByType.toLowerCase())
        );
      }
    },
    filterCheckStatus() {
      if (!this.searchStatus) {
        return this.studentLists;
      } else {
        return this.studentLists.filter(({ status }) =>
          status.toLowerCase().includes(this.searchStatus.toLowerCase())
        );
      }
    },
  },
  async mounted() {
    this.fetchDataStudent();
  },
  watch:{
    searchByType(){
      this.isType=false
      this.isStatus=false
      console.log(this.isType);
    },
    searchStatus(){
      this.isType=true
      this.isStatus=true
      console.log(this.isType);
    }
   
  }
};
</script>

<style scoped>
label {
  font-size: 20em;
  font-weight: bold;
}

.w-25 {
  width: 25%;
}
.search-icon {
  background: blue;
  font-size: 2em;
}
.v-select {
  margin: 0;
  padding: 0;
  height: 0vh;
}
.v-card {
  box-shadow: none;
}
#wrapper {
  width: 93%;
}

table {
  width: 300%;
  margin-left: 4em;
}
th {
  background: #0073ff;
  color: white;
}
tr:nth-child(even) {
  background: rgb(197, 193, 193);
}
tr:nth-child(odd) {
  background: rgb(247, 243, 243);
}
th,
td {
  width: 149px;
  border: 1px solid rgb(255, 255, 255);

  padding: 10px;
}

thead > tr {
  position: relative;
  display: block;
}

tbody {
  display: block;
  height: 40vh;
  overflow-y: auto;
}
.bg-list-type{
  border-bottom: solid 2px ;
}
.bg-list-type-style{
  background: green;
  margin: auto;
}
.box-Shadonw-status{
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
}
</style>
