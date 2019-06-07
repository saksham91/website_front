$(document).ready(function(){  
      var urlParams = new URLSearchParams(location.search);
      var from = urlParams.get('d1');
      var to = urlParams.get('d2');
      load_data();  
      function load_data(page)  
      {  
           $.ajax({  
                url: "view_rmalist_pagination.php",  
                method: "POST",  
                data: {date_1: from, date_2: to, page: page},  
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