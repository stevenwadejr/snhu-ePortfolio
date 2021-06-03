<template>
    <header>
    <div class="px-3 py-2 bg-dark text-white">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
            <img src="/logo.png" class="site-logo" />
            <span class="fs-4">Bubba Gump Survey Data</span>
          </a>

          <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
            <li>
              <a href="#" class="nav-link text-white">
                <i class="bi bi-table d-block mx-auto mb-1"></i>
                Survey Data
              </a>
            </li>
            <li>
                <span class="vertical-separator d-block"></span>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
                <i class="bi bi-person-circle d-block mx-auto mb-1"></i>
                Customers
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
                <i class="bi bi-geo-alt-fill d-block mx-auto mb-1"></i>
                Geography
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
                <i class="bi bi-cash-coin d-block mx-auto mb-1"></i>
                Sales
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
                <i class="bi bi-bar-chart-line-fill d-block mx-auto mb-1"></i>
                Statistics
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</template>

<style>
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
</style>
