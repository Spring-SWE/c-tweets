<template>
    <div>
        <!-- <h2 class="mb-4">Sidebar </h2> -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

              <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
              </button>
              <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <i class="fa fa-bars"></i>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                  <li class="nav-item active">
                      <router-link class="nav-link" :to="{ name: 'home' }">Top</router-link>
                  </li>
                  <li class="nav-item">
                      <router-link class="nav-link"  :to="{ name: 'latest' }">Latest</router-link>
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

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>


<script>
    export default {}
</script>
