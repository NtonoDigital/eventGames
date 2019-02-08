<?php
$id = $table_id;
$table = new SP_League_Table( $id );
$data = $table->data();
$output = '';
foreach ( $data as $team_id => $row ){
    $output .= '<dl class="gallery-item"><dt class="gallery-icon portrait">';
    $permalink = get_permalink((int)$team_id);
    $name = get_the_title((int)$team_id);
    if(has_post_thumbnail((int)$team_id)){
        $output .= '<a href="'.$permalink.'" title="'.$name.'">'.get_the_post_thumbnail((int)$team_id, 'sportspress-fit-medium').'</a>';
    }
    $output .= '</dt>';
    $output .= '<a href="'.$permalink.'" title="'.$name.'"><dd class="wp-caption-text gallery-caption small-3 columns">'.$name.'</dd></a>';
    $output .= '</dl>';
}

?>
<div class="gallery gallery-columns-6 gallery-size-sportspress-crop-medium">
    <div class="sp-template sp-template-team-gallery sp-template-gallery">
        <div class="sp-team-gallery-wrapper sp-gallery-wrapper">
            <?php echo $output?>
        </div>
    </div>
</div>
