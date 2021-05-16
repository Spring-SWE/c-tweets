<template>
  <div>
    <!-- <h2 class="mb-4">Sidebar </h2> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
        <button
          class="btn btn-dark d-inline-block d-lg-none ml-auto"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="nav navbar-nav ml-auto w-100" style="">
            <form
              class="form-inline w-100 text-center p-3"
              @submit.prevent
              role="form"
            >
              <input
                v-on:keyup.enter="submit"
                type="text"
                class="form-control input-lg w-100 mt-3"
                placeholder="Search twitter handle"
                v-model="query"
              />
            </form>
          </div>
          <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
              <router-link
                class="nav-link"
                exact-active-class="active"
                :to="{ name: 'home' }"
                >Top</router-link
              >
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link"
                active-class="active"
                :to="{ name: 'latest' }"
                >Latest</router-link
              >
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

     <div class="alert alert-primary" role="alert">
      Cringetweets is currently in beta, things may not be working perfectly yet.
    </div>

    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      query: "",
    };
  },
  methods: {
    submit(event) {
      //This is a terrible workaround but I CBA to fix this right now.
      document.location.href = `/search?query=${this.query.replace("@", "")}`;
    },
    userHandle() {},
  },
};
</script>
