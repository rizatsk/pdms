<div class="row">
  <div class="col-12">
    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg d-flex pt-3 align-items-center justify-content-between">
          <h6 class="text-white text-capitalize ps-3">Daftar Toko</h6>
          <button class="me-2 btn btn-outline-light" id="btn-show-modal-add-shop">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle pe-1" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg> Tambah Toko</button>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lokasi</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created Date</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody class="text-capitalize">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Insert Toko -->
<div class="modal fade" id="modalInsertShop" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Pempek Management System</h5>
          <form role="form" id="formAddShop">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="card card-plain">
          <div class="card-header">
            <h4 class="font-weight-bolder" id="conditionModal"></h4>
            <p class="mb-0">Selamat Datang <?=$username?></p>
            <p class="mb-0 ">Alhamdulilah sudah buka cabang baru semoga makin suksess</p>
          </div>
          <div class="card-body">
              <input type="hidden" name="idShop" id="id-shop" class="form-control" autocomplete="off">
              <div class="input-group input-group-outline mb-3" id="div-name">
                <label class="form-label">Nama. Diawali Dengan Toko</label>
                <input type="text" id="name" name="name" class="form-control" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-name"></div>

              <div class="input-group input-group-outline mb-3" id="div-location">
                <label class="form-label">Location</label>
                <input type="text" id="location" name="location" class="form-control" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-location"></div>

              <div class="text-center">
                <button type="submit" id="btnSave" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0">Simpan</button>
                <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-lg w-100 mt-2 mb-0">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/js/function/v_shop.js"> </script>
