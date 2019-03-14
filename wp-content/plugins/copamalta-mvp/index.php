<?php
		/*
		Plugin Name: MVP - Copa Malta Morena 
		Description: Display a list of MVP players
		Author: Raylin Aquino
		Author URI: http://raylinaquino.com
		Version: 1.0
		*/

		class CopaMaltaMVP extends WP_Widget { 
			function __construct() {
				global $post;
				parent::__construct(false,$name = __("MVP - Copa Malta Morena"), false, false);

				wp_enqueue_script('jquery');  

				wp_enqueue_style('copamalta-mvp-swiper-css', plugin_dir_url( __FILE__ ) . '/css/swiper.min.css');
				wp_enqueue_style('copamalta-mvp-style', plugin_dir_url( __FILE__ ) . '/css/style.css');

				wp_enqueue_script('copamalta-mvp-swiper-js', plugin_dir_url( __FILE__ ) . '/js/swiper.min.js', '', '', true);
				wp_enqueue_script('copamalta-mvp-main-js', plugin_dir_url( __FILE__ ) . '/js/main.js', '', '', true); 
				

			}

			/* Main function logic for doing the MVP seek*/
			function getMVP(){
				global $post;
				$current_team = $post->ID;

				/* getting MVP by event*/

				$args = array(
					'post_type'=>'sp_event',
					'posts_per_page' => -1,
					'meta_query' => array(
						array(
							'key' => 'sp_team',
							'value' => $current_team,
							'compare' => 'IN',
						)
					)
				);

				$events = new WP_Query($args);

				if($events->have_posts()){
					$players_mvp = [];
					$players_mvp_metas = [];


					while($events->have_posts()): $events->the_post();
						$event = get_the_ID();


						$players_starts = maybe_unserialize( get_post_meta(  $event )['sp_stars'][0] );
						$players_stats = maybe_unserialize( get_post_meta(  $event )['sp_players'][0])[$current_team];


						if(is_array($players_stats) and count($players_stats) > 0){
							foreach($players_stats as $k => $d){

								if($players_starts[$k] == 1){
									$players_mvp[$k] += 1; 
									$players_mvp_metas[$k]['goals'] += (int) $d['goals'];
									$players_mvp_metas[$k]['assists'] += (int) $d['assists'];

								}
							}
						}

					endwhile;
					wp_reset_postdata($events);

				}
				//return array($players_mvp, $players_mvp_metas);
				if(count($players_mvp) == 0){
					return false;
				} 
				return $this->get_players($players_mvp, $players_mvp_metas);

			}

			function get_players($players_mvp, $players_mvp_metas){
				/* Get players */

				$players = [];
				foreach($players_mvp as $k => $d){
					$players[] = $k;
				}

				$args = array(
					'post_type' => 'sp_player',
					'post__in' => $players, 
					'posts_per_page' => -1
				);

				$players_query = new WP_Query($args);
				$players_data = [];

				if($players_query->have_posts()){
					while ($players_query->have_posts()) {
						$players_query->the_post();
						$player_id = get_the_id();

						$players_data[] = array(
							'id' => $player_id,
							'title' => get_the_title(),
							'positions' => get_the_terms($player_id,'sp_position')[0]->name ,
							'image' => get_the_post_thumbnail_url($player_id, 'thumbnail'),
							'mvp_metas' => $players_mvp_metas[$player_id],
							'vmp_total' => $players_mvp[$player_id],

						);


					}
					wp_reset_postdata($players_query);	
				}

				return $players_data;
			}

			function widget( $args, $instance ) {
				
				extract( $args, EXTR_SKIP );

				global $wp_query;


				$titulo = (empty($instance["titulo"])) ? 'JUGADORES MVP DEL EQUIPO': $instance["titulo"]; 
				
				/* Get MVP players by Team */
				$mvp_data = $this->getMVP()


				?>
				
				<!-- ▼▼▼ Copa Malta MVP ▼▼▼ -->				
				<div class="w-col w-col-4 copamalta-mvp">
					
					<header class="card__header">						
						<h4 class="sp-table-caption"><?php echo $titulo ?></h4>
						<?php if($mvp_data !== false): ?>
							<div class="total">Total MVP: <strong><?php echo count($mvp_data); ?></strong></div>
						<?php endif; ?>
					</header>
					<?php if($mvp_data === false): ?>
						<div class="alert"><?php _e('No se han encontrado jugadores MVP para este equipo.') ?></div>
						<?php else: ?>
							<div class="list-players">
								<div class="swiper-container"> 
									<div class="swiper-wrapper">
										<?php foreach($mvp_data as $data): ?>
											<div class="swiper-slide">
												<aside class="card-player">
													<div class="card-player-head"><?php echo $data['positions'] ?> <div class="star-wrap"><i class="fa fa-star"></i></div></div>
													<div class="card-player-content">
														<div class="card-player-img" style="background-image:url('<?php echo $data['image'] ?>')"></div>
														<div class="card-player-desc">
															<div class="name"><?php echo $data['title'] ?></div>
															<ul class="player-metas">
																<li>
																	Goles: <strong><?php echo $data['mvp_metas']['goals'] ?></strong>
																</li>
																<li>
																	Asistencia: <strong><?php echo $data['mvp_metas']['assists'] ?></strong>
																</li>
																<li>
																	Menciones MVP: <strong class="mvp-num"><?php echo $data['vmp_total']?></strong>
																</li>

															</ul>
														</div>

													</div>
												</aside>
											</div>
											<!-- end Slide -->
										<?php endforeach; ?>
									</div> 

									<div class="swiper-pagination"></div>

								</div>
							</div>
						<?php endif; ?>
					</div>
					<!--▲▲▲ end Copa Malta MVP  ▲▲▲-->

					<?php
					wp_reset_query();
				}

				function update($new_instance, $old_instance) {
					$instance = $old_instance; 
					$instance["titulo"] = $new_instance["titulo"]; 

					return $instance;
				}


				function form( $instance ) { 
					$titulo = sanitize_text_field($instance['titulo']);

					?>
					<p>
						<label><?php _e('Título'); ?><br>
							<input class="widefat" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo $titulo; ?>" />
						</label>
					</p>
					<?php
				}
			}

			add_action( 'widgets_init', function(){	register_widget( 'CopaMaltaMVP' ); });
			add_action( 'widgets_init', 'copamalta_mvp' );

			function copamalta_mvp() {
				register_sidebar( array(
					'name' => __( 'MVP Sidebar'  ),
					'id' => 'mvp-sidebar'

				) );
			}
			?>