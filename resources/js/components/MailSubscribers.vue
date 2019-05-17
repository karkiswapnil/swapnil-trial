<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Mail Subscribers List</h3>

            <div class="card-tools">
                <button
                type="button"
                class="btn btn-success"
                @click="downloadCsv"
              >
                Download CSV
                <i class="fas fa-file-csv"></i>
              </button>
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
                  <th>Subscribed at</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="subscriber in subscriber.data" v-bind:key="subscriber.id">
                  <td>{{subscriber.id}}</td>
                  <td>{{subscriber.first_name}} {{subscriber.last_name}}</td>
                  <td>{{subscriber.email}}</td>
                  <td>{{subscriber.created_at | myDate}}</td>
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
        first_name: "",
        last_name: "",
        email: ""
      })
    };
  },
  methods: {
       downloadCsv(){
      window.location.href = "download-csv-subscribers";
    },
    loadUsers() {
      axios.get("api/mailSubscribers").then(({ data }) => (this.subscriber = data));
    }
  },
  mounted() {
    this.loadUsers();
    console.log("Component mounted.");
  }
};
</script>
