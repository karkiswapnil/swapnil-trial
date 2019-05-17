<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Mail Subscribers List</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-success" @click="downloadCsv">
                Download CSV
                <i class="fas fa-file-csv"></i>
              </button>
              <button type="button" @click="newModal" class="btn btn-success">
                Add Subscriber
                <i class="fas fa-user-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subscribed at</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="subscriber in subscriber.data" v-bind:key="subscriber.id">
                  <td>{{subscriber.id}}</td>
                  <td>{{subscriber.first_name}} {{subscriber.last_name}}</td>
                  <td>{{subscriber.email}}</td>
                  <td>{{subscriber.created_at | myDate}}</td>
                  <td>
                    <a href="#" @click="editModal(subscriber)">
                      <i class="fa fa-edit"></i>
                    </a>
                    /
                    <a href="#" @click="deleteSubscriber(subscriber.id)" >
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer"></div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="addNewSubscriber"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New Subscriber</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update Subscriber</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateSubscriber() : createSubscriber()">
            <div class="modal-body">
              <div class="form-group">
                <label>First Name</label>
                <input
                  v-model="form.first_name"
                  type="text"
                  name="first_name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('first_name') }"
                >
                <has-error :form="form" field="first_name"></has-error>
              </div>

              <div class="form-group">
                <label>Last Name</label>
                <input
                  v-model="form.last_name"
                  type="text"
                  name="last_name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('last_name') }"
                >
                <has-error :form="form" field="last_name"></has-error>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  name="email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                >
                <has-error :form="form" field="email"></has-error>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editmode: false,
      subscriber: {},
      form: new Form({
        id: "",
        first_name: "",
        last_name: "",
        email: ""
      })
    };
  },
  methods: {
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNewSubscriber").modal("show");
    },
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNewSubscriber").modal("show");
      this.form.fill(user);
    },
      deleteSubscriber(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send request to server
        if(result.value){
        this.form
          .delete("api/mailSubscribers/" + id)
          .then(() => {
              Swal.fire("Deleted!", "subscriber has been deleted.", "success");
              Fire.$emit("AfterChange");
          })
          .catch(() => {
            this.$Progress.fail();
            Swal.fire({
              type: "error",
              title: "Oops...",
            });
          });
        }
      });
    },
    createSubscriber() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("api/mailSubscribers")
        .then(() => {
            Fire.$emit("AfterChange");
            Swal.fire({
            type: "success",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            title: "subscriber added successfully"
          });
          $("#addNewSubscriber").modal("hide");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    updateSubscriber() {
      // console.log('editing data')
      this.$Progress.start();
      this.form
        .put("api/mailSubscribers/" + this.form.id)
        .then(() => {
          Fire.$emit("AfterChange");
          Swal.fire({
            type: "success",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            title: "susbcriber Updated successfully"
          });
          $("#addNewSubscriber").modal("hide");
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    downloadCsv() {
      window.location.href = "download-csv-subscribers";
    },
    loadUsers() {
      axios
        .get("api/mailSubscribers")
        .then(({ data }) => (this.subscriber = data));
    }
  },
  created() {
    this.loadUsers();
    Fire.$on("AfterChange", () => {
      this.loadUsers();
    });
  }
};
</script>
