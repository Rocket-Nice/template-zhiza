<?php
	if(isset($_COOKIE['golden_fund_shown'])) {
		$cookie = 1;
	}

	else {
		setcookie('golden_fund_shown', '1',(time()+60*60*24*365),'/');
		$cookie = 0;
	}
?>

<?php get_template_part('new/header');?>

<div class="feed asd">
	<div class="container">


			<?php

				if ($cookie != 1) {
					?>
					<div class="row">
					<?php
					get_template_part('new/golden');
					?>
					</div>
					<?php
				}
			?>


			<?php
				foreach(get_option('home_selections') as $key => $selection) {
					if ($key == '2') {
			 			 get_template_part('new/forms/banner');
					}
					echo get_selection_view($selection);
				}
			?>

			<div class="row" id="loadHomeHere"></div>
			<div class="row"><a href="javascript:void(0)" class="feed__button" id="loadHomeMore">Загрузить ещё</a></div>


			<?php get_template_part('new/banner');?>



			<?php
				if($cookie == 1) {
					?>
					<div class="row">
					<?php
					get_template_part('new/golden');
					?>
					</div>
					<?php
				}
			?>



		</div>
	</div>
</div>

<?php get_template_part('new/footer');?>
