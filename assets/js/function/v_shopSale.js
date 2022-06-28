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

const messageValidation = (field, message = '') => {
    $(field).html('');
    $(field).append(message);
};
    
function constPrice(elementid) {
    let price = $(elementid).val();
    price = price.replace(/\./g, '');
    $(elementid).val(`${price}`);
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

const tableEmpty = `
        <tr>
          <td colspan="6" style="padding: 40px 0;">
            <div class="d-flex justify-content-center">
              <span>Data Kosong</span>
            </div>
          </td>
        </tr>`;

/* Dengan Rupiah */
$('#productPriceExpenditure').keyup(function() {
    $(this).val(`${formatInputRupiah($(this).val())}`);
});
    
$('#input-edit-price-product_expenditure').keyup(function() {
    $(this).val(`${formatInputRupiah($(this).val())}`);
});

$(document).ready(function() {
    loadTable({
        shopId: shopId,
        table: 'incomes',
        tbody: '#tbody-date-incomes',
    });

    loadTable({
        shopId: shopId,
        table: 'expenditures',
        tbody: '#tbody-date_expenditures',
    });
})

function loadTable(data) {
    $(data.tbody).html(`
        <tr>
        <td colspan="5" style="padding: 40px 0;">
          <div class="d-flex justify-content-center">
            <div class="spinner-border text-danger" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </td>
        </tr>`);
    const loadTable = data.table == 'incomes' ? 'loadTableIncome' : 'loadTableExpenditure' ;
    $.ajax({
        url: `${baseUrl}shops/shop_sales/${loadTable}`,
        type: 'POST',
        dataType: 'JSON',
        data: {
        table: data.table,
        shopId: data.shopId,
        inputDate: data.date,
        },
        success: function (result) {
        if (result.responseCode === 200) {
          $('#preloader').hide();
          const resultDatas = result.data;
          if (data.tbody == '#tbody-incomes') {
            $(data.tbody).html(``);
            if (resultDatas.length < 1 ) {
              $(data.tbody).append(`${tableEmpty}`);
            } else {
              tableIncomeOrExpenditure(resultDatas, data.tbody);
            }
          } else if (data.tbody == '#tbody-date-incomes') {
            $(data.tbody).html(``);
            if (resultDatas.length < 1 ) {
              $(data.tbody).append(`${tableEmpty}`);
            } else {
              tableDateIncomeOrExpenditure(resultDatas, data.tbody);
            }
          } else if (data.tbody == '#tbody-expenditure') {
            $(data.tbody).html(``);
            if (resultDatas.length < 1 ) {
              $(data.tbody).append(`${tableEmpty}`);
            } else {
              tableIncomeOrExpenditure(resultDatas, data.tbody);
            }
          } else if (data.tbody == '#tbody-date_expenditures') {
            $(data.tbody).html(``);
            if (resultDatas.length < 1 ) {
              $(data.tbody).append(`${tableEmpty}`);
            } else {
              tableDateIncomeOrExpenditure(resultDatas, data.tbody);
            }
          } 
        }
        },
        error: function(error) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
}

const tableIncomeOrExpenditure = (datas,tbody) => {
    let table,edit, fieldDelete;
    if (tbody == '#tbody-incomes') {
        table = '#tableIncome';
        edit = 'getIncomeById';
        fieldDelete = 'deleteIncome';
    } else if (tbody == '#tbody-expenditure') { 
        table = '#tableExpenditure';
        edit = 'getExpenditureById';
        fieldDelete = 'deleteExpenditure';
    }
    datas.forEach((dataTable) => {
    $(tbody).append(`
        <tr>
          <td>
            <p class="text-xs font-weight-bold mb-0">${dataTable.date}</p>
          </td>
          <td>
            <p class="text-xs font-weight-bold mb-0 text-capitalize">${dataTable.product_name}</p>
          </td>
          <td>
            <span class="text-secondary text-xs font-weight-bold">${dataTable.total_product}</span>
          </td>
          <td>
            <span class="text-secondary text-xs font-weight-bold">Rp. ${formatRupiah(dataTable.product_price)}</span>
          </td>
          <td>
            <span class="text-secondary text-xs font-weight-bold">Rp. ${formatRupiah(dataTable.total)}</span>
          </td>
          <td class="align-middle d-flex justify-content-end">
            <a href="javascript:${edit}('${dataTable.id}')" id="btnShowModalEdit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Shop" title="Edit">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1C6DD0" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
              </svg>
            </a>
            <span style="padding: 0 10px;"> | </span>
            <a href="javascript:${fieldDelete}('${dataTable.id}');" id="btnDelete" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" title="Delete">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e91e63" class="bi bi-x-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </a>
          </td>
        </tr>`)
    });
    
    $(table).dataTable({
        searchPanes: {
            orderable: false
        },
    });
}

const tableDateIncomeOrExpenditure = (datas, tbody) => {
    let table, edit;
    if (tbody == '#tbody-date-incomes') {
        table = '#table-incomes';
        edit = 'editDateIncome';
    } else if (tbody == '#tbody-date_expenditures') { 
        table = '#table-expenditures';
        edit = 'editDateExpenditure';
    }
    datas.forEach((dataTable) => {
        $(tbody).append(`
        <tr>
          <td>
            <p class="text-xs font-weight-bold mb-0">${dataTable.date}</p>
          </td>
          <td>
            <p class="text-xs font-weight-bold mb-0">Rp. ${formatRupiah(dataTable.total)}</p>
          </td>
          <td class="align-middle">
            <a href="javascript:${edit}('${dataTable.date}');" id="btnShowModalEdit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Shop" title="Edit">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1C6DD0" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
              </svg>
            </a>
          </td>
        </tr>`)
    });
    
    $(`${table}`).dataTable({
        searchPanes: {
            orderable: false
        },
    });
    
}

$('#input-date').datepicker(
  { 
    autoclose: true,
    format: "yyyy-mm-dd",                                          
    // startDate: new Date(new Date().setDate(new Date().getDate() - 7)),
    endDate: new Date(),
    maxDate: new Date(),
  }
);

function insertDate(event) {
    event.preventDefault();
    $('#preloader').show();
    $.ajax({
        url: `${baseUrl}shops/shop_sales/insertDate`,
        type: 'POST',
        dataType: 'JSON',
        data: $('#formInsertDate').serializeArray(),
        success: function(result) {
            $('#preloader').hide();
            const type = $('#typeDate').val();
            if (result.responseCode === 200) {
              $('#modalInsertDate').modal('hide');
              if (type === 'income') {
                showModalInsert({
                  modal: '#modalAddIncome',
                  date: result.data.date,
                  shopId: shopId,
                  table: 'incomes',
                  tbody: '#tbody-incomes',
                  selectCategory: '#categoryId'
                });
              } else {
                showModalInsert({
                  modal: '#modalAddExpenditure',
                  date: result.data.date,
                  shopId: shopId,
                  table: 'expenditures',
                  tbody: '#tbody-expenditure'
                });
              }
            } else if(result.responseCode === 400){
                messageValidation('#form-error-date', result["data"]['errorDate']);
            }
        },
        error: function (result) {
        $('#preloader').hide();
        swal({
            icon: "warning",
            title: "Gagal",
            text: `Ada ke salahan dalam sistem.`,
            button: false,
        });
        }
    });
}

function showModalInsertDate(type) {
    $('#input-date').val('');
    $('#typeDate').val(`${type}`);
    $('#modalInsertDate').modal('show');
    messageValidation('#form-error-date');
}

function showModalInsert(props) {
    const data = {
        tbody: props.tbody,
        table: props.table,
        shopId: props.shopId,
        date: props.date,
        modal: props.modal,
        selectCategory: props.selectCategory
    };

    $('#preloader').show();
    if (props.table == 'incomes') {
        $('.p-date_income').html(`Tanggal : ${props.date}`);
        $('#idShop_income').val(`${props.shopId}`);
        $('#inputDate_income').val(`${props.date}`);

        if ($("#tableIncome_wrapper").length > 0){
          $('#tableIncome').DataTable().destroy();
        }

        $('#productId').html(`<option value="" selected>-- Pilih --</option>`);
        loadComboCategory(data);
    } else {
        $('.p-date_expenditure').html(`Tanggal : ${props.date}`);
        $('#idShop_expenditure').val(`${props.shopId}`);
        $('#inputDate_expenditure').val(`${props.date}`);

        if ($("#tableExpenditure_wrapper").length > 0) {
          $('#tableExpenditure').DataTable().destroy();
        }
    }

    loadTable(data);

    $(props.modal).modal('show');
}

function loadComboCategory(data) {
    $(data.selectCategory).html(`
    <option value="" selected>-- Pilih --</option>
    <option value="99">All</option>`);

    $.ajax({
    url: `${baseUrl}companys/companys/loadCategory`,
    type: 'GET',
    dataType: 'JSON',
    success: function(result) {
        if (result.responseCode === 200) {
          const resultDatas = result.data;
          resultDatas.forEach((resultData) => {
            $(data.selectCategory).append(`<option value="${resultData.categoryid}" style="text-transform: capitalize;">${resultData.categoryname}</option>`);
          })
        }
    }
    })
};




function editDateIncome(date) {
    const data = {
        modal: '#modalAddIncome',
        date: date,
        shopId: shopId,
        table: 'incomes',
        tbody: '#tbody-incomes',
        selectCategory: '#categoryId'
    };

    showModalInsert(data);   
}

function editDateExpenditure(date) {
    const data = {
    modal: '#modalAddExpenditure',
    date: date,
    shopId: shopId,
    table: 'expenditures',
    tbody: '#tbody-expenditure'
    };

    showModalInsert(data);   
}

$('#categoryId').change(function() {
    const categoryId = $(this).val();
    $('#preloader').show();
    $.ajax({
        url: `${baseUrl}shops/shop_sales/loadComboProducts`,
        type: 'POST',
        dataType: 'JSON',
        data: {categoryId},
        success: function(result) {
            $('#preloader').hide();
            const datas = result.data;
            $('#productId').html(`<option value="" selected>-- Pilih --</option>`);
            datas.forEach((data) => {
              $('#productId').append(`<option value="${data.id}">${data.name}</option>`);
            })
        },
        error: function(error) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
});

$('#btnSaveIncome').click(function(event) {
    event.preventDefault();
    $('#preloader').show();
    const url = `${baseUrl}shops/shop_sales/addOrEditIncome`;
    $.ajax({
        url : url,
        type: 'POST',
        dataType: 'JSON',
        data: $('#formAddIncome').serialize(),
        success: function(result) {
            $('#preloader').hide();
            if (result.responseCode === 200) {
              resetForm();
            
              swal({
                icon: "success",
                title: "Berhasil",
                text: `Berhasil memasukan income.`,
                button: false,
              });
          
              refreshTable();
          
            } else if (result.responseCode === 400) {
              messageValidation('#form-error-product', result["data"]['errorProductId']);
              messageValidation('#form-error-manyProduct', result["data"]['errorManyProduct']);
            }
        },
        error: function(result) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
})

function resetForm(field = 'incomes'){
    if (field == 'incomes') {  
        $('#productId').html(`<option value="" selected>-- Pilih --</option>`);
        $('#categoryId').val('').change();
        $('#manyProduct').val('');
    } else {
        $('#productNameExpenditure').val('');
        $('#productPriceExpenditure').val('');
        $('#manyProductExpenditure').val('');
    }
}

function deleteIncome(id) {
    swal({
        icon: "warning",
        title: "Delete",
        text: "Anda yakin ingin menghapus penghasilan ini",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#preloader').show();
            $.ajax({
              url: `${baseUrl}shops/shop_sales/deleteIncome`,
              type: 'POST',
              data: {id},
              success: function(result) {
                $('#preloader').hide();

                refreshTable();
            
                swal({
                  icon: "success",
                  title: "Berhasil",
                  text: `Berhasil menghapus income.`,
                  button: false,
                });
              },
              error: function(result) {
                $('#preloader').hide();
                swal({
                  icon: "warning",
                  title: "Gagal",
                  text: `Ada ke salahan dalam sistem.`,
                  button: false,
                });
              }
            })
        }
    });
}

function getIncomeById(id) {
    $('#preloader').show();
    $.ajax({
        url: `${baseUrl}shops/shop_sales/getIncomeById/${id}`,
        type: 'GET',
        dataType: 'JSON',
        success: function(result) {
            $('#preloader').hide();
            const data = result.data;
            $('#input-editIncomeId').val(`${data.id}`)
            $('#input-editProductId').val(`${data.product_id}`);
            $('#p-productEditIncome').html(`nama produk : ${data.product_name}`);
            $('#input-editManyProduct').val(`${data.total_product}`);
            $('#modalEditIncome').modal('show');
        },
        error: function(rsult) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
}

function editIncome(event){
    event.preventDefault();
    $('#preloader').show();
    $.ajax({
        url: `${baseUrl}shops/shop_sales/editIncomeById`,
        type: 'POST',
        dataType: 'JSON',
        data: $('#formEditIncome').serialize(),
        success: function(result) {
            $('#preloader').hide();
            if (result.responseCode === 200) {
              const data = result.data;
              $('#modalEditIncome').modal('hide');
            
              swal({
                icon: "success",
                title: "Berhasil",
                text: `Berhasil memasukan edit income.`,
                button: false,
              });
          
              refreshTable();
            } else {
              messageValidation('#form-error-editManyProduct', result["data"]["errorManyProduct"])
            }
        },
        error: function(rsult) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
}

function refreshTable(field = 'incomes') {
    if (field == 'incomes') {
        // Table Date Income
        if ($("#table-incomes_wrapper").length > 0) {
        $('#table-incomes').DataTable().destroy();
        }

        loadTable({
        shopId: shopId,
        table: 'incomes',
        tbody: '#tbody-date-incomes',
        });

        // Table income
        if ($("#tableIncome_wrapper").length > 0) {
            $('#tableIncome').DataTable().destroy();
        }

        loadTable({
        date: $('#inputDate_income').val(),
        shopId: shopId,
        table: 'incomes',
        tbody: '#tbody-incomes',
        });
    } else {
        // Table Date Expenditure
        if ($("#table-expenditures_wrapper").length > 0) {
        $('#table-expenditures').DataTable().destroy();
        }

        loadTable({
        shopId: shopId,
        table: 'expenditures',
        tbody: '#tbody-date_expenditures',
        });

        // Table expenditure
        if ($("#tableExpenditure_wrapper").length > 0) {
            $('#tableExpenditure').DataTable().destroy();
        }

        loadTable({
        date: $('#inputDate_expenditure').val(),
        shopId: shopId,
        table: 'expenditures',
        tbody: '#tbody-expenditure',
        })
    }
}

// Function Expenditure
$('#btnSaveExpenditure').click(function(event) {
    event.preventDefault();
    $('#preloader').show();
    constPrice('#productPriceExpenditure');
    $('#productNameExpenditure').val(`${$('#productNameExpenditure').val().toLowerCase()}`);
    const url = `${baseUrl}shops/shop_sales/addExpenditure`;
    
    $.ajax({
        url : url,
        type: 'POST',
        dataType: 'JSON',
        data: $('#formAddExpenditure').serialize(),
        success: function(result) {
            $('#preloader').hide();
            if (result.responseCode === 200) {
              resetForm('expenditures');
            
              swal({
                icon: "success",
                title: "Berhasil",
                text: `Berhasil memasukan pengeluaran.`,
                button: false,
              });
          
              refreshTable('expenditures');
          
            } else if (result.responseCode === 400) {
              messageValidation('#form-error-productNameExpenditure', result["data"]['errorProductName']);
              messageValidation('#form-error-manyProductExpenditure', result["data"]['errorManyProduct']);
              messageValidation('#form-error-productPriceExpenditure', result["data"]['errorPriceExpenditure']);
            }
        },
        error: function(result) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
});


function deleteExpenditure(id) {
    swal({
        icon: "warning",
        title: "Delete",
        text: "Anda yakin ingin menghapus pengeluaran ini",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#preloader').show();
            $.ajax({
              url: `${baseUrl}shops/shop_sales/deleteExpenditure`,
              type: 'POST',
              data: {id},
              success: function(result) {
                $('#preloader').hide();
            
                refreshTable('expenditures');
            
                swal({
                  icon: "success",
                  title: "Berhasil",
                  text: `Berhasil menghapus pengeluaran.`,
                  button: false,
                });
              },
              error: function(result) {
                $('#preloader').hide();
                swal({
                  icon: "warning",
                  title: "Gagal",
                  text: `Ada ke salahan dalam sistem.`,
                  button: false,
                });
              }
            })
        }
    });
}

function getExpenditureById(id) {
    $('#preloader').show();
    $.ajax({
        url: `${baseUrl}shops/shop_sales/getExpenditureById/${id}`,
        type: 'GET',
        dataType: 'JSON',
        success: function(result) {
            $('#preloader').hide();
            const data = result.data;
            $('#input-editExpenditureId').val(`${data.id}`);
            $('#input-editNameProductExpenditure').val(`${data.product_name}`);
            $('#input-edit-price-product_expenditure').val(`${formatInputRupiah(data.product_price)}`);
            $('#input-edit-many-product_expenditure').val(`${data.product_many}`);
            $('#input-editExpenditureDate').val(`${data.date}`);
            $('#editExpenditureShopId').val(`${shopId}`);
            $('#modalEditExpenditure').modal('show');
        },
        error: function(rsult) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
}

function editExpenditure(event){
    event.preventDefault();
    constPrice('#input-edit-price-product_expenditure');
    $('#preloader').show();
    $.ajax({
        url: `${baseUrl}shops/shop_sales/editExpenditureById`,
        type: 'POST',
        dataType: 'JSON',
        data: $('#formEditExpenditure').serialize(),
        success: function(result) {
            $('#preloader').hide();
            if (result.responseCode === 200) {
              const data = result.data;
              $('#modalEditExpenditure').modal('hide');
            
              swal({
                icon: "success",
                title: "Berhasil",
                text: `Berhasil memasukan edit pengeluaran.`,
                button: false,
              });
          
              refreshTable('expenditures');
            } else {
              messageValidation('#form-error-editNameProductExpenditure', result["data"]["errorNameProduct"])
              messageValidation('#form-error-editPriceProductExpenditure', result["data"]["errorPriceProduct"])
              messageValidation('#form-error-editManyProductExpenditure', result["data"]["errorManyProduct"])
            }
        },
        error: function(rsult) {
            $('#preloader').hide();
            swal({
              icon: "warning",
              title: "Gagal",
              text: `Ada ke salahan dalam sistem.`,
              button: false,
            });
        }
    })
}
