<template>
  <div>
    <Navigation-Bar>
      <template #account>
        <router-link class="item-link" to="/adminProfile">
          <div class="account p-3 d-flex">
            <div>
       
                <img v-if="adiminAccount.profile_image != '' "
                  class="img-profile"
                  :src="adiminAccount.profile_image"
                  alt="John"
                  width="70"
                />
                <img v-else
                  class="rounded-pill"
                  src="https://cdn.vuetifyjs.com/images/john.jpg"
                  alt="John"
                  width="70"
                />
      
            </div>
            <div>
              <div class="mt-3 text-white">
                <span class="m-2 fw-bold"
                  >{{ adiminAccount.first_name }}
                  {{ adiminAccount.last_name }}</span
                >
                <p class="">PNC</p>
              </div>
            </div>
          </div>
        </router-link>
      </template>
      <template #logout>
        <Button-View @click="onLogOut()" class="text-white"
          ><i class="fa-solid fa-right-from-bracket"></i
        ></Button-View>
      </template>
      <template #padding-alert>
        <button @click="setPendingToLocalStorage()">
          <v-badge color="green" :content="countPending">
            <i class="fa-solid fa-bell icon-bell"></i>
          </v-badge>
        </button>
      </template>
      <template #v-list-item>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="item.to"
        
          link
          class="mt-5"
        >
          <div style="display: flex">
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </div>
        </v-list-item>
      </template>
    </Navigation-Bar>
  </div>
</template>

<script>
import axios from "../axios-http";
export default {
  components: {},
  data: () => ({
    pendingName: null,
    drawer: null,
    items: [
      { title: "List Student", icon: "mdi-home", to:"/listStudent"},
      { title: "Check List", icon: "mdi-view-dashboard", to:"/checkList"},
    ],
    right: null,
    studentLists: [],
    pendingString: true,
    adiminAccount: {},
    adminID: localStorage.getItem("user_id"),
    token: {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
      },
    },
  }),
  methods: {
    getData() {
      axios
        .get("/leaves", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
          },
        })
        .then((res) => {
          this.studentLists = res.data;
        });
    },
    getAdminAccount() {
      axios.get("/admin/" + this.adminID, this.token).then((res) => {
        this.adiminAccount = res.data;
      });
    },
    onLogOut() {
      localStorage.removeItem("user_id");
      localStorage.removeItem("admin_token");
      this.$router.push("/");
      axios.post("/logout" , this.token)
    },
    setPendingToLocalStorage() {
      localStorage.setItem("sendPending", this.pendingString);
      this.$router.push('/checkList')
    },
  },
  computed: {
    countPending() {
      let count = null;
      this.studentLists.forEach((leave) => {
        console.log(leave.status);
        if (leave.status === "pending") {
          count++;
        }
      });
      return count | 0;
    },
  },

  mounted() {
    this.getData();
    this.getAdminAccount();
   
  },
};
</script>
<style scoped>
img {
  border-radius: 40px;
}
.account {
  border-bottom: solid 2px rgb(255, 255, 255);
}
.v-list-item--active {
  background-color: rgb(255, 255, 255);
  color: rgb(0, 0, 0);
}
.v-list-item {
  text-decoration: none;
  color: white;
}
.v-list-item--active {
  color: rgb(0, 0, 0);
}
.button {
  border-top: 2px solid white;
}
.icon-bell {
  font-size: 25px;
}
.v-badge:hover {
  background: none;
}
.v-list-item-title {
  font-weight: bold;
}
.item-link {
  text-decoration: none;
}
.test {
  background: #000;
}
.img-profile{
  display: inline-block;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;


}
</style>
