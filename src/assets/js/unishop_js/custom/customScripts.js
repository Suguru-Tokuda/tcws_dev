$(function() {
  $("#file").change(function() {
    var reader = new FileReader();
    reader.onload = function(image) {
      $('.imageUploadedOrNot').show(0);
      $('#blankImg').attr('src', image.target.result);
    }
    reader.readAsDataURL(this.files[0]); // this refers to $('#file')
  });
});

$(document).ready(function() {
  $( "#sortlist" ).sortable({ // looks for the ID called "sortlist"
    stop: function(event, ui) {saveChanges();} // saveChanges() fires up when sorting happens.
  });
  $( "#sortlist" ).disableSelection();
});

function saveChanges() {
  var $num = $('#sortlist > li').size();
  $dataString = "number=" +$num;
  for($x=1;$x<=$num;$x++)
  {
    var $catid = $('#sortlist li:nth-child('+$x+') ').attr('id');
    $dataString = $dataString + "&order"+$x+"="+$catid;
  }           $.ajax({
    type: "POST",
    url: "<?php echo $start_of_target_url.$first_bit; ?>/sort",
    data: $dataString
  });
  return false;
}
