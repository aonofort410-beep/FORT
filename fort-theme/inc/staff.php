<?php
/**
 * スタッフ（STAFF）の表示用ヘルパー
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** 部門：キー => [英字, 日本語] */
function fort_staff_depts() {
	return array(
		'sales'        => array( 'SALES', '営業' ),
		'design'       => array( 'DESIGN', '設計コーディネート' ),
		'construction' => array( 'CONSTRUCTION', '工務' ),
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
		'dept_ja' => isset( $depts[ $dept ] ) ? $depts[ $dept ][1] : '',
		// 肩書きは「店長」など部門名以外があるときだけ表示（○○コーディネーター・部門名は出さない）
		'role'  => fort_staff_role( get_post_meta( $p->ID, 'fort_role', true ), isset( $depts[ $dept ] ) ? $depts[ $dept ][1] : '' ),
		'cred'  => ( $cred && '—' !== $cred ) ? $cred : '',
		'photo' => has_post_thumbnail( $p ) ? get_the_post_thumbnail_url( $p, 'large' ) : ( file_exists( get_template_directory() . '/assets/images/staff/' . $p->post_name . '.jpg' ) ? get_template_directory_uri() . '/assets/images/staff/' . $p->post_name . '.jpg' : '' ),
		'msg'   => trim( wp_strip_all_tags( get_post_field( 'post_content', $p ) ) ),
		'url'   => get_permalink( $p ),
	);
}

/** 肩書きから「○○コーディネーター」と部門名の重複を取り除く */
function fort_staff_role( $role, $dept_ja ) {
	$parts = array_filter( array_map( 'trim', preg_split( '/[／\/]/u', (string) $role ) ) );
	$parts = array_filter( $parts, function ( $r ) use ( $dept_ja ) {
		foreach ( fort_staff_depts() as $d ) if ( $r === $d[1] || false !== mb_strpos( $d[1], $r ) ) return false; // 部門名は除く
		return false === mb_strpos( $r, 'コーディネーター' );
	} );
	return implode( ' ／ ', $parts );
}

/** 一覧の並び：営業 → 設計コーディネート → 工務 → 総務（部門内は管理画面の順番 → 登録順） */
function fort_staff_sort( $list ) {
	$order = array_flip( array_keys( fort_staff_depts() ) );
	$i = 0;
	foreach ( $list as &$s ) $s['_i'] = $i++;
	unset( $s );
	usort( $list, function ( $a, $b ) use ( $order ) {
		$da = $order[ $a['dept'] ] ?? 99;
		$db = $order[ $b['dept'] ] ?? 99;
		return $da === $db ? $a['_i'] - $b['_i'] : $da - $db;
	} );
	return $list;
}
