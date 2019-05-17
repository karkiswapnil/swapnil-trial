<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Mail Subscribers List</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-success">
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
                  <th>Created_At</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="subcriber in subcriber.data" v-bind:key="subcriber.id">
                  <td>{{subcriber.id}}</td>
                  <td>{{subcriber.name}}</td>
                  <td>{{subcriber.email}}</td>
                  <td>{{subcriber.created_at | myDate}}</td>
                  <td>
                    <a href="#">
                      <i class="fa fa-edit"></i>
                    </a>
                    /
                    <a href="#">
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      subscriber: {},
      form: new Form({
        id: "",
        name: "",
        email: ""
      })
    };
  },
  methods: {
    loadUsers() {
      axios.get("api/userPosts").then(({ data }) => (this.posts = data));
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
