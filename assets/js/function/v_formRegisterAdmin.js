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
});

const loadTable = () => {
    $('tbody').append(`
      <tr>
        <td colspan="6" style="padding: 40px 0;">
          <div class="d-flex justify-content-center">
            <div class="spinner-border text-danger" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </td>
      </tr>`);

    $.ajax({
      url: `${baseUrl}users/Register_admin/loadTable/${companyId}`,
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
                    <h6 class="mb-0 text-sm">${data.fullname}</h6>
                    <p class="text-xs text-secondary mb-0">${data.id}</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0">${data.username}</p>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0">${data.email}</p>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0" style="text-transform: capitalize;">${data.role_id == 777 ? 'CEO' : data.case}</p>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">${data.created_at}</span>
              </td>
              ${data.role_id == 777 ? '' : `
              <td class="align-middle">
                <a href="javascript:editAdmin('${data.id}')" id="btnShowModalEdit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Admin" title="Edit Admin">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1C6DD0" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                  </svg> 
                </a>
                <span style="padding: 0 10px;"> | </span>
                <a href="javascript:deleteAdmin('${data.id}');" id="btnDelete" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete Admin" title="Delete Admin">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e91e63" class="bi bi-x-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                  </svg>
                </a>
              </td>
              `}
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

$('#btn-show-modal-add-admin').click(function() {
    resetForm();
    $('#id-admin').val('');
    $('#conditionModal').html('Daftar Toko Baru');
    $('#modalInsertAdmin').modal('show');
    loadComboAdminToko(companyId, '#adminToko');
}); 

function resetForm() {
    $('#div-name').removeClass('is-filled');
    $('#div-username').removeClass('is-filled');
    $('#div-email').removeClass('is-filled');
    $('#div-passwordOwner').removeClass('is-filled');
    $('#div-password').removeClass('is-filled');
    $('#div-confirmPassword').removeClass('is-filled');
    $('#div-changePassword').removeClass('is-filled');
    $('#div-changeConfirmPassword').removeClass('is-filled');

    messageValidation('#form-error-name');
    messageValidation('#form-error-username');
    messageValidation('#form-error-email');
    // messageValidation('#form-error-adminToko');
    messageValidation('#form-error-password');
    messageValidation('#form-error-re-password');
};  

function loadComboAdminToko(companyId, field) {
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}users/register_admin/loadComboAdminToko/${companyId}`,
      type: 'GET',
      dataType: 'JSON',
      success: function (result) {
        $('#preloader').hide();
        $(`${field}`).html('');
        $(`${field}`).append(`<option value="" selected>-- Pilih --</option>`);
        $(`${field}`).append(`<option value="">Tidak Ada</option>`);
        const datas = result.data;
        datas.forEach((data) => {
          $(`${field}`).append(`<option value="${data.id}" style="text-transform: capitalize;">${data.name}</option>`);
        })
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

$('#btnRegister').click(function(e) {
    e.preventDefault();
    
    const username = $('#username').val().trim();
    const regexWhiteSpace = /\s/g; //regex for white space
    if (username.match(regexWhiteSpace)) {
        messageValidation('#form-error-username', '<p>username is not spasi</p>');
        return false
    };
    
    $('#preloader').show();
    $('#username').val(username);
    $.ajax({
      url: `${baseUrl}users/register_admin/register`,
      type: 'POST',
      dataType: 'JSON',
      data: $('#formRegister').serialize(),
      success: function(result){
        $('#preloader').hide();
        if(result.responseCode === 200) {
          $('#formRegister').trigger("reset");
          $('#modalInsertAdmin').modal('hide');
          loadTable();
          swal({
            icon: "success",
            title: "Berhasil Didaftarkan",
            text: "Admin Berhasil Didaftarkan",
            button: false,
          });
        } else if(result.responseCode === 400){
          messageValidation('#form-error-name', result["data"]['errorName']);
          messageValidation('#form-error-username', result["data"]['errorUsername']);
          messageValidation('#form-error-email', result["data"]['errorEmail']);
          // messageValidation('#form-error-adminToko', result["data"]['errorAdminToko']);
          messageValidation('#form-error-password', result["data"]['errorPassword']);
          messageValidation('#form-error-re-password', result["data"]['errorRePassword']);
        } else {
          swal({
            icon: "warning",
            title: "Gagal Didaftarkan",
            text: "Maximal User Admin Hanya 3.",
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
    })
});

const messageValidation = (field, message = '') => {
  $(field).html('');
  $(field).append(message);
};

function deleteAdmin(id) {
    swal({
      title: "Delete",
      text: "Anda yakin ingin menghapus admin ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#preloader').show();
        $.ajax({
          url: `${baseUrl}users/register_admin/deleteAdmin/${id}`,
          type: 'GET',
          dataType: 'JSON',
          success: function(result) {
            $('#preloader').hide();
            if (result.responseCode === 200) {
              loadTable();
              swal({
                icon: "success",
                title: "Admin Berhasil Dihapus",
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
};
    
function editAdmin(id) {
    resetForm();
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}users/users/getDataUserById/${id}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          $('#btnEditAdminShop').prop('disabled', true);

          const data = result.data;
          $('#idUser').val(`${id}`);
          $('#editName').html(`nama admin ${data.fullname}`);
          $('#editShop').html(`admin untuk ${data.case}`);

          loadComboAdminToko(companyId, '#editAdminToko');
          $('#modalEditAdmin').modal('show');
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

$('#editAdminToko').change(function() {
    $('#btnEditAdminShop').prop('disabled', false);
});

$('#btnEditAdminShop').click(function(e) {
    e.preventDefault();
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}users/register_admin/editAdminShop`,
      type: 'POST',
      dataType: 'JSON',
      data: {
        idUser: $('#idUser').val(),
        idShop: $('#editAdminToko').val(),
      },
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          $('#modalEditAdmin').modal('hide');
          loadTable();
          swal({
            icon: "success",
            title: "Success",
            text: "Berhasil Merubah Admin Toko",
            button: false,
          });
        } else {
          $('#modalEditAdmin').modal('hide');
          swal({
            icon: "warning",
            title: "Gagal",
            text: "Gagal Merubah Admin Toko",
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
    })
});

$('#btnChangePassword').click(function(e) {
    e.preventDefault();
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}users/users/changePassword`,
      type: 'POST',
      data: {
        idUser: $('#idUser').val(),
        ownerPassword: $('#ownerPassword').val(),
        passwordNew: $('#passwordNew').val(),
        rePasswordNew: $('#rePasswordNew').val(),
      },  
      dataType: 'JSON',
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          $('#modalEditAdmin').modal('hide');
          swal({
            icon: "success",
            title: "Success",
            text: "Berhasil Merubah Password",
            button: false,
          });
        } else if (result.responseCode === 400) {
          messageValidation('#form-error-ownerPassword', result["data"]['errorOwnerPassword']);
          messageValidation('#form-error-passwordNew', result["data"]['errorPasswordNew']);
          messageValidation('#form-error-rePasswordNew', result["data"]['errorRePasswordNew']);
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
