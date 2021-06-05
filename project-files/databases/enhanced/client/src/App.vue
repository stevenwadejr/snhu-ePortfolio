<template>
  <div>
    <header class="position-fixed top-0 start-0 end-0">
      <div class="px-3 py-2 bg-dark text-white">
        <div class="container">
          <div
            class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"
          >
            <a
              href="/"
              class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none"
            >
              <img src="/logo.png" class="site-logo" />
              <span class="fs-4">Bubba Gump Survey Data</span>
            </a>

            <ul
              class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small"
            >
              <li>
                <router-link to="/" class="nav-link text-white">
                  <i class="bi bi-table d-block mx-auto mb-1"></i>
                  Survey Data
                </router-link>
              </li>
              <li>
                <span class="vertical-separator d-block"></span>
              </li>
              <li>
                <router-link to="/customers" class="nav-link text-white">
                  <i class="bi bi-person-circle d-block mx-auto mb-1"></i>
                  Customers
                </router-link>
              </li>
              <li>
                <router-link to="/geography" class="nav-link text-white">
                  <i class="bi bi-geo-alt-fill d-block mx-auto mb-1"></i>
                  Geography
                </router-link>
              </li>
              <li>
                <router-link to="/sales" class="nav-link text-white">
                  <i class="bi bi-cash-coin d-block mx-auto mb-1"></i>
                  Sales
                </router-link>
              </li>
              <li>
                <router-link to="/statistics" class="nav-link text-white">
                  <i class="bi bi-bar-chart-line-fill d-block mx-auto mb-1"></i>
                  Statistics
                </router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <div class="col-12">
            <router-view></router-view>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.bi {
  font-size: 24px;
  text-align: center;
}
.site-logo {
  height: 64px;
  margin-right: 15px;
}
.vertical-separator {
  border-left: 1px solid white;
  height: 80%;
  margin: 30% 10px 0;
}
main {
  margin-top: 115px;
}
</style>
