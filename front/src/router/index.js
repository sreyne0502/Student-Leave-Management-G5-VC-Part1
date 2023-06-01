import { createRouter, createWebHistory } from 'vue-router'
import dashboardStudent from "../components/DashBoard.vue"
import newRequestLeave from "../components/NewRequest.vue"
import CheckListStudent from "../components/CheckList.vue"
import listStudent from "../components/StudentList.vue"
import formLogin from "../views/FormLogin.vue"
import studentProfile from "../components/StudentProfile.vue"
import adminProfile from "../components/AdminProfile.vue"
import StudentView from "../views/StudentView.vue"
import AdminView from "../views/AminView.vue"
import NotFoundPage from "../components/PageNotFound.vue"
const routes = [
  {
    path: '/',
    name: 'login',
    component: formLogin,
  },
  {
    path: "/:pathMatch(.*)*",
    component: NotFoundPage,
  },
  {
    path: '/admin',
    name: 'admin',
    component: AdminView,
    children:[
      {
        path: '/listStudent',
        name: 'list',
        component: listStudent,
        meta:{
          requiresAuth:true,
          isAdmin:true,

        }

      },
      {
        path: '/checkList',
        name: 'check',
        component: CheckListStudent,
        props:true,
        meta:{
          requiresAuth:true,
          isAdmin:true,
        
        }

        
      },
      {
        path: '/adminProfile',
        name: 'adminProfile',
        component: adminProfile,
        
        meta:{
          requiresAuth:true,
          isAdmin:true,
        }
      },
      
    ]
  },
  
  
  {
    path: '/studentview',
    name: 'studentview',
    component: StudentView,
    children:[
      {
        path: '/dashboard',
        name: 'dashboard',
        component: dashboardStudent,
        meta:{
          requiresAuth:true,
          isStudent:true,
        }
      },
      {
        path: '/request',
        name: 'request',
        component: newRequestLeave,
        meta:{
          requiresAuth:true,
          isStudent:true,
          
        }
     
      },
      {
        path: '/profile',
        name: 'profile',
        component: studentProfile,
        meta:{
          requiresAuth:true,
          isStudent:true,
        }
      },
    ]
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes:routes,
  linkActivelistitem:'active',
  linkExactActiveClass:'active',
 
})
router.beforeEach((to,from,next)=>{
  if(to.meta.requiresAuth){
    if(to.meta.isAdmin){
      if(!localStorage.admin_token){
        next('/')
      }else{
        if(to.path == "/"){

            next('/listStudent')
        }else{
          next()
        }
      }
    }else{
      if(to.meta.isStudent){
        if(!localStorage.student_token){
          next('/')
        }else{
          if(to.path == "/"){
            next('/dashboard')
          }else{
            next()
          }
        }

      }
    }
  
  }
  next()
})

export default router
