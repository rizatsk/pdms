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
    if (roleId === '777') {
      $('#divEditUser').append(`
          <a href="javascript:modalEditCeo('${userId}');">
            <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
          </a>
      `);
    } 
});

function modalEditCeo(id){
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}users/users/getDataUserById/${id}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          const data = result.data;
          $('#fullname').val(`${data.fullname}`);
          $('#email').val(`${data.email}`);
          $('#companyName').val(`${data.company_name}`);
          $('#modalEditCeo').modal('show');
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

const messageValidation = (field, message = '') => {
  $(field).html('');
  $(field).append(message);
};

$('#btnSaveProfile').click(function(e) {
    e.preventDefault();
    $('#preloader').show();
    $.ajax({
      url: `${baseUrl}users/users/updateProfileCeo`,
      type: 'POST',
      dataType: 'JSON',
      data: $('#formEditCeo').serialize(),
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          $('#formEditCeo').trigger("reset");
          $('#modalEditCeo').modal('hide');

          $('#headerFullname').html(`${result.data.fullname}`);
          $('#liFullname').html(`${result.data.fullname}`);

          swal({
            icon: "success",
            title: "Berhasil DiUpdate",
            text: "Data Berhasil Di Update",
            button: false,
          });
        } else if (result.responseCode === 400) {
          messageValidation('#form-error-fullname', result["data"]['errorFullname']);
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

$('#btnChangePassword').click(function(e) {
    e.preventDefault();
    $('#preloader').show();
    $.ajax({
      url : `${baseUrl}users/users/changePasswordCeo`,
      dataType: 'JSON',
      type: 'POST',
      data: $('#formEditCeo').serialize(),
      success: function(result) {
        $('#preloader').hide();
        if (result.responseCode === 200) {
          swal({
            icon: "success",
            title: "Suksess",
            text: `Berhasil mengganti password silahkan logout`,
            button: 'logout',
          }).then(() => {
            location.href = `${baseUrl}authentication/logout`;
          })
        } else if (result.responseCode === 400) {
          messageValidation('#form-error-passwordNew', result['data']['errorPasswordNew']);
          messageValidation('#form-error-prePasswordNew', result['data']['errorPrePasswordNew']);
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
