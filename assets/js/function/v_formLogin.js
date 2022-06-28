const baseUrl = 'http://whoami.co.id/pdms/';
const messageValidation = (field, message = '') => {
    $(field).html('');
    $(field).append(message);
};

$('#btnLogin').click(function(e){
    messageValidation('#form-error-user');
    messageValidation('#form-error-password');

    const user = $('#user').val().trim();
    const regexWhiteSpace = /\s/g; //regex for white space
    if (user.match(regexWhiteSpace)) {
      messageValidation('#form-error-user', '<p>Tidak boleh menggunakan spasi</p>');
      return false
    };
    $('#user').val(user);

    e.preventDefault();
    $.ajax({
      url: `${baseUrl}Authentication/authentication`,
      type: 'POST',
      dataType: 'JSON',
      data: $('#formLogin').serialize(),
      success: function(result){
        if(result.responseCode === 200) {
          swal({
            icon: "success",
            title: "Berhasil Login",
            button: "Go To Dashboard",
          })
          .then(() => {
            window.location= `${baseUrl}dashboard`;
          });
        } else if(result.responseCode === 400){
          messageValidation('#form-error-user', result['data']['errorUser']);
          messageValidation('#form-error-password', result['data']['errorPassword']);
        } else {
          swal({
            icon: "warning",
            title: "Failed Login",
            text: result.responseMessage,
            button: false
          });
        }
      }
    });
});