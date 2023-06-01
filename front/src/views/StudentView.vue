<template>
  <div>
    <Navigation-Bar>
      <template #account>
        <router-link class="item-link" to="/profile">
          <div class="account p-3 mt-5 d-flex">
            <div>

              <img v-if="studentAccount.profile_image!=''"
                class="img-profile"
                :src="studentAccount.profile_image"
                alt="John"
                
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
                <span class="m-2 fw-bold">{{studentAccount.first_name}} {{studentAccount.last_name}}</span>
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
  data: () => ({
    drawer: null,
    items: [
      { title: "Dashboard", icon: "mdi-home", to: "/dashboard" },
      { title: "New Request", icon: "mdi-view-dashboard", to: "/request" },
    ],
    right: null,
    studentId: localStorage.getItem("student_id"),
    token: {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("student_token")}`,
      },
    },
    studentAccount: {},
  }),
  components: {},

  methods: {
    onLogOut() {
      localStorage.removeItem("student_id");
      localStorage.removeItem("student_token");
      this.$router.push("/");
    },
    getStudentAccount() {
      axios.get("/getOneStudent/" + this.studentId, this.token).then((res) => {
        this.studentAccount = res.data;
      });
    },
  },
  mounted() {
    this.getStudentAccount();
  },
};
</script>
<style scoped>

.img-profile{
  display: inline-block;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;


}
.account {
  border-bottom: solid 2px rgb(255, 255, 255);
}

.button {
  border-top: 2px solid white;
}
.routerlinkactive {
  background: #000;
}
.d-flex {
  display: flex;
}
.v-list-item--active {
  background-color: rgb(255, 255, 255);
  transition: 0.5s;
}
.v-list-item {
  text-decoration: none;
  color: white;
}
.v-list-item--active {
  color: rgb(0, 0, 0);
}
.v-list-item-title {
  font-weight: bold;
}
.account {
  border-bottom: solid 2px rgb(255, 255, 255);
}
.item-link {
  text-decoration: none;
}
</style>
