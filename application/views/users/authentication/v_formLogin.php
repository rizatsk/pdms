<style>
  .swal-footer{
    background-color: rgb(245, 248, 250);
    margin-top: 20px;
    border-top: 1px solid #E9EEF1;
    overflow: hidden;
    text-align: center;
  } 

  .swal-button--confirm{
    padding: 7px 20px;
  }
</style>
<div class="container my-auto">
  <div class="row">
    <div class="col-lg-4 col-md-8 col-12 mx-auto">
      <div class="card z-index-0 fadeIn3 fadeInBottom">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
            <div class="row mt-3">
              <div class="col-2 text-center ms-auto">
                <a class="btn btn-link px-3" href="javascript:;">
                  <i class="fa fa-facebook text-white text-lg"></i>
                </a>
              </div>
              <div class="col-2 text-center px-1">
                <a class="btn btn-link px-3" href="javascript:;">
                  <i class="fa fa-github text-white text-lg"></i>
                </a>
              </div>
              <div class="col-2 text-center me-auto">
                <a class="btn btn-link px-3" href="javascript:;">
                  <i class="fa fa-google text-white text-lg"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form role="form" class="text-start" id="formLogin">
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Email atau Username</label>
              <input type="text" id="user" name="user" class="form-control">
            </div>
            <div class="message-error" id="form-error-user"></div>

            <div class="input-group input-group-outline mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control">
            </div>
            <div class="message-error" id="form-error-password"></div>
            <!-- <div class="form-check form-switch d-flex align-items-center mb-3"> -->
              <!-- <input class="form-check-input" type="checkbox" id="rememberMe"> -->
              <!-- <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember me</label> -->
            <!-- </div> -->
            <div class="text-center">
              <button type="submit" id="btnLogin" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
            </div>
            <p class="mt-4 text-sm text-center">
              Belum punya account ?
              <span class="text-primary text-gradient font-weight-bold"> <a href="https://wa.me/6287782987067" target="blank"> Hubungi Admin </a></span>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/js/function/v_formLogin.js"></script>
