<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "why/modul_admin";

//////////////////////////*** WHY
$route['admin-ctrlpnl'] = "why/modul_admin";
$route['loginadm'] = "login/loginadm";
$route['logoutadm'] = "login/logoutadm";

$route['pembentukan-tim-kerja'] = "why/modul_admin/getdisplay/pembentukan_tim";
$route['form-pembentukan-tim'] = "why/modul_admin/getdisplay/form_pembentukan_tim";
$route['submit-pembentukan-tim'] = "why/modul_admin/simpansavedbx/pembentukan_tim";

$route['rencana-perumusan'] = "why/modul_admin/getdisplay/rencana_perumusan";
$route['form-rencana-perumusan'] = "why/modul_admin/getdisplay/form_rencana_perumusan";

$route['pemetaan-fungsi'] = "why/modul_admin/getdisplay/pemetaan_fungsi";

$route['datagrid-adm/(:any)'] = "why/modul_admin/getdatagrid/$1";


///////////////////////////*** LEVI

$route['datagrid/(:any)'] = "lv/modul_admin/getdatagrid/$1";

$route['kementrian-grid'] = "lv/modul_admin/getdisplay/datagridview/kementrian_grid";
$route['bidang'] = "lv/modul_admin/getdisplay/datagridview/bidang_urusan";
$route['kel-kompetensi'] = "lv/modul_admin/getdisplay/datagridview/kel_kompetensi";
$route['kompetensi-manajerial'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_manajerial";
$route['kompetensi-kunci'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_kunci";
$route['bakat'] = "lv/modul_admin/getdisplay/datagridview/bakat";
$route['list-eselon'] = "lv/modul_admin/getdisplay/datagridview/list_eselon";
$route['sub-bidang'] = "lv/modul_admin/getdisplay/datagridview/sub_bidang";
$route['sub-subbidang'] = "lv/modul_admin/getdisplay/sub_subbidang";
$route['detil-komp-manaj'] = "lv/modul_admin/getdisplay/detil_komp_manaj";
$route['level-komp-kunci'] = "lv/modul_admin/getdisplay/level_komp_kunci";

$route['form-kementrian_grid'] = "lv/modul_admin/getdisplay/kementrian_grid/form";
$route['form-bidang'] = "lv/modul_admin/getdisplay/datagridview/bidang_urusan";
$route['form-kel-kompetensi'] = "lv/modul_admin/getdisplay/datagridview/kel_kompetensi";
$route['form-kompetensi-manajerial'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_manajerial";
$route['form-kompetensi-kunci'] = "lv/modul_admin/getdisplay/datagridview/kompetensi_kunci";
$route['form-bakat'] = "lv/modul_admin/getdisplay/datagridview/bakat";

$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */