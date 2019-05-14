<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-success"
                @click="newModal"
              >
                Add new
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
                  <th>Role</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="user in users" v-bind:key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.role | capitalize}}</td>
                  <td>{{user.created_at | myDate}}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New User</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <label>Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                >
                <has-error :form="form" field="name"></has-error>
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

              <div class="form-group">
                <label>Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                >
                <has-error :form="form" field="password"></has-error>
              </div>

              <div class="form-group">
                <label>Role</label>
                <select
                  class="form-control"
                  v-model="form.role"
                  type="text"
                  name="role"
                  id="role"
                  :class="{ 'is-invalid': form.errors.has('role') }"
                >
                  <option>Select Role</option>
                  <option value="admin">admin</option>
                  <option value="user">user</option>
                  <option value="member">member</option>
                  <has-error :form="form" field="role"></has-error>
                </select>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show ="editmode" type="submit" class="btn btn-primary">Update</button>
              <button v-show ="!editmode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { setInterval } from "timers";
export default {
  data() {
    return {
      editmode : false,
      users: {},
      form: new Form({
        id:'',
        name: '',
        email: '',
        password: '',
        role: '',
        photo:''
      })
    };
  },
  methods: {
    newModal(){
      this.editmode=false;
      this.form.reset();
       $("#addNew").modal("show");
    },
    editModal(user){
      this.editmode=true;
      this.form.reset();
       $("#addNew").modal("show");
       this.form.fill(user);
    },
    loadUsers() {
      if(this.$gate.isAdmin){
      axios.get("api/user").then(({ data }) => (this.users = data.data));
      }
    },
    updateUser(){ 
     // console.log('editing data')
     this.$Progress.start();
     this.form.put('api/user/'+this.form.id)
     .then(()=>{
        Fire.$emit("AfterChange");
        Swal.fire({
          type: "success",
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          title: "User Updated successfully"
        });
        $("#addNew").modal("hide");
     })
     .catch(()=>{
       this.$Progress.fail();

     })

    },
    deleteUser(id) {
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
          .delete("api/user/" + id)
          .then(() => {
              Swal.fire("Deleted!", "User has been deleted.", "success");
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
    createUser() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form.post("api/user")
      .then(() => {
        Fire.$emit("AfterChange");
        Swal.fire({
          type: "success",
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          title: "User Created successfully"
        });
        $("#addNew").modal("hide");
        this.$Progress.finish();
      })
      .catch(() => {
        this.$Progress.fail();
      });
    }
  },
  created() {
    this.loadUsers();
    Fire.$on("AfterChange", () => {
      this.loadUsers();
    });
    //setInterval(()=>this.loadUsers(),3000);
  }
};
</script>
