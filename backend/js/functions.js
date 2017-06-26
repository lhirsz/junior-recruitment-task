/**
 * Funkcja czyszcząca pole gdzie wpisujemy nowe zadanie.
 */

function clear_input()
{
	$('input#addrow').val("");
	
}

/**
 * Funkcja zmieniająca status na bazie w zależności od tego czy checkbox został kliknięty.
 */
function chceck(id)
		{
		var checkbox = $(id);
		var checkbox = event.target;
			
			if (checkbox.checked) 
			{
				var status = "1";
			} 
			else 
			{
				var status = "0";
			}
			
			 $.ajax({
			post: "get",
			url: "../backend/php/ajax.php",
			data: {editrow: true,id: id , status: status  },
			dataType: "html",
			success: function(data){
             $('#tasks').html(data);
			} 
			});
			 
			 
				
		}


/**
 * Funkcja wywoływana podczas ładowania strony
 */
function onload()
		{
		$.ajax({
			post: "get",
			url: "../backend/php/ajax.php",
			data: {onload: true },
			dataType: "html",
			success: function(data){
             $('#tasks').html(data);
			} 
			});
		}
/**
 * Funkcja przekazująca id do usunięcia z bazy.
 */		
function delete_row(del_id)
		{ 	
            $.ajax({
                type:'GET',
                url:'../backend/php/ajax.php',
                data:{deleterow: true ,id: del_id},
                success: function(data){
                    $('#tasks').html(data);
                        }
                })
            
		}
/**
 * Funkcja przekazująca dane do dodania nowego zadania.
 */	
function add_row()
		{
		var add = $('#addrow').val()
		if(add==""){
		 alert('Pole nie może być puste')
		 }
		 else{
		 add = add.replace(/<\/?[^>]+(>|$)/g, "");
		 $.ajax({
		 post: "get",
		 url: "../backend/php/ajax.php",
		 data:{addrow : true, text: add},
		 dataType: "html",
		 success: function(data){
             $('#tasks').html(data),clear_input();
          } 
		 
		 });
		 }
	
		}
