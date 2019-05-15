<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-success" >
                  Create Post
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
                    <th>Title</th>
                    <th>Content</th>
                    <th>User_id</th>
                    <th>Created_At</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="posts in posts.data" v-bind:key="posts.id">
                    <td>{{posts.id}}</td>
                    <td>{{posts.title}}</td>
                    <td>{{posts.content}}</td>
                    <td>{{posts.user_id }}</td>
                    <td>{{posts.created_at | myDate}}</td>
                    <td>
                      <a href="#" >
                        <i class="fa fa-edit"></i>
                      </a>
                      /
                      <a href="#" >
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              
            </div>
          </div>
        </div>
      
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: {},
      form: new Form({
        id: "",
        title: "",
        content: "",
        photo: "",
        user_id: "",
      })
    };
  },
  methods :{
       loadUsers() {
      axios.get("api/userPosts").then(({ data }) => (this.posts = data));
       }
  },
  mounted() {
      this.loadUsers();
    console.log("Component mounted.");
  }

};
</script>
