<div class="container-fluid px-2 px-md-4">
      <!-- <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');"> -->
        <!-- <span class="mask  bg-gradient-primary  opacity-6"></span> -->
      <!-- </div> -->
      <div class="card card-body ">
        <div class="row gx-4 mb-2">
          <div class="col-auto">
            <div class="avatar avatar-xl">
              <img src="<?=base_url()?>assets/img/illustrations/profile.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1" style="text-transform: capitalize;" id="headerFullname">
                <?=$fullname?>
              </h5>
              <p class="mb-0 font-weight-normal text-sm" style="text-transform: uppercase;">
                <?=$roleUsers?> <?= $roleId == 777 ? '' : "/ $shopName" ?>
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <p>Tanggal Dibikin Account :  <span><?=$createdAt?></span></p>
                  <!-- <a class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true"> -->
                    <!-- <i class="material-icons text-lg position-relative">home</i> -->
                    <!-- <span class="ms-1">App</span> -->
                  <!-- </a> -->
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="row">
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Informasi Profile</h6>
                    </div>
                    <div class="col-md-4 text-end" id="divEditUser">
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <p class="text-sm">
                    Hai <?=$username?>, <br>
                    Anda <strong style="text-transform: uppercase;" class="text-dark"><?=$roleUsers?></strong> dari <strong class='text-dark' id="strongCompanyName"><?=$companyName?></strong>, 
                    <?= $roleId == 777 ? "" : "<strong class='text-dark' style='text-transform: capitalize;'>$shopName</strong>"?>.
                  </p>
                  <hr class="horizontal gray-light my-4">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">ID User:</strong> &nbsp; <?=$userId?></li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm" style="text-transform: capitalize;"><strong class="text-dark">Nama Lengkap:</strong> &nbsp; <span id="liFullname"><?=$fullname?></span></li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Nama Usaha:</strong> &nbsp; <span id="liCompanyName"><?=$companyName?></span></li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; <?=$email?></li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Update Terakhir User:</strong> &nbsp; <?=$updatedAt?></li>
                    <li class="list-group-item border-0 ps-0 pb-0 mt-4">
                      <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-facebook fa-lg"></i>
                      </a>
                      <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-twitter fa-lg"></i>
                      </a>
                      <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-instagram fa-lg"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditCeo" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
        <form role="form" id="formEditCeo">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
          <div class="card card-plain">
            <div class="card-header" style="text-transform: capitalize;">
              <h4 class="font-weight-bolder">Edit CEO</h4>
              <strong class="mb-0" id="editName"><?=$companyName?></strong>
            </div>
            <div class="card-body mt-3" id="card-modal-body" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; padding: 20px; border-radius: 5px;">
                <h6>Rubah Data Profile</h6>
                <hr>
                <div class="input-group is-focused input-group-outline mb-3" id="div-fullname">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" id="fullname" name="fullname" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-fullname"></div>

                <!-- <div class="input-group is-focused  input-group-outline mb-3" id="div-companyName">
                  <label class="form-label">Nama Usaha</label>
                  <input type="text" id="companyName" name="companyName" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-companyName"></div> -->

                <div class="text-center">
                  <button type="button" id="btnSaveProfile" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-2 mb-0">Simpan</button>
                </div>
            </div>

            <div class="card-body mt-3" id="card-modal-body" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; padding: 20px; border-radius: 5px;">
              <h6>Rubah Password</h6>
                <hr>
                <div class="input-group input-group-outline mb-3" id="div-changePassword">
                  <label class="form-label">Password Baru</label>
                  <input type="password" id="passwordNew" name="password" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-passwordNew"></div>
                
                <div class="input-group input-group-outline mb-3" id="div-changeConfirmPassword">
                  <label class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" id="prePasswordNew" name="pre-password" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-prePasswordNew"></div>
                
                <div class="text-center">
                  <button type="button" id="btnChangePassword" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-2 mb-0">Simpan</button>
                </div>
              </form>
            </div>

          </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<script src="<?=base_url()?>assets/js/function/v_user.js"></script> 