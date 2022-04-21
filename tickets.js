$(document).on('click','#showData',function(e){
  $.ajax({    
    type: "GET",
    url: "tickets.php",             
    dataType: "html",                  
    success: function(data){                    
        $("#table-container").html(data); 
       
    }
});
});