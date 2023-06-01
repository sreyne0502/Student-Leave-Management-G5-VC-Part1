<template>
    <div class="d-flex align-items-center justify-content-center vh-100 ">
        <div class="text-center row ">
            <div class=" col-md-6 ">
                <img src="https://cdn.pixabay.com/photo/2017/03/09/12/31/error-2129569__340.jpg" alt=""
                    class="img-fluid ">
            </div>
            <div class=" col-md-6 mt-5 ">
                <p class="fs-3"> <span class="text-danger">Opps!</span><strong> Page not found.</strong></p>
                <p class="lead">
                    The page you're  looking for doesn't exist.
                </p>
                <v-progress-linear
                color="deep-purple accent-4"
                indeterminate
                rounded
                height="6"
              ></v-progress-linear>
            </div>

        </div>
    </div>
</template>

<script >
export default{
    
}
</script>

<style scoped>


</style>