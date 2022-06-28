<div class="row">
  <div class="col-12">
    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg d-flex pt-3 align-items-center justify-content-between">
          <h6 class="text-white text-capitalize ps-3">Daftar Admin</h6>
          <button class="me-2 btn btn-outline-light" id="btn-show-modal-add-admin">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle pe-1" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg> Tambah Admin</button>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Admin Toko</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created Date</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Insert Admin -->
<div class="modal fade" id="modalInsertAdmin" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
        <form role="form" id="formRegister">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
          <div class="card card-plain">
            <div class="card-header">
              <h4 class="font-weight-bolder">Daftar</h4>
              <p class="mb-0">Selamat Datang</p>
              <p class="mb-0">Daftarkan Username Dan Email Sebagai Admin</p>
            </div>
            <div class="card-body" id="card-modal-body">
                <div class="input-group input-group-outline mb-3" id="div-name">
                  <label class="form-label">Nama</label>
                  <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-name"></div>

                <div class="input-group input-group-outline mb-3" id="div-username">
                  <label class="form-label">Username</label>
                  <input type="text" id="username" id="username" name="username" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-username"></div>

                <div class="input-group input-group-outline mb-3" id="div-email">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-email"></div>

                <div class="input-group input-group-outline mb-3 is-focused">
                  <label class="form-label">Admin Toko</label>
                  <select name="adminToko" id="adminToko" class="form-control">
                  </select>
                </div>
                <div class="message-error" id="form-error-adminToko"></div>

                <div class="input-group input-group-outline mb-3" id="div-password">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-password"></div>

                <div class="input-group input-group-outline mb-3" id="div-confirmPassword">
                  <label class="form-label">Konfirmasi Password</label>
                  <input type="password" name="re-password" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-re-password"></div>

                <div class="text-center">
                  <button type="submit" id="btnRegister" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Daftarkan</button>
                  <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-lg w-100 mt-2 mb-0">Cancel</button>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Insert Admin -->
<div class="modal fade" id="modalEditAdmin" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
        <form role="form" id="formEditAdmin">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
          <div class="card card-plain">
            <div class="card-header" style="text-transform: capitalize;">
              <h4 class="font-weight-bolder">edit user admin</h4>
              <p class="mb-0" id="editName"></p>
              <p class="mb-0" id="editShop"></p>
            </div>
            <div class="card-body" id="card-modal-body" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; padding: 20px; border-radius: 5px;">
                <input type="hidden" name="idUser" id="idUser">
                <h6>Rubah Menjadi Admin Toko</h6>
                <hr>
                <div class="input-group input-group-outline mb-3 is-focused">
                  <label class="form-label">Rubah Menjadi Admin Toko</label>
                  <select name="adminToko" id="editAdminToko" class="form-control">
                  </select>
                </div>
                <div class="message-error" id="form-error-adminToko"></div>

                <div class="text-center">
                  <button type="button" id="btnEditAdminShop" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-2 mb-0">Simpan</button>
                </div>
            </div>
            <div class="card-body mt-3" id="card-modal-body" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; padding: 20px; border-radius: 5px;">
                <h6>Ganti Password</h6>
                <hr>
                <div class="input-group input-group-outline mb-3" id="div-passwordOwner">
                  <label class="form-label">Password Owner</label>
                  <input type="password" id="ownerPassword" name="passwordOwner" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-ownerPassword"></div>

                <div class="input-group input-group-outline mb-3" id="div-changePassword">
                  <label class="form-label">Password Baru</label>
                  <input type="password" id="passwordNew" name="password" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-passwordNew"></div>

                <div class="input-group input-group-outline mb-3" id="div-changeConfirmPassword">
                  <label class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" id="rePasswordNew" name="re-password" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-rePasswordNew"></div>

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

<script src="<?=base_url()?>assets/js/function/v_formRegisterAdmin.js"></script>
