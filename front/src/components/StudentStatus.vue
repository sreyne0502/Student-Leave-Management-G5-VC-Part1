<template>
  <LIstViewVue>
    <template #header> </template>
  </LIstViewVue>
  <v-container class="grey lighten-5 ">
    <v-row class="d-flex justify-content-evenly " >
      <v-col v-for="value in studentStatus" :key="value" xs="12" sm="12" md="4">
        <v-card class="w-card w-75 m-auto " style="box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;">
          <div class="d-flex  bg-top">
            <div :class="value.background">
              <img :src="value.img" width="70" alt="" />
            </div>
            <div class="card-body-status ml-4 ">
              <div class="card-text-status font-weight-bold fs-5">
                {{ value.status }}
              </div>
              <div class="card-number-status ">
                <p v-if="value.status== 'Approved'">{{ getApproved }}</p>
                <p v-if="value.status== 'Pending'">{{ getPadding }}</p>
                <p v-if="value.status== 'Rejected'">{{ getRejected }}</p>
              </div>
            </div>
          </div>
          <Button-View
            class="bg font-weight-bold text-center"
            @click="checkStatus(value.status)"
            ><strong class="text-white ">see more </strong></Button-View
          >
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "../axios-http.js";
export default {
  props:['listLeaves'],
  components: {},
  data: () => ({
    studentStatus: [
      {
        status: "Approved",

        background: "white",
        img: "https://cdn4.iconfinder.com/data/icons/security-soft-3/512/ok_select_yes_apply_accept_approve_confirm-256.png",
      },
      {
        status: "Pending",

        background: "white",
        img: "https://cdn1.iconfinder.com/data/icons/user-38/100/user-pending-256.png",
      },
      {
        status: "Rejected",
        background: "white",
        img: "https://cdn4.iconfinder.com/data/icons/user-management-soft/512/delete_close_stop_cancel_remove_erase_reject-256.png",
      },
    ],
    studentLists: [],
      token: {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("student_token")}`,
        },
      },
  }),
  methods: {
    checkStatus(status) {
      this.$emit("sendStatus", status);
    },
    fetchDataStudent() {
      axios.get("/leaves",this.token).then((res) => {
        this.studentLists = res.data;
      });
    },
  },
  mounted() {
    this.fetchDataStudent();
  },
  computed: {
    getRejected(){
      let count =null
      this.listLeaves.forEach(leave => {
        if(leave.status==="rejected"){
          count++;
        }
      });
    return count | 0
    },
    getApproved(){
      let count=null
      this.listLeaves.forEach(leave => {
        if(leave.status==="approved"){
          count++;
        }
      });
      return count | 0;
    },
    getPadding(){
      let count = null
      this.listLeaves.forEach(leave => {
        if(leave.status==="pending"){
          count++;
        }
      });
      return count | 0;
    },
  },
};
</script>
<style scoped>
.card-header-status {
  background: green;
  padding: 25px;
}
.green {
  background: green;
  
}
.yellow {
  background: rgba(255, 162, 0, 0.61);
}
.red {
  background: red;
}
.v-container {
  width: 99%;
}
strong:hover {
  color: rgb(43, 90, 92);
  transition: 0.5s;
}
.bg-top{
  border-left:  5px solid #0073ff;
}
.bg{
  background: rgb(0, 198, 0);
}
</style>
