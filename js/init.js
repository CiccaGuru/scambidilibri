$( document ).ready(function(){
	
	    $(".button-collapse").sideNav();
	});

$("#ricerca").on("submit" ,function(e) {
	e.preventDefault();
    var url = "richiediLibroAux.php"; // the script where you handle the form input.

		var title = $("#title").val();
		var author = $("#author").val();
		var isbn= $("#isbn").val();
		var casa = $("#ricerca #casa").val();
		var year = $("#year").val();
		var maxPrezzo= $("#maxPrezzo").val();
		var nRisultati = $("#nRisultati").val();
		var conservazione = $("input[name=conservazione]:checked", '#ricerca').val();
    $.ajax({
           type: "POST",
           url: url,
           data: {
			   "title": title,
			   "author": author,
			   "isbn": isbn,
			   "casa": casa,
			   "year": year,
			   "maxPrezzo": maxPrezzo,
			   "nRisultati":nRisultati,
			   "conservazione": conservazione,
			   "search": 0
			   }, // serializes the form's elements.
           success: function(data)
           {
			   Materialize.toast('Ricerca eseguita con successo!', 4000);
               $("#result").html(data); // show response from the php script.
			   $('html, body').animate({
					scrollTop: $("#result").offset().top
				}, 1000);
           }
         });
         

    return false; // avoid to execute the actual submit of the form.
});
