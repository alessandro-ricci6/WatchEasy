function openPopup() {
    document.getElementById("searchPopup").hidden = false;
}

function closePopup() {
  document.getElementById("searchPopup").hidden = true;
}

document.getElementById("searchUser").addEventListener("click", openPopup);
document.getElementById("searchUser").addEventListener("blur", closePopup);

function searchUser() {
  $('#searchUser').on('keyup', function() {
    console.log("a");
    let query = $(this).val();
    if(query != '') {
      $.ajax({
        url: "template/searchUser.php",
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