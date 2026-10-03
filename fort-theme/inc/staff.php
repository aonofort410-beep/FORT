<?php
/**
 * スタッフ（STAFF）の表示用ヘルパー
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** 部門：キー => [英字, 日本語] */
function fort_staff_depts() {
	return array(
		'sales'        => array( 'SALES', '営業' ),
		'design'       => array( 'DESIGN', '設計' ),
		'construction' => array( 'ENGINEERING', '工務' ),
		'admin'        => array( 'ADMIN', '総務' ),
	);
}

/** スタッフ1人分の表示データ */
function fort_staff_data( $p ) {
	$depts = fort_staff_depts();
	$dept  = get_post_meta( $p->ID, 'fort_dept', true );
	$en    = get_post_meta( $p->ID, 'fort_name_en', true );
	$cred  = get_post_meta( $p->ID, 'fort_cred', true );
	$ini   = '';
	foreach ( preg_split( '/\s+/', trim( $en ) ) as $w ) $ini .= $w ? strtoupper( $w[0] ) : '';
	return array(
		'id'    => $p->ID,
		'name'  => get_the_title( $p ),
		'en'    => $en,
		'ini'   => $ini,
		'dept'  => isset( $depts[ $dept ] ) ? $dept : '',
		'dept_en' => isset( $depts[ $dept ] ) ? $depts[ $dept ][0] : '',
		'role'  => get_post_meta( $p->ID, 'fort_role', true ),
		'cred'  => ( $cred && '—' !== $cred ) ? $cred : '',
		'photo' => has_post_thumbnail( $p ) ? get_the_post_thumbnail_url( $p, 'large' ) : ( file_exists( get_template_directory() . '/assets/images/staff/' . $p->post_name . '.jpg' ) ? get_template_directory_uri() . '/assets/images/staff/' . $p->post_name . '.jpg' : '' ),
		'msg'   => trim( wp_strip_all_tags( get_post_field( 'post_content', $p ) ) ),
		'url'   => get_permalink( $p ),
	);
}
