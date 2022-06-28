<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" ></script>

<div class="row">
  <div class="col-6">
    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg d-flex pt-3 align-items-center justify-content-between">
          <h6 class="text-white text-capitalize ps-3">Penghasilan</h6>
          <button class="me-2 btn btn-outline-light" id="btn-show-modal-add-income" onclick="javascript:showModalInsertDate('income')">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle pe-1" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg> Tambah Penghasilan</button>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-3">
          <table class="table align-items-center mb-0" id="table-incomes">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Penghasilan</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
              </tr>
            </thead>
            <tbody id="tbody-date-incomes">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg d-flex pt-3 align-items-center justify-content-between">
          <h6 class="text-white text-capitalize ps-3">Pengeluaran</h6>
          <button class="me-2 btn btn-outline-light" id="btn-show-modal-add-shop" onclick="javascript:showModalInsertDate('expenditure')">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle pe-1" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg> Tambah Pengeluaran</button>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-3">
          <table class="table align-items-center mb-0" id="table-expenditures">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Pengeluaran</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody id="tbody-date_expenditures">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal  Inser Date -->
<div class="modal fade" id="modalInsertDate" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
          <form role="form" id="formInsertDate">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="card card-plain">
          <div class="card-header">
            <p class="mb-0">Pilih tanggal yang ingin dimasukan</p>
          </div>
          <div class="card-body mt-n4">
              <input type="hidden" name="shopId" value="<?=$idShop?>">
              <input type="hidden" name="typeDate" id="typeDate" class="form-control" autocomplete="off">
              <div class="input-group input-group-outline mb-3" id="div-name">
                <input type="text" id="input-date" name="input-date" class="form-control input-date" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-date"></div>

              <div class="text-center">
                <button type="submit" id="btnSaveDate" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0" onclick="javascript:insertDate(event);">Simpan</button>
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

<!-- Modal  -->
<div class="modal fade" id="modalAddIncome" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
          <form role="form" id="formAddIncome">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="card card-plain">
          <div class="card-header">
            <h4 class="font-weight-bolder">Tambahkan Penghasilan</h4>
            <p class="p-date_income"></p>
          </div>
          <div class="card-body mt-n5"> 
              <input type="hidden" name="idShop" id="idShop_income" class="form-control" autocomplete="off">
              <input type="hidden" name="inputDate" id="inputDate_income">

              <label class="form-label">Kategori Produk</label>
              <div class="input-group input-group-outline mb-3" id="div-categoryId">
                <select id="categoryId" name="categoryId" class="form-control" autocomplete="off" style="text-transform: capitalize;">
                </select>
              </div>
              <div class="message-error" id="form-error-category"></div>

              <label class="form-label">Produk</label>
              <div class="input-group input-group-outline mb-3" id="div-productId">
                <select id="productId" name="productId" class="form-control" autocomplete="off" style="text-transform: capitalize;">
                </select>
              </div>
              <div class="message-error" id="form-error-product"></div>

              <label class="form-label">Banyak Produk</label>
              <div class="input-group input-group-outline mb-3" id="div-manyProduct">
                <input id="manyProduct" type="number" name="manyProduct" class="form-control" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-manyProduct"></div>

              <div class="text-center">
                <button type="submit" id="btnSaveIncome" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0">Simpan</button>
                <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-lg w-100 mt-2 mb-0">Keluar</button>
              </div>
            </form>

            <div class="mt-5 table-responsive p-0">
              <table class="table align-items-center mb-0" id="tableIncome">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produk</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Banyak Produk</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga/pcs</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                  </tr>
                </thead>
                <tbody id="tbody-incomes">
                </tbody>
              </table>
            </div>
        
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Add Expenditure -->
<div class="modal fade" id="modalAddExpenditure" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System</h5>
        <form role="form" id="formAddExpenditure">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="card card-plain">
          <div class="card-header">
            <h4 class="font-weight-bolder">Tambahkan Pengeluaran</h4>
            <p class="p-date_expenditure"></p>
          </div>
          <div class="card-body mt-n5"> 
              <input type="hidden" name="idShop" id="idShop_expenditure" class="form-control" autocomplete="off">
              <input type="hidden" name="inputDate" id="inputDate_expenditure">

              <div class="input-group input-group-outline mb-2" id="div-productNameExpenditure">
                <label class="form-label">Nama Produk</label>
                <input id="productNameExpenditure" name="productNameExpenditure" class="form-control" autocomplete="off" style="text-transform: capitalize;">
              </div>
              <div class="message-error" id="form-error-productNameExpenditure"></div>

              <div class="input-group input-group-outline mb-4 mt-4" id="div-priceExpenditure">
                <label class="form-label">Harga/pcs</label>
                <input id="productPriceExpenditure" name="productPriceExpenditure" class="form-control" autocomplete="off" style="text-transform: capitalize;">
              </div>
              <div class="message-error" id="form-error-productPriceExpenditure"></div>

              <label class="form-label">Banyak Produk</label>
              <div class="input-group input-group-outline mb-2" id="div-manyProductExpenditure">
                <input id="manyProductExpenditure" type="number" name="manyProductExpenditure" class="form-control" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-manyProductExpenditure"></div>

              <div class="text-center">
                <button type="submit" id="btnSaveExpenditure" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0">Simpan</button>
                <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-lg w-100 mt-2 mb-0">Keluar</button>
              </div>
            </form>

            <div class="mt-5 table-responsive p-0">
              <table class="table align-items-center mb-0" id="tableExpenditure">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produk</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Banyak Produk</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga/pcs</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                  </tr>
                </thead>
                <tbody id="tbody-expenditure">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Edit Income -->
<div class="modal fade" id="modalEditIncome" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System </h5>
          <form role="form" id="formEditIncome">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="card card-plain">
          <div class="card-header">
            <p class="mb-0">Edit Income</p>
          </div>
          <div class="card-body mt-n4">
              <input type="hidden" name="incomeId" id="input-editIncomeId">
              <input type="hidden" name="productId" id="input-editProductId">
              <p id="p-productEditIncome" class="text-dark text-capitalize"></p>
              <div class="input-group input-group-outline mb-3" id="div-name">
                <input type="text" id="input-editManyProduct" name="editManyProduct" class="form-control" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-editManyProduct"></div>

              <div class="text-center">
                <button type="submit" id="btnSaveEditIncome" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0" onclick="javascript:editIncome(event);">Simpan</button>
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

<!-- Modal Edit Expenditure -->
<div class="modal fade" id="modalEditExpenditure" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Productive Data Management System </h5>
          <form role="form" id="formEditExpenditure">
        <button type="reset" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="card card-plain">
          <div class="card-header">
            <p class="mb-0">Edit Expenditure</p>
          </div>
          <div class="card-body mt-n4">
              <input type="hidden" name="expenditureId" id="input-editExpenditureId">
              <input type="hidden" name="expenditureDate" id="input-editExpenditureDate">
              <input type="hidden" name="idShop" id="editExpenditureShopId">
              
              <label class="form-label">Nama Produk</label>
              <div class="input-group input-group-outline mb-3" id="div-nameProductExpenditure">
                <input type="text" id="input-editNameProductExpenditure" name="editNameProduct" class="form-control" autocomplete="off" style="text-transform: capitalize;">
              </div>
              <div class="message-error" id="form-error-editNameProductExpenditure"></div>

              <label class="form-label">Harga/pcs</label>
              <div class="input-group input-group-outline mb-3" id="div-edit-price-product_expenditure">
                <input type="text" id="input-edit-price-product_expenditure" name="editPriceProduct" class="form-control" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-editPriceProductExpenditure"></div>

              <label class="form-label">Banyak Produk</label>
              <div class="input-group input-group-outline mb-2" id="div-edit-many-product_expenditure">
                <input id="input-edit-many-product_expenditure" type="number" name="editManyProduct" class="form-control" autocomplete="off">
              </div>
              <div class="message-error" id="form-error-editManyProductExpenditure"></div>

              <div class="text-center">
                <button type="submit" id="btnSaveEditExpenditure" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0" onclick="javascript:editExpenditure(event);">Simpan</button>
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

<script>
  const shopId = '<?=$idShop?>';
</script>
<script src="<?=base_url()?>assets/js/function/v_shopSale.js"></script>
