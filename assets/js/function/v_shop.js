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

$(document).ready(function() {
  loadTable();
})

function loadListShop() {
    $.ajax({
      url: `${baseUrl}shops/shops/loadTable/${companyId}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(result) {
        if (result.responseCode === 200) {
          const datas = result.data;
          $('#list-shop').html('');
          datas.forEach((data) => {
            $('#list-shop').append(`
              <li class="nav-item">
                <a class="nav-link text-white " href="<?= base_url()?>shops/Shops">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                      <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                    </svg>
                  </div>
                  <span class="nav-link-text ms-1" style="text-transform: capitalize;">${data.name}</span>
                </a>
              </li>`);
          })
        };
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
};

const loadTable = () => {
  $('tbody').append(`
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
    url: `${baseUrl}shops/Shops/loadTable/${companyId}`,
    type: 'POST',
    dataType: 'JSON',
    success: function(result) {
      if (result.responseCode === 200) {
        $('tbody').html('');
        const datas = result.data;
        datas.forEach((data) => {
          $('tbody').append(`
          <tr>
            <td>
              <div class="d-flex px-2 py-1">
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-sm">${data.name}</h6>
                  <p class="text-xs text-secondary mb-0">${data.id}</p>
                </div>
              </div>
            </td>
            <td>
              <p class="text-xs font-weight-bold mb-0">${data.location}</p>
            </td>
            <td class="align-middle text-center">
              <span class="text-secondary text-xs font-weight-bold">${data.created_at}</span>
            </td>
            <td class="align-middle">
              <a href="javascript:editShop('${data.id}')" id="btnShowModalEdit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Shop" title="Edit Shop">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1C6DD0" class="bi bi-pencil-square" viewBox="0 0 16 16">
                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </a>
              <span style="padding: 0 10px;"> | </span>
              <a href="javascript:deleteShop('${data.id}');" id="btnDelete" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" title="Delete Shop">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e91e63" class="bi bi-x-square" viewBox="0 0 16 16">
                  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
              </a>
            </td>
          </tr>`);
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
  })
};
  
function deleteShop(id) {
    swal({
      title: "Delete",
      text: "Anda yakin ingin menghapus toko ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#preloader').show();
        $.ajax({
          url: `${baseUrl}shops/shops/deleteShopById/${id}`,
          type: 'GET',
          dataType: 'JSON',
          success: function(result) {
            if (result.responseCode === 200) {
              $('#preloader').hide();
              swal({
                icon: "success",
                title: "Toko Berhasil Dihapus",
                button: false,
              });
              loadListShop();
              loadTable();
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

function editShop(id){
    $.ajax({
      url: `${baseUrl}shops/Shops/getShopById/${id}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(result) {
        const data = result.data;
        $('#id-shop').val(`${id}`);
        $('#div-name').addClass('is-filled');
        $('#name').val(`${data.name}`);
        $('#div-location').addClass('is-filled');
        $('#location').val(`${data.location}`);
        $('#conditionModal').html('Update Toko');
        $('#modalInsertShop').modal('show');
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
};

function resetForm() {
    $('#div-name').removeClass('is-filled');
    $('#div-location').removeClass('is-filled');
    $('#name').val('');
    $('#location').val('');
    $('#id-shop').val('');
};

$('#btn-show-modal-add-shop').click(function() {
    resetForm();
    $('#conditionModal').html('Daftar Toko Baru');
    $('#modalInsertShop').modal('show');
});
  
const messageValidation = (field, message = '') => {
    $(field).html('');
    $(field).append(message);
};
  
$('#btnSave').click(function(e) {
    e.preventDefault();
      $('#preloader').show();
      $.ajax({
        url: `${baseUrl}shops/Shops/addOrEditShop`,
        type: 'POST',
        dataType: 'JSON',
        data: $('#formAddShop').serialize(),
        success: function(result){
          $('#preloader').hide();
          if(result.responseCode === 200) {
            loadListShop();
            loadTable();
            $('#modalInsertShop').modal('hide');
            swal({
              icon: "success",
              title: "Toko Baru Berhasil Ditambahkan",
              button: false,
            });
          } else if(result.responseCode === 400){
            messageValidation('#form-error-name', result["data"]['errorName']);
            messageValidation('#form-error-location', result["data"]['errorLocation']);
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
});
