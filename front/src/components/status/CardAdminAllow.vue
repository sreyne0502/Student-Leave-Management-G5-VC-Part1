<template>
  <div class="card">
    <div class="card-header color-style" id="headingOne">
      <div class="d-flex justify-content-between">
        <ul class="space-img ">
          <div class="textli d-flex d-flex  align-items-center">
          <div><slot name="icon-confirm"></slot> </div>
            <slot name="displayName"></slot>
          </div>
        </ul>
        <slot name="alert"></slot>
        <div class="button justify-content">
          <a
            class="btn btn-link nav-button"
            data-toggle="collapse"
            :data-target="'#' + index"
            aria-expanded="true"
            aria-controls="index"
          >
            <i class="fa-solid fa-eye"></i>
          </a>
        </div>
      </div>
    </div>
    <div
      :id="index"
      class="collapse hidden"
      aria-labelledby="headingOne"
      data-parent="#accordion"
    >
      <div class="card-body">
        <div>
          <div class="accordion-body">
            <div class="mb-1 row">
              <div class="row p-1">
                <div class="col-sm-5 d-flex">
                  <p class="fw-bold m-1">Star Date: </p> <p class="m-1"><slot name="startDate"></slot></p>
                </div>
                <div class="col-sm-5 d-flex">
                  <p class="fw-bold m-1">End Date: </p> <p class="m-1"><slot name="endDate"></slot></p>
                </div>
                <div class="col-sm-5 ml-left d-flex">
                  <p class="fw-bold m-1">Duration: </p> <p class="m-1"><slot name="cause"></slot></p>
                </div>
                <div class="col-sm-5 d-flex">
                  <p class="fw-bold m-1">Leave Type: </p> <p class="m-1"><slot name="duration"></slot></p>
                </div>
                <div class="col-sm-5 d-flex">
                  <p class="fw-bold m-1">Request Date: </p> <p class="m-1"><slot name="type"></slot></p>
                </div>
                <div class="col-sm-5 d-flex">
                  <p class="fw-bold m-1">Reason: </p> <p class="m-1"><slot name="requestDate"></slot></p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
export default {
  props: ["index"],
  data() {
    return {
      dialog: false,
    };
  },
};
</script>

<style  scoped>

</style>
