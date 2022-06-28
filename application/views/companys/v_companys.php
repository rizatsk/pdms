<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>


<div class="container-fluid px-2 px-md-4">
      <div class="card card-body ">
        <div class="row gx-4 mb-2">
          <div class="col-auto">
            <div class="avatar avatar-xl">
              <img src="<?=base_url()?>assets/img/illustrations/profile.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1" style="text-transform: capitalize;" id="headerCompanyName">
                <?=$companyName?>
              </h5>
              <p class="mb-0 font-weight-normal text-sm">
                Selamat Datang, Anda dapat mengubah data usaha anda di sini.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <p>Tanggal Dibikin Usaha :  <span><?=$companyCreatedAt?></span></p>
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
                      <h6 class="mb-0">Informasi Usaha Anda</h6>
                    </div>
                    <div class="col-md-4 text-end" id="divEditUser">
                      <!-- <a href="javascript:;"> -->
                        <!-- <i class="fas fa-user-edit text-secondary text-sm"></i> -->
                      <!-- </a> -->
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <p class="text-sm">
                    Terima kasih telah menggunakan aplikasi PDMS ini, gunakan dengan bijak
                    dan sesuai kebutuhan. 
                  </p>
                  <hr class="horizontal gray-light my-2">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">ID Companys:</strong> &nbsp; <?=$companyId?></li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm" style="text-transform: capitalize;"><strong class="text-dark">Nama Usaha:</strong> &nbsp; <span id="detailLiCompanyName"><?=$companyName?></span>
                      <a href="javascript:getCompanyById('<?=$companyId?>')" class="ms-3" title="Ganti Nama Usaha">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1C6DD0" class="bi bi-pencil-square" viewBox="0 0 16 16">
                          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                      </a>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Update Terakhir:</strong> &nbsp; <?=$companyUpdatedAt?></li>
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

          <!-- Category -->
          <div class="row">
            <div class="col-12 col-xl-5 border-table m-4">
              <div class="card card-plain h-100 m-2">
                <div class="card-header pb-0 p-1 d-flex justify-content-between">
                  <h6 class="mb-0">Category</h6>
                  <div class="col-md-4 text-end" id="divAddCategory">
                    <a href="javascript:addOrEditCategory('Tambah Category');" title="Tambah Category">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#1C6DD0" class="bi bi-plus-square-dotted" viewBox="0 0 16 16">
                        <path d="M2.5 0c-.166 0-.33.016-.487.048l.194.98A1.51 1.51 0 0 1 2.5 1h.458V0H2.5zm2.292 0h-.917v1h.917V0zm1.833 0h-.917v1h.917V0zm1.833 0h-.916v1h.916V0zm1.834 0h-.917v1h.917V0zm1.833 0h-.917v1h.917V0zM13.5 0h-.458v1h.458c.1 0 .199.01.293.029l.194-.981A2.51 2.51 0 0 0 13.5 0zm2.079 1.11a2.511 2.511 0 0 0-.69-.689l-.556.831c.164.11.305.251.415.415l.83-.556zM1.11.421a2.511 2.511 0 0 0-.689.69l.831.556c.11-.164.251-.305.415-.415L1.11.422zM16 2.5c0-.166-.016-.33-.048-.487l-.98.194c.018.094.028.192.028.293v.458h1V2.5zM.048 2.013A2.51 2.51 0 0 0 0 2.5v.458h1V2.5c0-.1.01-.199.029-.293l-.981-.194zM0 3.875v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zM0 5.708v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zM0 7.542v.916h1v-.916H0zm15 .916h1v-.916h-1v.916zM0 9.375v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zm-16 .916v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zm-16 .917v.458c0 .166.016.33.048.487l.98-.194A1.51 1.51 0 0 1 1 13.5v-.458H0zm16 .458v-.458h-1v.458c0 .1-.01.199-.029.293l.981.194c.032-.158.048-.32.048-.487zM.421 14.89c.183.272.417.506.69.689l.556-.831a1.51 1.51 0 0 1-.415-.415l-.83.556zm14.469.689c.272-.183.506-.417.689-.69l-.831-.556c-.11.164-.251.305-.415.415l.556.83zm-12.877.373c.158.032.32.048.487.048h.458v-1H2.5c-.1 0-.199-.01-.293-.029l-.194.981zM13.5 16c.166 0 .33-.016.487-.048l-.194-.98A1.51 1.51 0 0 1 13.5 15h-.458v1h.458zm-9.625 0h.917v-1h-.917v1zm1.833 0h.917v-1h-.917v1zm1.834-1v1h.916v-1h-.916zm1.833 1h.917v-1h-.917v1zm1.833 0h.917v-1h-.917v1zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                      </svg>
                    </a>
                  </div>
                </div>
                <div class="card-body pb-0 px-0">
                  <div class="p-0">
                    <table class="table mb-0 px-0 pt-0 display align-items-center" id="tableCategory">
                      <thead>
                        <tr class="d-flex justify-content-between">
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                          <th class="text-uppercase text-xxs opacity-7">Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="tbodyCategory">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Category -->

            <!-- Produk -->
            <div class="col-12 col-xl-6 border-table m-4">
              <div class="card card-plain h-100 m-2">
                <div class="card-header pb-0 p-1 d-flex justify-content-between">
                  <h6 class="mb-0">Produk</h6>
                  <div class="col-md-4 text-end" id="divAddProduct">
                    <a href="javascript:addOrEditProduct('Tambah Produk');" title="Tambah Produk">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#1C6DD0" class="bi bi-plus-square-dotted" viewBox="0 0 16 16">
                        <path d="M2.5 0c-.166 0-.33.016-.487.048l.194.98A1.51 1.51 0 0 1 2.5 1h.458V0H2.5zm2.292 0h-.917v1h.917V0zm1.833 0h-.917v1h.917V0zm1.833 0h-.916v1h.916V0zm1.834 0h-.917v1h.917V0zm1.833 0h-.917v1h.917V0zM13.5 0h-.458v1h.458c.1 0 .199.01.293.029l.194-.981A2.51 2.51 0 0 0 13.5 0zm2.079 1.11a2.511 2.511 0 0 0-.69-.689l-.556.831c.164.11.305.251.415.415l.83-.556zM1.11.421a2.511 2.511 0 0 0-.689.69l.831.556c.11-.164.251-.305.415-.415L1.11.422zM16 2.5c0-.166-.016-.33-.048-.487l-.98.194c.018.094.028.192.028.293v.458h1V2.5zM.048 2.013A2.51 2.51 0 0 0 0 2.5v.458h1V2.5c0-.1.01-.199.029-.293l-.981-.194zM0 3.875v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zM0 5.708v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zM0 7.542v.916h1v-.916H0zm15 .916h1v-.916h-1v.916zM0 9.375v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zm-16 .916v.917h1v-.917H0zm16 .917v-.917h-1v.917h1zm-16 .917v.458c0 .166.016.33.048.487l.98-.194A1.51 1.51 0 0 1 1 13.5v-.458H0zm16 .458v-.458h-1v.458c0 .1-.01.199-.029.293l.981.194c.032-.158.048-.32.048-.487zM.421 14.89c.183.272.417.506.69.689l.556-.831a1.51 1.51 0 0 1-.415-.415l-.83.556zm14.469.689c.272-.183.506-.417.689-.69l-.831-.556c-.11.164-.251.305-.415.415l.556.83zm-12.877.373c.158.032.32.048.487.048h.458v-1H2.5c-.1 0-.199-.01-.293-.029l-.194.981zM13.5 16c.166 0 .33-.016.487-.048l-.194-.98A1.51 1.51 0 0 1 13.5 15h-.458v1h.458zm-9.625 0h.917v-1h-.917v1zm1.833 0h.917v-1h-.917v1zm1.834-1v1h.916v-1h-.916zm1.833 1h.917v-1h-.917v1zm1.833 0h.917v-1h-.917v1zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                      </svg>
                    </a>
                  </div>
                </div>
                <div class="card-body pb-0 px-0">
                  <div class="p-0">
                    <table class="table mb-0 px-0 pt-0 display align-items-center" id="tableProduct">
                      <thead>
                        <tr class="">
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                          <th class="text-uppercase text-xxs opacity-7 d-flex justify-content-end">Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="tbodyProduct">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Produk -->

          </div>
        </div>
    </div>
</div>

<!-- Modal Edit Company -->
<div class="modal fade" id="modalEditCompany" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
        <form role="form" id="formEditCompany">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
          <div class="card card-plain">
            <div class="card-body mt-3" id="card-modal-body" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; padding: 20px; border-radius: 5px;">
                <h6>Rubah Data Company</h6>
                <hr>
                <input type="hidden" id="companyId">
                <div class="input-group is-focused  input-group-outline mb-3" id="div-companyName">
                  <label class="form-label">Nama Usaha</label>
                  <input type="text" id="companyName" name="companyName" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-companyName"></div>

                <div class="text-center">
                  <button type="submit" id="btnSaveProfileCompany" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-2 mb-0">Simpan</button>
                  <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-lg w-100 mt-2 mb-0">Cancel</button>
                </div>
            </div>
        </form>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Add Or Edit Category -->
<div class="modal fade" id="modalAddOrEditCategory" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
        <form role="form" id="formAddOrEditCategory">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
          <div class="card card-plain">
            <div class="card-body mt-3" id="card-modal-body" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; padding: 20px; border-radius: 5px;">
                <h6 id="h6ModalCategory"></h6>
                <hr>
                <input type="hidden" id="categoryId" name="categoryId">
                <div class="input-group input-group-outline mb-3" id="div-categoryName">
                  <label class="form-label">Nama Category</label>
                  <input type="text" id="categoryName" name="categoryName" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-categoryName"></div>

                <div class="text-center">
                  <button type="submit" id="btnSaveCategory" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-2 mb-0">Simpan</button>
                  <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-lg w-100 mt-2 mb-0">Cancel</button>
                </div>
            </div>
        </form>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Add Or Edit Product -->
<div class="modal fade" id="modalAddOrEditProduct" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
        <form role="form" id="formAddOrEditProduct">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
          <div class="card card-plain">
            <div class="card-body mt-3" id="card-modal-body" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; padding: 20px; border-radius: 5px;">
                <h6 id="h6ModalProduct"></h6>
                <hr>
                <input type="hidden" id="productId" name="productId">
                <div class="input-group input-group-outline mb-3" id="div-productName">
                  <label class="form-label">Nama Produk</label>
                  <input type="text" id="productName" name="productName" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-productName"></div>

                <div class="input-group input-group-outline mb-3 is-focused" id="div-productCategoryId">
                  <label class="form-label">Kategori</label>
                  <select style="text-transform: capitalize;" id="productCategoryId" name="productCategoryId" class="form-control" autocomplete="off">
                  </select>
                </div>
                <div class="message-error" id="form-error-productCategoryId"></div>

                <div class="input-group input-group-outline mb-3" id="div-productPrice">
                  <label class="form-label">Harga</label>
                  <input type="text" id="productPrice" name="productPrice" class="form-control" autocomplete="off">
                </div>
                <div class="message-error" id="form-error-productPrice"></div>

                <div class="text-center">
                  <button type="submit" id="btnSaveProduct" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-2 mb-0">Simpan</button>
                  <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-lg w-100 mt-2 mb-0">Cancel</button>
                </div>
            </div>
        </form>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<script src="<?=base_url()?>assets/js/function/v_companys.js"></script>
