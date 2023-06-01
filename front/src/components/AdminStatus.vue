<template>
  <v-container class="grey lighten-5">
    <v-row class="d-flex justify-content-evenly">
      <v-col v-for="value in studentStatus" :key="value" xs="12" sm="12" md="4">
        <v-card class="w-card w-75 m-auto ">
          <div class="d-flex bg-left">
            <div :class="value.background">
              <img :src="value.img" width="70" alt="" />
            </div>
            <div class="card-body-status ml-4">
              <div class="card-text-status font-weight-bold fs-5">
                {{ value.status }}
              </div>
              <div class="card-number-status">
                <p v-if="value.status == 'Approved'"><strong style="color:#0073ff;">{{ getApproved }}</strong> </p>
                <p v-if="value.status == 'Rejected'"><strong style="color:#0073ff;"> {{ getRejected }}</strong></p>
                <p v-if="value.status == 'Student'"><strong style="color:#0073ff;">{{ countStudent }}</strong></p>
              </div>
            </div>
          </div>
          <Button-View
            class=" font-weight-bold text-center bg-green "
            >
            <strong class="text-white" @click="sendAdminStatus(value.status)">see more </strong>
          
          </Button-View>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
 
</template>

<script>

export default {

  props:{listLeaves:Object,studentName:Array},
  components: {},
  data: () => ({
    students:[],
    stutusList:null,
    studentStatus: [
      {
        status: "Student",
        background: "blue",
        img: "https://media.istockphoto.com/vectors/student-avatar-flat-icon-flat-vector-illustration-symbol-design-vector-id1212812078?k=20&m=1212812078&s=170667a&w=0&h=Pl6TaYY87D2nWwRSWmdtJJ0DKeD5vPowomY9fyeqNOs=",
      },
      {
        status: "Approved",

        background: "white",
        img: "https://cdn4.iconfinder.com/data/icons/security-soft-3/512/ok_select_yes_apply_accept_approve_confirm-256.png",
      },
      {
        status: "Rejected",

        background: "white",
        img: "https://cdn2.iconfinder.com/data/icons/business-and-finance-glyph-22/64/business-and-finance-glyph-22-15-1024.png",
      },
    ],
  }),
  methods: {
    sendAdminStatus(status){
      this.$emit("sendAdminStatus",status)
    },
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
    countStudent(){
      let count=null
      this.studentName.forEach((student) => {
        if(student){
          count++
        }
      });
      return count | 0;
    },
  },
  mounted(){
    
  }
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
.bg-left{
  border-left: solid 5px #0073ff;
}
.bg-green{
  background: green;

}
</style>
