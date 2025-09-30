function getToken() {
  return localStorage.getItem('token');
}

function loadProfile() {
  $.ajax({
    url: 'php/profile.php',
    method: 'GET',
    headers: { 'Authorization': 'Bearer ' + getToken() },
    success: function(res) {
      if (res.success) {
        $('#name').val(res.user.name);
        $('#email').val(res.user.email);
        $('#age').val(res.user.age);
        $('#dob').val(res.user.dob);
        $('#contact').val(res.user.contact);
      } else {
        window.location.href = 'login.html';
      }
    },
    error: function() {
      window.location.href = 'login.html';
    }
  });
}

$(function() {
  loadProfile();

  $('#profileForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'php/profile.php',
      method: 'POST',
      contentType: 'application/json',
      headers: { 'Authorization': 'Bearer ' + getToken() },
      data: JSON.stringify({ name: $('#name').val() }),
      success: function(res) {
        if (res.success) {
          $('#profileMsg').css('color', 'green').text('Profile updated successfully!');
        } else {
          $('#profileMsg').css('color', 'red').text(res.error || 'Update failed.');
        }
      },
      error: function() {
        $('#profileMsg').css('color', 'red').text('Server error.');
      }
    });
  });

  $('#logoutBtn').on('click', function() {
    localStorage.removeItem('token');
    window.location.href = 'login.html';
  });
});
