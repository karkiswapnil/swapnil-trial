<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 mt-3">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background: url('img/bg-image.jpeg') center center;"
          >
            <h3 class="widget-user-username">Elizabeth Pierce</h3>
            <h5 class="widget-user-desc">Web Designer</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link active show" href="#activity" data-toggle="tab">Activity</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active show" id="activity">
                <h4>User Activity</h4>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <h4>User Timeline</h4>
              </div>

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input
                        type="text"
                        v-model="form.name"
                        class="form-control"
                        id="inputName"
                        placeholder="Name"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                      >
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input
                        type="email"
                        v-model="form.email"
                        class="form-control"
                        id="inputEmail"
                        placeholder="Email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      >
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="uploadPhoto" class="col-sm-2 control-label">Upload Photo</label>
                    <div class="col-sm-10">
                      <input
                        type="file"
                        @change="updateProfile"
                        class="form-control-file"
                        id="uploadPhoto"
                      >
                    </div>
                  </div>

                  <div class="form-group">
                    <label
                      for="password"
                      class="col-sm-2 control-label"
                    >Password(leave empty if not changing)</label>
                    <div class="col-sm-10">
                      <input
                        type="password"
                        v-model="form.password"
                        class="form-control"
                        id="password"
                        placeholder="Password"
                       :class="{ 'is-invalid': form.errors.has('password') }"
                      >
                      <has-error :form="form" field="password"></has-error>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button
                        type="submit"
                        @click.prevent="updateInfo"
                        class="btn btn-success"
                      >Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        role: "",
        photo: ""
      })
    };
  },

  mounted() {
    console.log("Component mounted.");
  },

  methods: {
    getProfilePhoto(){
      let photo = (this.form.photo.length>200) ? this.form.photo:"img/profile/"+this.form.photo;
      return photo;
      //return "img/profile/"+this.form.photo;
    },
    updateInfo() {
      this.$Progress.start();
      console.log('uploading...');
      this.form
        .put("api/profile")
        .then(() => {
          Fire.$emit("AfterChange");
          Swal.fire({
            type: "success",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            title: "Profile Updated successfully"
          });

          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
          
        });
    },
    updateProfile(e) {
      //console.log('uploading...')
      let file = e.target.files[0];
      console.log(file);
      let reader = new FileReader();
      if (file["size"] <= 2097152) {
        reader.onloadend = file => {
          //console.log("RESULT", reader.result);
          this.form.photo = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        Swal.fire({
          type: "error",
          title: "Oops...",
          text: "You are uploading a large file"
        });
      }
    }
  },

  created() {
    axios.get("api/profile").then(({ data }) => this.form.fill(data));
     Fire.$on("AfterChange", () => {
      this.created();
    });
  }
};
</script>
