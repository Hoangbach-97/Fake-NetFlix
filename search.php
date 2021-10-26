<?php 
include_once('includes/header.php');
?>

<div class="textboxContainer">
    <input type="text" class="searchInput" placeholder="Search..." >
</div>
<div class="results">

</div>

<script type="text/javascript">
$(function(){
  var username = '<?=$userLogin ?>';
  var timer;
  
  $(".searchInput").keyup(function(){
      clearTimeout(timer);
      timer = setTimeout(function(){
          var val = $(".searchInput").val();
          if(val != ""){
            $.post("ajax/getSearchResult.php", {term:val, username:username}, function(data){
             $(".results").html(data); 

            })
          }
          else{
             $(".results").html(""); 
          }
      }, 500);
  })
});
</script>