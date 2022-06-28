<div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
  <div class="card card-plain">
    <div class="card-header">
      <h4 class="font-weight-bolder">Daftar</h4>
      <p class="mb-0">Selamat Datang</p>
      <p class="mb-0">Daftarkan Username Dan Email Sebagai Admin</p>
    </div>
    <div class="card-body">
      <form id="formRegister">
        <div class="input-group input-group-outline mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="name" class="form-control" autocomplete="off">
        </div>
        <div class="message-error" id="form-error-name"></div>
        <div class="input-group input-group-outline mb-3">
          <label class="form-label">Username</label>
          <input type="text" id="username" name="username" class="form-control" autocomplete="off">
        </div>
        <div class="message-error" id="form-error-username"></div>
        <div class="input-group input-group-outline mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" autocomplete="off">
        </div>
        <div class="message-error" id="form-error-email"></div>
        <div class="input-group input-group-outline mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" autocomplete="off">
        </div>
        <div class="message-error" id="form-error-password"></div>
        <div class="input-group input-group-outline mb-3">
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

<script>
  const messageValidation = (field, message = '') => {
    $(field).html('');
    $(field).append(message);
  };

  $('#btnRegister').click(function(e) {
    messageValidation('#form-error-name');
    messageValidation('#form-error-username');
    messageValidation('#form-error-email');
    messageValidation('#form-error-password');
    messageValidation('#form-error-re-password');

    const username = $('#username').val().trim();
    const regexWhiteSpace = /\s/g; //regex for white space
    if (username.match(regexWhiteSpace)) {
      messageValidation('#form-error-username', '<p>username is not spasi</p>');
      return false
    };
    $('#username').val(username);
    
    e.preventDefault();
    $.ajax({
      url: `<?=base_url()?>users/Register/register`,
      type: 'POST',
      dataType: 'JSON',
      data: $('#formRegister').serialize(),
      success: function(result){
        if(result.responseCode === 200) {
          swal({
            icon: "success",
            title: "Berhasil Didaftarkan",
            text: "Silahkan Login",
            button: "Login",
          })
          .then(() => {
            window.location= `<?=base_url()?>users/authentication`;
          });
        } else if(result.responseCode === 400){
          messageValidation('#form-error-name', result["data"]['errorName']);
          messageValidation('#form-error-username', result["data"]['errorUsername']);
          messageValidation('#form-error-email', result["data"]['errorEmail']);
          messageValidation('#form-error-password', result["data"]['errorPassword']);
          messageValidation('#form-error-re-password', result["data"]['errorRePassword']);
        }
      }
    })
  });

</script>