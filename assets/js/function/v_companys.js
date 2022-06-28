let companyId,
    userId,
    baseUrl = 'http://whoami.co.id/pdms/',
    roleId,
    companyName;

$.ajax({
    url: `${baseUrl}dashboard/getData`,
    type: 'GET',
    dataType: 'JSON',
    success: function(result) {
      if (result.responseCode === 200) {
        const datas = result.data;
        companyId = datas.companyId;
        userId = datas.userId;
        roleId = datas.roleId;
        companyName = datas.companyName;
      };
    }
});

function constPrice() {
    let price = $('#productPrice').val();
    price = price.replace(/\./g, '');
    $('#productPrice').val(`${price}`);
}

/* Fungsi */
function formatInputRupiah(angka)
{
    let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split    = number_string.split(','),
        sisa     = split[0].length % 3,
        rupiah     = split[0].substr(0, sisa),
        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah == undefined ? rupiah : (rupiah ? rupiah : '');
}
  
function formatRupiah(value) {
    let	number_string = value.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return rupiah;
}

/* Dengan Rupiah */
$('#productPrice').keyup(function() {
  $(this).val(`${formatInputRupiah($(this).val())}`);
});

const messageValidation = (field, message = '') => {
  $(field).html('');
  $(field).append(message);
};

function getCompanyById(id) {
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}companys/companys/ajaxGetCompanyById/${companyId}`,
      dataType: 'JSON',
      type: 'GET',
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          const data = result.data;
          $('#companyId').val(`${data.id}`);
          $('#companyName').val(`${data.name}`);
          $('#modalEditCompany').modal('show');
        }
      },
      error : function(error) {
        $('#preloader').hide();
        swal({
          icon: "warning",
          title: "Failed",
          text: 'Ada ke salahan dalam sistem.',
          button: false,
        });
      }
    })
}

$('#btnSaveProfileCompany').click(function(e) {
    e.preventDefault();
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}companys/companys/updateCompanyName`,
      dataType: 'JSON',
      type: 'POST',
      data: $('#formEditCompany').serialize(),
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          $('#modalEditCompany').modal('hide');
          $('#h5CompanyName').html(`${result.data.companyName}`);
          $('#navbarLiCompanyName').html(`${result.data.companyName}`);
          $('#headerPage').html(`${result.data.companyName}`);
          $('#page').html(`${result.data.companyName}`);
          $('#detailLiCompanyName').html(`${result.data.companyName}`);
          $('#headerCompanyName').html(`${result.data.companyName}`);
          swal({
            icon: "success",
            title: "Success",
            text: "Berhasil update nama usaha",
            button: false,
          });
        } else if(result.responseCode === 400){
          messageValidation('#form-error-companyName', result["data"]['errorCompanyName']);
        }
      },
      error : function(error) {
        $('#preloader').hide();
        swal({
          icon: "warning",
          title: "Failed",
          text: 'Ada ke salahan dalam sistem.',
          button: false,
        });
      }
    })
});

$(document).ready(function(){
    loadCategory();
    loadProducts();
});

function loadCategory() {
    $('#tbodyCategory').html(`
      <tr>
        <td colspan="4" style="padding: 40px 0;">
          <div class="d-flex justify-content-center">
            <div class="spinner-border text-danger" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </td>
      </tr>`);
    
    $.ajax({
      url: `${baseUrl}companys/companys/loadCategory`,
      dataType: 'JSON',
      type: 'GET',
      success: function(result) {
        $('#preloader').hide();
        const datas = result.data;
        $('#tbodyCategory').html('');
        if (datas.length < 1) {
          $('#tbodyCategory').append(`
            <tr>
              <td colspan="4" style="padding: 40px 0;">
                <div class="d-flex justify-content-center">
                  <span>Category Kosong</span>
                </div>
              </td>
            </tr>`);
        } else {          
          datas.forEach((data) => {
            $('#tbodyCategory').append(`
              <tr class="d-flex justify-content-between">
                <td>
                  <div class="d-flex px-0 py-0">
                    <div class="d-flex flex-column justify-content-center">
                      <p class="mb-0 text-sm" style="text-transform:capitalize;color: black;">${data.categoryname}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <a href="javascript:addOrEditCategory('Edit Category', '${data.categoryid}', '${data.categoryname}');" id="btnShowModalEdit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Shop" title="Edit Category">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1C6DD0" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                  </a>
                  <span style="padding: 0 10px;"> | </span>
                  <a href="javascript:deleteCategory('${data.categoryid}');" id="btnDelete" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" title="Delete Category">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e91e63" class="bi bi-x-square" viewBox="0 0 16 16">
                      <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                  </a>
                </td>
              </tr>`);
          });

          $('#tableCategory').dataTable({
            searchPanes: {
              orderable: false
            },
          });
        }
      },
      error : function(error) {
        $('#preloader').hide();
        swal({
          icon: "warning",
          title: "Failed",
          text: 'Ada ke salahan dalam sistem.',
          button: false,
        });
      }
    });
}

function addOrEditCategory(title, categoryId = null, categoryName = null) {
    $('#h6ModalCategory').html(`${title}`);
    
    if (categoryId !== null) {
        $('#categoryId').val(`${categoryId}`);
        $('#div-categoryName').addClass('is-focused');
        $('#categoryName').val(`${categoryName}`);
    } else {
        $('#categoryId').val('');
        $('#categoryName').val('');
        $('#div-categoryName').removeClass('is-focused');
        $('#div-categoryName').removeClass('is-filled');
    }
    // Clear validation
    messageValidation('#form-error-categoryName');
    $('#modalAddOrEditCategory').modal('show');
}

$('#btnSaveCategory').click((event) => {
    event.preventDefault();
    $('#preloader').show();
    let message = 'Berhasil menamnbahkan category';

    if ($('#categoryId').val() !== '') {
      message = 'Berhasil update category';
    };

    $.ajax({
      url: `${baseUrl}companys/companys/addOrEditCategory`,
      dataType: 'JSON',
      type: 'POST',
      data: $('#formAddOrEditCategory').serialize(),
      success: function(result) {
        if (result.responseCode === 200) {
          $('#modalAddOrEditCategory').modal('hide');

          if ($("#tableCategory_wrapper").length > 0){
            $('#tableCategory').DataTable().destroy();
          }
          loadCategory();

          if ($('#tableProduct_wrapper').length > 0){
            $('#tableProduct').DataTable().destroy();
          }
          loadProducts();

          swal({
            icon: "success",
            title: "Success",
            text: `${message}`,
            button: false,
          });
        } else if(result.responseCode === 400){
          $('#preloader').hide();
          messageValidation('#form-error-categoryName', result["data"]['errorCategoryName']);
        }
      },
      error : function(error) {
        $('#preloader').hide();
        swal({
          icon: "warning",
          title: "Failed",
          text: 'Ada ke salahan dalam sistem.',
          button: false,
        });
      }
    })
});

function deleteCategory(id){
    swal({
      title: "Delete",
      text: "Anda yakin ingin menghapus category ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#preloader').show();
        $.ajax({
          url: `${baseUrl}companys/companys/deleteCategory`,
          dataType: 'JSON',
          type: 'POST',
          data: {
            'categoryId': id,
          },
          success: function(result) {
            if (result.responseCode === 200) {

              if ($("#tableCategory_wrapper").length > 0){
                $('#tableCategory').DataTable().destroy();
              }
              loadCategory();
            
              if ($('#tableProduct_wrapper').length > 0){
                $('#tableProduct').DataTable().destroy();
              }
              loadProducts();

              swal({
                icon: "success",
                title: "Success",
                text: `Berhasil menghapus category`,
                button: false,
              });
            }
          },
          error : function(error) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Failed",
              text: 'Ada ke salahan dalam sistem.',
              button: false,
            });
          }
        });
      }
    });
}

function loadProducts() {
    $('#tbodyProduct').html(`
      <tr>
        <td colspan="4" style="padding: 40px 0;">
          <div class="d-flex justify-content-center">
            <div class="spinner-border text-danger" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </td>
      </tr>`);
    
    $.ajax({
      url: `${baseUrl}companys/companys/loadProducts`,
      dataType: 'JSON',
      type: 'GET',
      success: function(result) {
        $('#preloader').hide();
        const datas = result.data;
        $('#tbodyProduct').html('');
        if (datas.length < 1) {
          $('#tbodyProduct').append(`
            <tr>
              <td colspan="4" style="padding: 40px 0;">
                <div class="d-flex justify-content-center">
                  <span>Product Kosong</span>
                </div>
              </td>
            </tr>`);
        } else {          
          datas.forEach((data) => {
            $('#tbodyProduct').append(`
              <tr>
                <td>
                  <div class="d-flex px-0 py-0">
                    <div class="">
                      <p class="mb-0 text-sm" style="text-transform:capitalize;color: black;">${data.productname}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex px-0 py-0">
                    <div class="">
                      <p class="mb-0 text-sm" style="text-transform:capitalize;color: black;">Rp. ${formatRupiah(data.productprice)}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex px-0 py-0">
                    <div class="">
                      <p class="mb-0 text-sm" style="text-transform:capitalize;color: black;">${data.categoryname == null ? 'Tidak Ada' : data.categoryname}</p>
                    </div>
                  </div>
                </td>
                <td class="d-flex justify-content-end">
                  <a href="javascript:addOrEditProduct('Edit Produk', '${data.productid}', '${data.productname}', '${data.categoryid}', '${data.productprice}');" id="btnShowModalEdit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Shop" title="Edit Product">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1C6DD0" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      </svg>
                  </a>
                  <span style="padding: 0 10px;"> | </span>
                  <a href="javascript:deleteProduct('${data.productid}');" id="btnDelete" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" title="Delete Product">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e91e63" class="bi bi-x-square" viewBox="0 0 16 16">
                      <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                  </a>
                </td>
              </tr>`);
          });

          $('#tableProduct').dataTable({
            searchPanes: {
              orderable: false
            },
          });
        }
      },
      error : function(error) {
        $('#preloader').hide();
        swal({
          icon: "warning",
          title: "Failed",
          text: 'Ada ke salahan dalam sistem.',
          button: false,
        });
      }
    });
}

function addOrEditProduct(title, productId = null, productName = null, productCategoryId = null, productPrice = null) {
    $('#preloader').show();
    loadComboCategories('#productCategoryId', productCategoryId);
    $('#h6ModalProduct').html(`${title}`);
    
    if (productId !== null) {
        $('#productId').val(`${productId}`);
        $('#div-productName').addClass('is-focused');
        $('#productName').val(`${productName}`);
        $('#div-productPrice').addClass('is-focused');
        $('#productPrice').val(`${formatInputRupiah(productPrice)}`);
    } else {
        $('#productId').val('');
        $('#productName').val('');
        $('#productPrice').val('');
        $('#div-productName').removeClass('is-focused');
        $('#div-productName').removeClass('is-filled');
        $('#div-productPrice').removeClass('is-focused');
        $('#div-productPrice').removeClass('is-filled');
    }

    // Clear validation
    messageValidation('#form-error-productName');
    $('#modalAddOrEditProduct').modal('show');
}

function loadComboCategories(field, categoryId = null) {
    $.ajax({
      url: `${baseUrl}companys/companys/loadCategory`,
      type: 'GET',
      dataType: 'JSON',
      success: function (result) {
        $('#preloader').hide();
        $(`${field}`).html('');
        $(`${field}`).append(`<option value="" selected>-- Pilih --</option>`);
        const datas = result.data;
        datas.forEach((data) => {
          $(`${field}`).append(`<option value="${data.categoryid}" style="text-transform: capitalize;">${data.categoryname}</option>`);
        })
        $(`${field}`).append(`<option value="">Tidak Ada</option>`);
        if (categoryId != 'null' && categoryId != null){
          console.log(categoryId);
          $(`${field}`).val(`${categoryId}`).change();
        }
      },
      error : function(error) {
        $('#preloader').hide();
        swal({
          icon: "warning",
          title: "Failed",
          text: 'Ada ke salahan dalam sistem.',
          button: false,
        });
      }
    })
}


$('#btnSaveProduct').click(function(e) {
    e.preventDefault();
    $('#preloader').show();
    
    constPrice();      
    let message = 'Berhasil menamnbahkan produk';

    if ($('#productId').val() !== '') {
      message = 'Berhasil update produk';
    };

    $.ajax({
      url: `${baseUrl}companys/companys/addOrEditProduct`,
      dataType: 'JSON',
      type: 'POST',
      data: $('#formAddOrEditProduct').serialize(),
      success: function(result) {
        if (result.responseCode === 200) {
          $('#modalAddOrEditProduct').modal('hide');

          if ($('#tableProduct_wrapper').length > 0){
            $('#tableProduct').DataTable().destroy();
          }
          loadProducts();

          swal({
            icon: "success",
            title: "Success",
            text: `${message}`,
            button: false,
          });
        } else if(result.responseCode === 400){
          $('#preloader').hide();
          messageValidation('#form-error-productName', result["data"]['errorProductName']);
          messageValidation('#form-error-productPrice', result["data"]['errorProductPrice']);
        }
      },
      error : function(error) {
        $('#preloader').hide();
        swal({
          icon: "warning",
          title: "Failed",
          text: 'Ada ke salahan dalam sistem.',
          button: false,
        });
      }
    })
  })

  function deleteProduct(id){
    swal({
      title: "Delete",
      text: "Anda yakin ingin menghapus produk ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#preloader').show();
        $.ajax({
          url: `${baseUrl}companys/companys/deleteProduct`,
          dataType: 'JSON',
          type: 'POST',
          data: {
            'productId': id,
          },
          success: function(result) {
            if (result.responseCode === 200) {
              if ($('#tableProduct_wrapper').length > 0){
                $('#tableProduct').DataTable().destroy();
              }
              loadProducts();
              
              swal({
                icon: "success",
                title: "Success",
                text: `Berhasil menghapus product`,
                button: false,
              });
            }
          },
          error : function(error) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Failed",
              text: 'Ada ke salahan dalam sistem.',
              button: false,
            });
          }
        });
      }
    });
  }