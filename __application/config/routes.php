<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "why/modul_admin";

//////////////////////////*** WHY
$route['admin-ctrlpnl'] = "why/modul_admin";
$route['loginadm'] = "login/loginadm";
$route['logoutadm'] = "login/logoutadm";

$route['pembentukan-tim-kerja'] = "why/modul_admin/getdisplay/pembentukan_tim";
$route['form-pembentukan-tim'] = "why/modul_admin/getdisplay/form_pembentukan_tim";
$route['submit-pembentukan-tim'] = "why/modul_admin/simpansavedbx/pembentukan_tim";
$route['hapus-pembentukan-tim'] = "why/modul_admin/simpansavedbx/pembentukan_tim";

$route['rencana-perumusan'] = "why/modul_admin/getdisplay/rencana_perumusan";
$route['form-rencana-perumusan'] = "why/modul_admin/getdisplay/form_rencana_perumusan";
$route['submit-rencana-perumusan'] = "why/modul_admin/simpansavedbx/rencana_perumusan";
$route['hapus-rencana-perumusan'] = "why/modul_admin/simpansavedbx/rencana_perumusan";

$route['peta-jabatan'] = "why/modul_admin/getdisplay/peta_jabatan";
$route['detail-peta-jabatan'] = "why/modul_admin/getdisplay/detail_peta_jabatan";
$route['form-detail-peta-jabatan'] = "why/modul_admin/getdisplay/form_detail_peta_jabatan";
$route['get-kode-unit-kompetensi'] = "why/modul_admin/getdisplay/get_kode_kompetensi";
$route['submit-detail-peta-jabatan'] = "why/modul_admin/simpansavedbx/detail_peta_jabatan";
$route['hapus-detail-peta-jabatan'] = "why/modul_admin/simpansavedbx/detail_peta_jabatan";


$route['datagrid-adm/(:any)'] = "why/modul_admin/getdatagrid/$1";


///////////////////////////*** LEVI

$route['datagrid/(:any)'] = "lv/modul_admin/getdatagrid/$1";

$route['kementrian-grid'] = "lv/modul_admin/getdisplay/datagridview/kementrian_grid";
$route['bidang'] = "lv/modul_admin/getdisplay/datagridview/bidang_urusan";
$route['bidang-lain'] = "lv/modul_admin/getdisplay/datagridview/bidang_lain";
$route['sub-bidang-lain'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang_lain";
$route['sub-subbidang-lain'] = "lv/modul_admin/getdisplay/sub_subbidang_lain";
$route['form-sub-subbidang-lain'] = "lv/modul_admin/getdisplay/form_sub_subbidang_lain";
$route['submit-bidang'] = "lv/modul_admin/simpansavedbx/bidang";
$route['submit-subbidang'] = "lv/modul_admin/simpansavedbx/sub_bidang";
$route['submit-bidang-lain'] = "lv/modul_admin/simpansavedbx/bidang_lain";
$route['submit-subbidang-lain'] = "lv/modul_admin/simpansavedbx/submit_subbidang_lain";
$route['submit-sub-subbidang-lain'] = "lv/modul_admin/simpansavedbx/submit_sub_subbidang_lain";
$route['kel-kompetensi'] = "lv/modul_admin/getdisplay/datagridview/kel_kompetensi";
$route['kompetensi-manajerial'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_manajerial";
$route['kompetensi-kunci'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_kunci";
$route['bakat'] = "lv/modul_admin/getdisplay/datagridview/bakat_list";
$route['list-eselon'] = "lv/modul_admin/getdisplay/datagridview/list_eselon";
$route['sub-bidang'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang";
$route['sub-subbidang'] = "lv/modul_admin/getdisplay/sub_subbidang";
$route['detil-komp-manaj'] = "lv/modul_admin/getdisplay/detil_komp_manaj";
$route['level-komp-kunci'] = "lv/modul_admin/getdisplay/level_komp_kunci";
$route['dasar-hukum'] = "lv/modul_admin/getdisplay/datagridview/dasar_hukum";

$route['pemetaan-fungsi-UK'] = "lv/modul_admin/getdisplay/datagridview/pemetaan_fungsi-UK";
$route['pemetaan-fungsi-UL'] = "lv/modul_admin/getdisplay/datagridview/pemetaan_fungsi-UL";
$route['pemetaan-fungsi-JFU'] = "lv/modul_admin/getdisplay/datagridview/pemetaan_fungsi-JFU";
$route['fishbone/(:any)'] = "lv/modul_admin/display_fisbone/data/$1";
$route['fishbone_view'] = "lv/modul_admin/display_fisbone/view";
$route['fungsi-dasar'] = "lv/modul_admin/getdisplay/fungsi_dasar";
$route['submit-fungsi-dasar'] = "lv/modul_admin/simpandgnView/fungsi_dasar/sv";
$route['unit-kompetensi'] = "lv/modul_admin/getdisplay/datagridview/unit_kompetensi";
$route['form-kompetensi'] = "lv/modul_admin/getdisplay/form_kompetensi";
$route["submit-unit-kompetensi"] = "lv/modul_admin/simpandgnView/unit_kompetensi";
$route['skema-sertifikasi'] = "lv/modul_admin/getdisplay/datagridview/skema_sertifikasi";
$route['form-skema_sertifikasi'] = "lv/modul_admin/getdisplay/skema_sertifikasi/form";
$route["select-unit-skema"] = "lv/modul_admin/display_flek/select_unit";
$route["select_sub_bkl"] = "lv/modul_admin/display_flek/select_sub";
$route["submit-skema-sertifikasi"] = "lv/modul_admin/simpandgnView/skema_sertifikasi/sv";
$route["edit-skema-kompetensi"] = "lv/modul_admin/getdisplay/edit_skema_sertifikasi";
$route["update-skema-sertifikasi"] = "lv/modul_admin/simpandgnView/skema_sertifikasi/up";
$route["delete-fd"] = "lv/modul_admin/simpandgnView/delete_fd";
$route["select-kompt-kunci"] = "lv/modul_admin/display_flek/select_kompt_kunci";
$route["select-dasar-hukum"] = "lv/modul_admin/display_flek/select_dasar_hukum";
$route["select_level_kk"] = "lv/modul_admin/display_flek/select_level_kk";
$route["delete-skema"] = "lv/modul_admin/simpandgnView/delete_skema";
$route["select_jabatan"] = "lv/modul_admin/display_flek/select_jabatan";

$route['form-dasar_hukum'] = "lv/modul_admin/getdisplay/dasar_hukum/form";
$route['submit-dasar-hukum'] = "lv/modul_admin/simpandgnView/dasar_hukum/sv";
$route['ed-dasar-hukum'] = "lv/modul_admin/getdisplay/dasar_hukum/edit";
$route['up-dasar-hukum'] = "lv/modul_admin/simpandgnView/dasar_hukum/up";
$route['del-dasar-hukum'] = "lv/modul_admin/simpandgnView/dasar_hukum/del";

$route['form-kementrian_grid'] = "lv/modul_admin/getdisplay/kementrian_grid/form";
$route['form-bidang'] = "lv/modul_admin/getdisplay/datagridview/bidang_urusan";
$route['form-kel-kompetensi'] = "lv/modul_admin/getdisplay/datagridview/kel_kompetensi";
$route['form-kompetensi-manajerial'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_manajerial";
$route['form-kompetensi-kunci'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_kunci";
$route['form-bakat'] = "lv/modul_admin/getdisplay/datagridview/bakat";


$route['new-fishbone/(:any)'] = "lv/modul_admin/new_fishbone/$1";
$route['json-data'] = "lv/modul_admin/json_fishbone";

//punya wahyu nyempil
/*
$route['bidang-lain'] = "lv/modul_admin/getdisplay/datagridview/bidang_lain";
$route['sub-bidang-lain'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang_lain";
$route['sub-subbidang-lain'] = "lv/modul_admin/getdisplay/sub_subbidang_lain";
$route['form-sub-subbidang-lain'] = "lv/modul_admin/getdisplay/form_sub_subbidang_lain";
*/
$route['bidang-umum'] = "lv/modul_admin/getdisplay/datagridview/bidang_umum";
$route['sub-bidang-umum'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang_umum";
$route['sub-subbidang-umum'] = "lv/modul_admin/getdisplay/sub_subbidang_umum";
$route['form-sub-subbidang-umum'] = "lv/modul_admin/getdisplay/form_sub_subbidang_umum";
$route['submit-bidang-umum'] = "lv/modul_admin/simpansavedbx/bidang_umum";
$route['submit-subbidang-umum'] = "lv/modul_admin/simpansavedbx/submit_subbidang_umum";
$route['submit-sub-subbidang-umum'] = "lv/modul_admin/simpansavedbx/submit_sub_subbidang_umum";

$route['bidang-binwas'] = "lv/modul_admin/getdisplay/datagridview/bidang_binwas";
$route['sub-bidang-binwas'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang_binwas";
$route['sub-subbidang-binwas'] = "lv/modul_admin/getdisplay/sub_subbidang_binwas";
$route['form-sub-subbidang-binwas'] = "lv/modul_admin/getdisplay/form_sub_subbidang_binwas";
$route['submit-bidang-binwas'] = "lv/modul_admin/simpansavedbx/bidang_binwas";
$route['submit-subbidang-binwas'] = "lv/modul_admin/simpansavedbx/submit_subbidang_binwas";
$route['submit-sub-subbidang-binwas'] = "lv/modul_admin/simpansavedbx/submit_sub_subbidang_binwas";

$route['bidang-sekwan'] = "lv/modul_admin/getdisplay/datagridview/bidang_sekwan";
$route['sub-bidang-sekwan'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang_sekwan";
$route['sub-subbidang-sekwan'] = "lv/modul_admin/getdisplay/sub_subbidang_sekwan";
$route['form-sub-subbidang-sekwan'] = "lv/modul_admin/getdisplay/form_sub_subbidang_sekwan";
$route['submit-bidang-sekwan'] = "lv/modul_admin/simpansavedbx/bidang_sekwan";
$route['submit-subbidang-sekwan'] = "lv/modul_admin/simpansavedbx/submit_subbidang_sekwan";
$route['submit-sub-subbidang-sekwan'] = "lv/modul_admin/simpansavedbx/submit_sub_subbidang_sekwan";

$route['bidang-kecamatan'] = "lv/modul_admin/getdisplay/datagridview/bidang_kecamatan";
$route['sub-bidang-kecamatan'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang_kecamatan";
$route['sub-subbidang-kecamatan'] = "lv/modul_admin/getdisplay/sub_subbidang_kecamatan";
$route['form-sub-subbidang-kecamatan'] = "lv/modul_admin/getdisplay/form_sub_subbidang_kecamatan";
$route['submit-bidang-kecamatan'] = "lv/modul_admin/simpansavedbx/bidang_kecamatan";
$route['submit-subbidang-kecamatan'] = "lv/modul_admin/simpansavedbx/submit_subbidang_kecamatan";
$route['submit-sub-subbidang-kecamatan'] = "lv/modul_admin/simpansavedbx/submit_sub_subbidang_kecamatan";

$route['bidang-kelurahan'] = "lv/modul_admin/getdisplay/datagridview/bidang_kelurahan";
$route['sub-bidang-kelurahan'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang_kelurahan";
$route['sub-subbidang-kelurahan'] = "lv/modul_admin/getdisplay/sub_subbidang_kelurahan";
$route['form-sub-subbidang-kelurahan'] = "lv/modul_admin/getdisplay/form_sub_subbidang_kelurahan";
$route['submit-bidang-kelurahan'] = "lv/modul_admin/simpansavedbx/bidang_kelurahan";
$route['submit-subbidang-kelurahan'] = "lv/modul_admin/simpansavedbx/submit_subbidang_kelurahan";
$route['submit-sub-subbidang-kelurahan'] = "lv/modul_admin/simpansavedbx/submit_sub_subbidang_kelurahan";


$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */