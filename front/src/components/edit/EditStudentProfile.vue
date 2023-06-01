<template>
  <div class="row">

    <div class="col-sm-9" >
  
      <div class="text-center ">
        <v-dialog v-model="dialog" width="800">
          <template v-slot:activator="{ on, attrs }">
            <button
      
              dark
              v-bind="attrs"
              v-on="on"
              @click="onModelPop"
            >
            <i class="fa-solid fa-pen-to-square fa-xl m-3"></i>
            </button>
          </template>
    
          <v-card class="formEdit">
            <v-card-title class="text-h5 grey lighten-2 bg-grey">
              Privacy Policy
            </v-card-title>
    
            <v-card-text>
              <div class="">
                <form>
                  <div>
                    <div class="col-sm-10 m-2">
                      <input
                        type="text"
                        class="form-control"
                        id="first name"
                        placeholder="First Name"
                        v-model="first_name"
                      />
                    </div>
    
                    <div class="col-sm-10 m-2">
                      <input
                        type="text"
                        class="form-control"
                        id="Last name"
                        placeholder="Last Name"
                        v-model="last_name"
                      />
                    </div>
    
                    <div class="col-sm-10 m-2">
                      <input
                        type="text"
                        class="form-control"
                        id="email"
                        placeholder="email"
                        v-model="email"
                      />
                    </div>
                    <div class="col-sm-10 m-2">
                      <input
                        type="tel"
                        class="form-control"
                        id="PhoneNumber"
                        placeholder="PhoneNumber"
                        v-model="phone"
                      />
                    </div>
                    <div class="col-sm-10 m-2">
                      <input
                        type="text"
                        class="form-control"
                        id="batch"
                        placeholder="batch"
                        v-model="batch"
                      />
                    </div>
                    <div class="col-sm-10">
                      <h5 class="mb-2">Gender:</h5>
    
                      <div>
                        <input
                          v-model="gender"
                          type="radio"
                          id="male"
                          name="gender"
                          value="Male"
                        />Male
                        <input
                          v-model="gender"
                          type="radio"
                          id="female"
                          name="gender"
                          value="Female"
                        />Female
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </v-card-text>
    
            <v-divider></v-divider>
    
            <div class="d-flex justify-content-center">
              <v-card-actions>
                <v-btn class="mr-4 bg-red" @click="submitEdit()">submit</v-btn>
              </v-card-actions>
            </div>
          </v-card>
        </v-dialog>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "../../axios-http";
export default {
  props: ["id"],
  data() {
    return {
      dialog: false,
      editDialog: false,
      editData: null,
      first_name:'',
      last_name:'',
      phone:'',
      batch:'',
      gender:'',
      token: {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
        },
      },

    };
  },
  methods: {
    onModelPop() {
      this.dialog = true;
    },
    getStudents() {
      axios.get("/studentsInAdmin/" + this.id, this.token).then((response) => {
        this.first_name=response.data[0].first_name;
        this.last_name=response.data[0].last_name;
        this.email=response.data[0].email;
        this.phone=response.data[0].phone;
        this.batch=response.data[0].batch;
        this.gender=response.data[0].gender;
    
      });
    },
    submitEdit() {
      let newstudent = {first_name:this.first_name,last_name:this.last_name, email:this.email, phone:this.phone, gender:this.gender};
      axios
      .put("/edit/"+this.id,newstudent,this.token)
      this.dialog=false;
      this.getStudents()
      this.$emit('sendStudentData',)

    },

  },
  mounted() {
    this.getStudents();
  },
};
</script>

<style scoped>
</style>