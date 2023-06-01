<template>

    <v-dialog
      v-model="dialog"
      transition="dialog-bottom-transition"
      max-width="600"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
          @click="onPopUp()"
        >
          Update
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="bg-head-change-user">
          <span class="text-h5 disabled">User Profile</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="first_name"
                  v-model="first_name"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="last_name"
                  v-model="last_name"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Age" v-model="age" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="email"
                  v-model="email"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
          <div class="bg-button w-80 m-4  text-center p-2 text-white">
            <button text @click="onEditProfileAdmin()">
              Save
            </button>

          </div>
      </v-card>
    </v-dialog>

</template>
<script>
import axios from "../../axios-http";
export default {
  data: () => ({
    // props:['studentData'],
    dialog: false,
    first_name:null,
    last_name:null,
    age:null,
    email:null,
    timer: "",
    token: {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
    },
  },
  adminID: localStorage.getItem("user_id"),
  }),
  methods:{
    onPopUp(){
        this.dialog=true
    },
     onEditProfileAdmin(){
       let object={}
       object.first_name=this.first_name
       object.last_name=this.last_name
       object.age=this.age
       object.email=this.email
       if(this.first_name!='' && this.last_name!='' && this.age!='' && this.email!=''){
        axios.put(
            "/editAdminProfile/" + this.adminID,object,
            this.token).then(()=>{
                this.dialog=false
                this.getAdminData()
                
            })
        }else{
            this.dialog=true
        }
    },
     getAdminData(){

        axios.get(
        "/getOneAdmin/" + this.adminID,
        this.token
      ).then((res)=>{
        this.first_name=res.data.first_name
        this.last_name=res.data.last_name
        this.age=res.data.age
        this.email=res.data.email
        this.$emit('studentId',this.adminID)
      });
    }
  },
  mounted(){
    this.getAdminData();

    
    
  },
 
    
   

}
</script>
<style scoped>

  .bg-head-change-user {
    background: rgba(19, 129, 255, 0.644);
    color: azure;
  }
  .bg-button{
    background: rgb(101, 69, 215);
    border-radius: 5px;
  }

  
</style>