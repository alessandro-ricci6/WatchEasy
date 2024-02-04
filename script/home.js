function searchUser() {
  $('#searchUser').on('keyup', function() {
    console.log("a");
    let query = $(this).val();
    if(query != '') {
      $.ajax({
        url: "searchUser.php",
        method: "POST",
        data: {query: query},
        success: function(data) {
          $('#searchPopup').html(data);
        }
      });
    } else {
      $('#searchPopup').html('');
    }
  })
}

$(document).ready(searchUser);