$(function() {
  $('#loginForm').on('submit', function(e) {
    e.preventDefault();
    const email = $('#email').val().trim();
    const password = $('#password').val();
    let errorMsg = '';
    if (!email || !/^\S+@\S+\.\S+$/.test(email)) errorMsg = 'Valid email is required.';
    else if (!password || password.length < 6) errorMsg = 'Password must be at least 6 characters.';
    if (errorMsg) {
      $('#loginMsg').css('color', 'red').text(errorMsg);
      return;
    }
    $.ajax({
      url: 'php/login.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        email,
        password
      }),
      success: function(res) {
        if (res.success && res.token) {
          localStorage.setItem('token', res.token);
          window.location.href = 'profile.html';
        } else {
          $('#loginMsg').css('color', 'red').text(res.error || 'Login failed.');
        }
      },
      error: function() {
        $('#loginMsg').css('color', 'red').text('Server error.');
      }
    });
  });
});
