$(function() {
  $('#registerForm').on('submit', function(e) {
    e.preventDefault();
    // Simple client-side validation
    const name = $('#name').val().trim();
    const email = $('#email').val().trim();
    const password = $('#password').val();
    const age = $('#age').val().trim();
    const dob = $('#dob').val().trim();
    const contact = $('#contact').val().trim();
    let errorMsg = '';
    if (!name) errorMsg = 'Name is required.';
    else if (!email || !/^\S+@\S+\.\S+$/.test(email)) errorMsg = 'Valid email is required.';
    else if (!password || password.length < 6) errorMsg = 'Password must be at least 6 characters.';
    else if (!age || isNaN(age) || age < 1) errorMsg = 'Valid age is required.';
    else if (!dob) errorMsg = 'Date of birth is required.';
    else if (!contact || contact.length < 10) errorMsg = 'Valid contact is required.';
    if (errorMsg) {
      $('#registerMsg').css('color', 'red').text(errorMsg);
      return;
    }
    $.ajax({
      url: 'php/register.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        name,
        email,
        password,
        age,
        dob,
        contact
      }),
      success: function(res) {
        if (res.success) {
          $('#registerMsg').css('color', 'green').text('Registration successful! Please login.');
          $('#registerForm')[0].reset();
        } else {
          $('#registerMsg').css('color', 'red').text(res.error || 'Registration failed.');
        }
      },
      error: function() {
        $('#registerMsg').css('color', 'red').text('Server error.');
      }
    });
  });
});
