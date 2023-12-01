$(document).ready(function() {
    $('#tickButton').change(function() {
      if ($(this).is(':checked')) {
        $.ajax({
          url: 'admin/home.php',
          type: 'GET',
          data: { enableMembership: true },
          success: function(response) {
            // Button enabled, update the UI if needed
            $('#membershipButton').show();
          }
        });
      } else {
        // Button disabled, update the UI if needed
        $('#membershipButton').hide();
      }
    });
  });