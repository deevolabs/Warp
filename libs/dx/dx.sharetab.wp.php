<div class="share-tab">



	<div class="share-label">Compartilhe!</div>



	<div class="container">

		

		<div class="share-buttons">

			<a href="#" class="button-share facebook" data-title="<?php the_title();?>" data-summary="<?php the_excerpt();?>" data-url="<?php the_permalink();?>" data-image="<?=$thumb[0]?>">

				<span class="icon-facebook"></span>

				<span class="text">Facebook</span>

			</a>

			<a href="#" class="button-share twitter">

				<span class="icon-twitter"></span>

				<span class="text">Twitter</span>

			</a>

			<a href="#" class="button-share googleplus none">

				<span class="icon-googleplus"></span>

				<span class="text">Google Plus</span>

			</a>

			

			<a href="#" class="button-share linkedin">

				<span class="icon-linkedin"></span>

				<span class="text">LinkedIn</span>

			</a>



			

			<a href="#" class="button-share pinterest">

				<span class="icon-pinterest"></span>							

				<span class="text">Pinterest</span>

			</a>



			<a href="#" class="button-share mail">

				<span class="icon-mail"></span>

			</a>				

		</div>

		<div class="bloco-share-mail">
			<input type="hidden" name="titulo-share-mail" class="titulo-share-mail" value="<?=the_title()?>">
			<div class="name-field">
				<!--<input class="nome-share-mail"  type="text" placeholder="Seu nome"> -->
			</div>
			<div class="name-field">
				<!--<input class="nome-friend-share-mail"  type="text" placeholder="Nome do amigo"> -->
			</div>
			<div class="email-field">
				<input class="email-friend-share-mail" type="email" placeholder="Email do amigo">
				<input type="submit"  class="btn-enviar-share" value="Enviar">
			</div>
			<div class="result-message">
				<div class="success"> E-mail enviado! </div>
				<div class="error"> Ocorreu um erro, tente novamente. </div>
			</div>	
		</div>
	</div>

</div>

