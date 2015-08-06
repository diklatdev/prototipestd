<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "why/modul_admin";

//////////////////////////*** WHY
$route['admin-ctrlpnl'] = "why/modul_admin";
$route['loginadm'] = "login/loginadm";
$route['logoutadm'] = "login/logoutadm";

$route['pembentukan-tim-kerja'] = "why/modul_admin/getdisplay/pembentukan_tim";
$route['form-pembentukan-tim'] = "why/modul_admin/getdisplay/form_pembentukan_tim";

$route['rencana-perumusan'] = "why/modul_admin/getdisplay/rencana_perumusan";
$route['form-rencana-perumusan'] = "why/modul_admin/getdisplay/form_rencana_perumusan";

$route['pemetaan-fungsi'] = "why/modul_admin/getdisplay/pemetaan_fungsi";


///////////////////////////*** LEVI


$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */