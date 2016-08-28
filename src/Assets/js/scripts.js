$(document).ready(function(){
  if ($(window).width() > 992) {
  	console.log('Bezerrão Cuqueteiro');
  	$('.aside').prepend($('.novidades .novidade-lista'));
  	$('.novidades .novidade-lista').prepend('<li class="list-news-iten"><h3>Novidades</h3></li>');
  }

  $('#primeiraVisita').modal('show');

  $("#contTelas").owlCarousel({
      //navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      touchDrag:false
  });
  $('.link-continuar').click(function(){
    $('#contTelas').trigger('owl.next');
  });
  $('.link-voltar').click(function(){
    $('#contTelas').trigger('owl.prev');
  })

  $('.link-iniciar-lista').click(function(event) {
	$('#primeiraVisita').modal('hide');
  });

  //modal do Produto
	$('.produto-container .img-do-produto').owlCarousel({
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
  	});

	$('.produto-container .owl-prev, .produto-container .owl-next').addClass('btn').addClass('btn-default');

	$('.opnUsuario').click(function(event) {
		$('.minha-opiniao').removeClass('showOP');
		$('.opiniao-users-texts').toggleClass('showOP');
	});

	$('.postarOpiniao').click(function(event) {
		$('.opiniao-users-texts').removeClass('showOP');
		$('.minha-opiniao').toggleClass('showOP');to
	});




  //Sequencia de compartilhamento
  $("#contTelas2").owlCarousel({
      //navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      touchDrag:false
  });
  $('.link-continuar2').click(function(){
    $('#contTelas2').trigger('owl.next');
  });
  $('.link-voltar2').click(function(){
    $('#contTelas2').trigger('owl.prev');
  })

  $('.link-iniciar-lista2').click(function(event) {
  $('#compartilhandoThis').modal('hide');
  });
  	
 
});