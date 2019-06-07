$(document).ready(function(){  
      var urlParams = new URLSearchParams(location.search);
      var user_id = urlParams.get('user_id');
      load_data();  
      function load_data(page)  
      {  
           $.ajax({  
                url: "/website_front/common_files/rma_history_pagination.php",  
                method: "POST",  
                data: {page: page, user: user_id},  
                success: function(data){  
                     $('#pagination_data').html(data);  
                }  
           })  
      }  
      $(document).on('click', '.pagination_link', function(){  
           var page = $(this).attr("id");  
           load_data(page);  
      });  
 }); 