function getClientHeight(){
	var theHeight;
	if (window.innerHeight)
		theHeight=window.innerHeight;
	else if (document.documentElement && document.documentElement.clientHeight) 
		theHeight=document.documentElement.clientHeight;
	else if (document.body) 
		theHeight=document.body.clientHeight;
	
	return theHeight;
}
function getClientWidth(){
	var theWidth;
	if (window.innerWidth) 
		theWidth=window.innerWidth;
	else if (document.documentElement && document.documentElement.clientWidth) 
		theWidth=document.documentElement.clientWidth;
	else if (document.body) 
		theWidth=document.body.clientWidth;

	return theWidth;
}

function fillCmb(url, SelID, value, value2, value3, value4){
	if (value == undefined) value = "";
	if (value2 == undefined) value2 = "";
	if (value3 == undefined) value3 = "";
	if (value4 == undefined) value4 = "";
	
	$('#'+SelID).empty();
	$.post(url, {"v": value, "v2": value2, "v3": value3, "v4": value4},function(data){
		$('#'+SelID).append(data);
	});
}

function genGrid(modnya, lebarnya, tingginya, p1, p2){
	if(lebarnya == undefined){
		lebarnya = getClientWidth-230;
	}
	if(tingginya == undefined){
		tingginya = getClientHeight-350
	}

	var kolom ={};
	var frozen ={};
	var judulnya;
	var param={};
	var urlnya;
	var urlglobal="";
	var fitnya;
	var pagesizeboy = 10;
	
	switch(modnya){
            case "kementrian_grid":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_kl',title:'<b>Bidang Urusan Pemerintahan</b>',width:700, halign:'left',align:'left',
                        styler: function(value,row,index){
					return 'margin-top:8px;';
					// the function can return predefined css class and inline style
					// return {class:'c1',style:'color:red'}
				}
                    },
                    {field:'inisial',title:'<b>Inisial</b>', halign:'left',width:150, align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light light-blue darken-4" href="#" onclick=\'\loadUrl_adds("list-eselon","'+hostir+'list-eselon","tMain","'+value+'")\'\><i class="mdi-content-send"></i></a>';
                                /*<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
                                */
                        }
                    },
                ];
            break;
            case"bidang_urusan":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_bidang',title:'<b>Urusan & Fungsi Kerja</b>',width:700, halign:'left',align:'left'},
                    {field:'inisial',title:'<b>Inisial</b>', halign:'left',width:150, align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light light-blue darken-4" href="#" onclick=\'\loadUrl_adds("sub-bidang","'+hostir+'sub-bidang","tMain","'+value+'")\'\><i class="mdi-content-send"></i></a>';/*\n\
                                <a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';*/
                        }
                    },
                ];                
            break;
            case"kel_kompetensi":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_kelompok_kompetensi',title:'<b>Kelompok Kompetensi</b>',width:850, halign:'left',align:'left'},
                    {field:'inisial',title:'<b>Inisial</b>', halign:'left',width:150, align:'left'},
//                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
//                        formatter: function(value,row,index){
//                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>';/*\n\
//                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';*/
//                        }
//                    },
                ];                
            break;
            case"kompetensi_manajerial":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_kelompok',title:'<b>Kelompok</b>',width:300, halign:'left',align:'left'},
                    {field:'ini_kelompok',title:'<b>Kode Kelompok</b>', halign:'left',width:150, align:'left'},
                    {field:'nama_kompetensi_manajerial',title:'<b>Kompetensi Managerial</b>', halign:'left',width:300, align:'left'},
                    {field:'ini_komp',title:'<b>Kode</b>', halign:'left',width:150, align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:100,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="#" onclick=\'\loadUrl_adds("detil-komp-manaj","'+hostir+'detil-komp-manaj","tMain","'+value+'")\'\><i class="mdi-content-create"></i></a>';/*n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';*/
                        }
                    },
                ];
            break;
            case"kompetensi_kunci":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama',title:'<b>Kompetensi Kunci</b>',width:850, halign:'left',align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light light-blue darken-4" href="#" onclick=\'\loadUrl_adds("level-komp-kunci","'+hostir+'level-komp-kunci","tMain","'+value+'")\'\><i class="mdi-content-send"></i></a>';/*\n\
                                <a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';*/
                        }
                    },
                ];                
            break;
            case"bakat_list":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_bakat',title:'<b>Bakat</b>',width:1000, halign:'left',align:'left'},
//                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
//                        formatter: function(value,row,index){
//                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>';/*\n\
//                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';*/
//                        }
//                    },
                ];                
            break;
            case"dasar_hukum":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'dasar_hukum',title:'<b>Dasar Hukum</b>',width:850, halign:'left',align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="#" onclick=\'loadUrl_adds("dasar_hukum","'+hostir+'ed-dasar-hukum", "tMain", "'+value+'" )\'><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light " href="#" onclick=\'kumpulPost("add-dasar-hukum","","delete","'+value+'" )\'><i class="mdi-content-clear"></i></a>';
                        }
                    },
                ];                
            break;
            case"list_eselon":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_dirjen',title:'<b>ES-1</b>',width:850, halign:'left',align:'left'},
                    {field:'inisial',title:'<b>Inisial</b>',width:150, halign:'left',align:'left'},
//                    {field:'id_eselon', title:'<b>Action</b>', halign:'center', width:150,align:'center',
//                        formatter: function(value,row,index){
//                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
//                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
//                        }
//                    },
                ];                
            break;
            case"sub_bidang":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_sub_bidang',title:'<b>SUB BIDANG & FUNGSI KERJA URUSAN PEMERINTAHAN</b>',width:700, halign:'left',align:'left'},
                    {field:'inisial',title:'<b>Inisial</b>',width:150, halign:'left',align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light light-blue darken-4" href="#" onclick=\'\loadUrl_adds("sub-subbidang","'+hostir+'sub-subbidang","tMain","'+value+'")\'\><i class="mdi-content-send"></i></a>';/*\n\
                                <a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';*/
                        }
                    },
                ];                
            break;
            case "pemetaan_fungsi-UK":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [	
                    {field:'nama_bidang',title:'<b>Urusan Pemerintahan</b>',width:570, halign:'left',align:'left'},
                    {field:'fishbone',title:'<b>Fishbone</b>',width:100,align:'center',
                        formatter: function(value,row,index){
                            return '<a title="Fishbone E3" class="btn-floating btn-small waves-effect waves-light" href="#" onclick=\'\loadUrl_adds("fishbone_view","'+hostir+'fishbone_view","tMain","'+value+'")\'\><i class="mdi-editor-vertical-align-center"></i></a>\n\
                                <a target="_blank" title="Fishbone goJS" class="btn-floating btn-small waves-effect waves-light" href="new-fishbone/'+value+'" ><i class="mdi-editor-vertical-align-center"></i></a>';
                        }
                    },
                    {field:'fungsi_dasar', title:'<b>Tugas/Layanan/Produk</b>', halign:'center', width:180,align:'center',
                        formatter: function(value,row,index){
                                return '<a title="Tugas/Layanan/Produk Pusat" class="btn-floating btn-small waves-effect waves-light orange" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-1-UK"+'")\'\><i class="mdi-action-book"></i></a>\n\
                                <a title="Tugas/Layanan/Produk Provinsi" class="btn-floating btn-small waves-effect waves-light yellow" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-2-UK"+'")\'\><i class="mdi-action-book"></i></a>\n\
                                <a title="Tugas/Layanan/Produk Kabupaten/Kota" class="btn-floating btn-small waves-effect waves-light red" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-3-UK"+'")\'\><i class="mdi-action-book"></i></a>';
                        }
                    },
                    {field:'unit_kompetensi', title:'<b>Unit Kompetensi</b>', halign:'center', width:120,align:'center',
                        formatter: function(value,row,index){
                                return '<a title="Unit Kompetensi" class="btn-floating btn-small waves-effect waves-light blue"  href="#" onclick=\'\loadUrl_adds("unit-kompetensi","'+hostir+'unit-kompetensi","tMain","'+value+'")\'\><i class="mdi-action-assignment"></i></a>';
                        }
                    },
                ];
                
            break;
            case "pemetaan_fungsi-UL":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [	
                    {field:'nama_bidang',title:'<b>Urusan Pemerintahan</b>',width:570, halign:'left',align:'left'},
                    {field:'fishbone',title:'<b>Fishbone</b>',width:100,align:'center',
                        formatter: function(value,row,index){
                            return '<a title="Fishbone E3" class="btn-floating btn-small waves-effect waves-light" href="#" onclick=\'\loadUrl_adds("fishbone_view","'+hostir+'fishbone_view","tMain","'+value+'")\'\><i class="mdi-editor-vertical-align-center"></i></a>\n\
                                <a target="_blank" title="Fishbone goJS" class="btn-floating btn-small waves-effect waves-light" href="new-fishbone/'+value+'" ><i class="mdi-editor-vertical-align-center"></i></a>';
                        }
                    },
                    {field:'fungsi_dasar', title:'<b>Tugas/Layanan/Produk</b>', halign:'center', width:180,align:'center',
                        formatter: function(value,row,index){
                                return '<a title="Tugas/Layanan/Produk Pusat" class="btn-floating btn-small waves-effect waves-light orange" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-1-UL"+'")\'\><i class="mdi-action-book"></i></a>\n\
                                <a title="Tugas/Layanan/Produk Provinsi" class="btn-floating btn-small waves-effect waves-light yellow" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-2-UL"+'")\'\><i class="mdi-action-book"></i></a>\n\
                                <a title="Tugas/Layanan/Produk Kabupaten/Kota" class="btn-floating btn-small waves-effect waves-light red" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-3-UL"+'")\'\><i class="mdi-action-book"></i></a>';
                        }
                    },
                    {field:'unit_kompetensi', title:'<b>Unit Kompetensi</b>', halign:'center', width:120,align:'center',
                        formatter: function(value,row,index){
                                return '<a title="Unit Kompetensi" class="btn-floating btn-small waves-effect waves-light blue"  href="#" onclick=\'\loadUrl_adds("unit-kompetensi","'+hostir+'unit-kompetensi","tMain","'+value+'")\'\><i class="mdi-action-assignment"></i></a>';
                        }
                    },
                ];
                
            break;
            case "pemetaan_fungsi-JFU":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [	
                    {field:'nama_bidang',title:'<b>Urusan Pemerintahan</b>',width:570, halign:'left',align:'left'},
                    {field:'fishbone',title:'<b>Fishbone</b>',width:100,align:'center',
                        formatter: function(value,row,index){
                            return '<a title="Fishbone E3" class="btn-floating btn-small waves-effect waves-light" href="#" onclick=\'\loadUrl_adds("fishbone_view","'+hostir+'fishbone_view","tMain","'+value+'")\'\><i class="mdi-editor-vertical-align-center"></i></a>\n\
                                <a target="_blank" title="Fishbone goJS" class="btn-floating btn-small waves-effect waves-light" href="new-fishbone/'+value+'" ><i class="mdi-editor-vertical-align-center"></i></a>';
                        }
                    },
                    {field:'fungsi_dasar', title:'<b>Tugas/Layanan/Produk</b>', halign:'center', width:180,align:'center',
                        formatter: function(value,row,index){
                                return '<a title="Tugas/Layanan/Produk Pusat" class="btn-floating btn-small waves-effect waves-light orange" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-1-JFU"+'")\'\><i class="mdi-action-book"></i></a>\n\
                                <a title="Tugas/Layanan/Produk Provinsi" class="btn-floating btn-small waves-effect waves-light yellow" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-2-JFU"+'")\'\><i class="mdi-action-book"></i></a>\n\
                                <a title="Tugas/Layanan/Produk Kabupaten/Kota" class="btn-floating btn-small waves-effect waves-light red" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+"-3-JFU"+'")\'\><i class="mdi-action-book"></i></a>';
                        }
                    },
                    {field:'unit_kompetensi', title:'<b>Unit Kompetensi</b>', halign:'center', width:120,align:'center',
                        formatter: function(value,row,index){
                                return '<a title="Unit Kompetensi" class="btn-floating btn-small waves-effect waves-light blue"  href="#" onclick=\'\loadUrl_adds("unit-kompetensi","'+hostir+'unit-kompetensi","tMain","'+value+'")\'\><i class="mdi-action-assignment"></i></a>';
                        }
                    },
                ];
                
            break;
            case "unit_kompetensi":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [	
                    {field:'judul_unit',title:'<b>Judul Unit Kompetensi</b>',width:850, halign:'left',align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light blue"  href="#" onclick=\'\loadUrl_adds("form-kompetensi","'+hostir+'form-kompetensi","tMain","'+value+'")\'\><i class="mdi-content-send"></i></a>';
//                                <a class="btn-floating btn-small waves-effect waves-light orange" href="#" onclick=\'\loadUrl_adds("fungsi-dasar","'+hostir+'fungsi-dasar","tMain","'+value+'")\'\><i class="mdi-hardware-keyboard-arrow-up"></i></a>\n\
                                
                        }
                    },
                    ];
            break;
            case"skema_sertifikasi":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_bkl',title:'<b>Urusan Sertifikasi</b>',width:300, halign:'left',align:'left'},
                    {field:'nama_sub_bkl',title:'<b>Sub Urusan</b>', halign:'left',width:275, align:'left'},
                    {field:'pekerjaan',title:'<b>Judul</b>', halign:'left',width:275, align:'left'},
                    {field:'skema',title:'<b>Skema</b>', halign:'left',width:75, align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:75,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="#" onclick=\'\loadUrl_adds("edit-skema-kompetensi","'+hostir+'edit-skema-kompetensi","tMain","'+value+'")\'\><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light" href="javascript:void(0)" onclick=\'kumpulPost("delete_skema","tMain", "'+value+'")\' >\n\
                                    <i class="mdi-content-clear"></i>\n\
                                </a>';
                        }
                    },
                ];
            break;
            
		case "pembentukan_tim":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama',title:'<b>Nama Tim</b>',width:250, halign:'center',align:'left'},
				{field:'nama_kl',title:'<b>Kementerian / Lembaga</b>',width:250, halign:'center',align:'left'},
				{field:'nama_dirjen',title:'<b>Dirjen</b>',width:200, halign:'center',align:'left'},
				{field:'nama_bidang',title:'<b>Bidang</b>',width:200, halign:'center',align:'left'},
				{field:'nama_timkerja',title:'<b>Jenis Tim Kerja</b>',width:200, halign:'center',align:'left'},
			];
		break;
		case "rencana_perumusan":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_lengkap',title:'Nama Kegiatan',width:250, halign:'center',align:'left'},
				{field:'nama_lengkap',title:'Bidang Urusan',width:250, halign:'center',align:'left'},
			];
		break;
	}
	
	$("#"+modnya).datagrid({
	title:judulnya,
        height:tingginya,
        width:lebarnya,
        rownumbers:true,
        iconCls:'',
        fit:fitnya,
        striped:true,
        pagination:true,
        remoteSort: false,
        url: hostir+'datagrid/'+modnya+'/'+p1+'/'+p2,
        nowrap: true,
        singleSelect:true,
        pageSize:pagesizeboy,
        pageList:[10,20,30,40,50,75,100,200],
        queryParams:param,
        columns:[
            kolom[modnya]
        ],
        toolbar: '#toolbar_'+modnya,
	});

	$('.pagination-page-list').css({'display':'inline'});
}

function genGrid2(modnya, lebarnya, tingginya, p1, p2){
	if(lebarnya == undefined){
		lebarnya = getClientWidth-230;
	}
	if(tingginya == undefined){
		tingginya = getClientHeight-350
	}

	var kolom ={};
	var frozen ={};
	var judulnya;
	var param={};
	var urlnya;
	var urlglobal="";
	var fitnya;
	var pagesizeboy = 10;
	
	switch(modnya){
		case "pembentukan_tim":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama',title:'<b>Nama Tim</b>',width:250, halign:'center',align:'left'},
				{field:'nama_kl',title:'<b>Kementerian / Lembaga</b>',width:250, halign:'center',align:'left'},
				{field:'nama_dirjen',title:'<b>Dirjen</b>',width:200, halign:'center',align:'left'},
				{field:'nama_bidang',title:'<b>Urusan Pemerintahan</b>',width:200, halign:'center',align:'left'},
				{field:'nama_timkerja',title:'<b>Jenis Tim Kerja</b>',width:200, halign:'center',align:'left'},
			];
		break;
		case "rencana_perumusan":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_kegiatan',title:'<b>Nama Kegiatan</b>',width:250, halign:'center',align:'left'},
				{field:'nama_bidang',title:'<b>Urusan Pemerintahan</b>',width:300, halign:'center',align:'left'},
			];
		break;
		case "peta_jabatan":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_bidang',title:'<b>Urusan Pemerintahan - K/L</b>',width:400, halign:'center',align:'left'},
				{field:'jenis_bkl',title:'<b>Tipologi</b>',width:500, halign:'center', align:'left',
					formatter: function(value,row,index){
						var buttonhtml = "";
						if(row.jenis_bkl == 'B'){
							buttonhtml = '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'A\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light indigo">A</a> &nbsp;';
							buttonhtml += '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'B\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light green">B</a> &nbsp;';
							buttonhtml += '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'C\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light orange">C</a> &nbsp;';
							buttonhtml += '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'DS\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light indigo">DS</a> &nbsp;';
							buttonhtml += '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'KEL\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light green">KEL</a> &nbsp;';
							buttonhtml += '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'KEC\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light orange">KEC</a> &nbsp;';
						}else if(row.jenis_bkl == 'K'){
							buttonhtml = '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'JFT\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light grey">JFT</a> &nbsp;';
							buttonhtml += '<a href="javascript:void(0);" onClick="loadUrl_adds(\'det-petjab\', \''+hostir+'\detail-peta-jabatan\', \'tMain\', \'JFU\', \''+row.jenis_bkl+'\', \''+row.id+'\', \''+row.nama_bidang+'\' );" class="btn waves-effect waves-light purple">JFU</a> &nbsp;';
						}
						
						return buttonhtml;
					}
				},
			];
		break;
		case "detail_peta_jabatan":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			
			param['tipgi'] = tipologi;
			param['jns_bkl'] = jenis_bkl;
			param['idx_kbl'] = id_bkl;
			kolom[modnya] = [	
				{field:'nama_jabatan',title:'<b>Nama Jabatan</b>',width:250, halign:'center',align:'left'},
				{field:'tugas',title:'<b>Tugas</b>',width:300, halign:'center',align:'left'},
				{field:'id',title:'<b>Action</b>',width:100, halign:'center',align:'center',
					formatter: function(value,row,index){
						var buttonhtml = "";
						buttonhtml = '<a href="javascript:void(0);" onClick="loadUrl_adds(\'edit_detail_peta_jabatan\', \'detail_peta_jabatan\', \'\', \''+row.id+'\')" class="btn-floating waves-effect waves-light orange"><i class="mdi-content-create"></i></a> &nbsp;';
						buttonhtml += '<a href="javascript:void(0);" onClick="loadUrl_adds(\'hapus_detail_peta_jabatan\', \''+row.id+'\' );" class="btn-floating waves-effect waves-light"  ><i class="mdi-content-clear"></i></a> &nbsp;';
						return buttonhtml;
					}
				
				},
			];
		break;
	}
	
	$("#"+modnya).datagrid({
		title:judulnya,
        height:tingginya,
        width:lebarnya,
        rownumbers:true,
        iconCls:'',
        fit:fitnya,
        striped:true,
        pagination:true,
        remoteSort: false,
        url: hostir+'datagrid-adm/'+modnya,
		nowrap: false,
        singleSelect:true,
        pageSize:pagesizeboy,
        pageList:[10,20,30,40,50,75,100,200],
        queryParams:param,
        columns:[
            kolom[modnya]
        ],
        toolbar: '#toolbar_'+modnya,
	});

	$('.pagination-page-list').css({'display':'inline'});
}


function loadUrl(urls,func){	
    $("#tMain").html("").addClass("loading");
	
	$.get(urls,function (html){
	    $("#tMain").html(html).removeClass("loading");
    }).done(function(){
       // func;
    });
	//*/
}

function ajxamsterfrm(objid, func){
    var url = $('#'+objid).attr("url");
    $('#'+objid).form('submit',{
            url:url,
            onSubmit: function(){
                    return $(this).form('validate');
            },
            success:function(data){
				    if (func == undefined ){
                     if (data == "1"){
                                              
                    }else{
                        var pesan = data.replace('1','');
                        //$.messager.alert('Error','Error Saving Data '+pesan,'error');
                    }
                }else{
                    func(data);
                }
            },
            error:function(data){
                
            }
    });
}

function sbmbyk(type){
	switch(type){
		case "pembentukan_tim":
			ajxamsterfrm('pembentukan_tim', function(resp){
				if(resp == 1){
					//alert('Data Tersimpan');
					$.messager.alert('Sukses','Data Tersimpan','info');
					loadUrl(hostir+'pembentukan-tim-kerja');
				}else{
					//alert(resp);
					$.messager.alert('Warning','Gagal, Ada Kesalahan Sistem.','warning');
					console.log(resp);
					loadUrl(hostir+'pembentukan-tim-kerja');
				}
			});
		break;
		case "rencana_perumusan":
			ajxamsterfrm('rencana_perumusan', function(resp){
				if(resp == 1){
					//alert('Data Tersimpan');
					$.messager.alert('Sukses','Data Tersimpan','info');
					loadUrl(hostir+'rencana-perumusan');
				}else{
					//alert(resp);
					$.messager.alert('Warning','Gagal, Ada Kesalahan Sistem.','warning');
					console.log(resp);
					loadUrl(hostir+'rencana-perumusan');
				}
			});
		break;
		case "peta_jabatan":
			ajxamsterfrm('detail_petjab', function(resp){
				if(resp == 1){
					//alert('Data Tersimpan');
					//loadUrl(hostir+'rencana-perumusan');
					$.messager.alert('Sukses','Data Tersimpan','info');
					loadUrl_adds('det-petjab', hostir+'detail-peta-jabatan', 'tMain', tipologi, jenis_bkl, kubil, breadcumb);					
				}else{
					//alert(resp);
					//loadUrl(hostir+'rencana-perumusan');
					$.messager.alert('Warning','Gagal, Ada Kesalahan Sistem.','warning');
					console.log(resp);
					loadUrl_adds('det-petjab', hostir+'detail-peta-jabatan', 'tMain', tipologi, jenis_bkl, kubil, breadcumb);					
				}
			});
		break;
	}
}

function loadUrl_adds(type, urlnya, domnya, p1, p2, p3, p4, p5, p6, p7){  
    switch(type){
		/*Wahyu*/		
		case "tambah_pembentukan_tim":
			$("#div_"+urlnya).html("").addClass("loading");
			$.post(hostir+'form-pembentukan-tim', { 'editstatus':'add' }, function(respo){
				$("#div_"+urlnya).html(respo).removeClass("loading");
			 });
		break;
		case "edit_pembentukan_tim":
			var rows = $('#pembentukan_tim').datagrid('getSelected');
			if(rows){
				$("#div_"+urlnya).html("").addClass("loading");
				$.post(hostir+'form-pembentukan-tim', { 'editstatus':'edit', 'id':rows.id }, function(respo){
					$("#div_"+urlnya).html(respo).removeClass("loading");
				});
			}else{
				$.messager.alert('Warning','Pilih Data Yang Akan Diedit.','warning');
			}		
		break;
		case "hapus_pembentukan_tim":
			var rows = $('#pembentukan_tim').datagrid('getSelected');
			if(rows){
				$.messager.confirm('Confirm','Anda Yakin Akan Menghapus Data Ini?',function(r){
					if(r){
						$.post(hostir+'hapus-pembentukan-tim', { 'editstatus':'delete', 'id':rows.id }, function(respo){
							if(respo == 1){
								$.messager.alert('Sukses','Data Sudah Terhapus','info');
							}else{
								$.messager.alert('Warning','Gagal, Ada Kesalahan Sistem.','warning');
							}
							$('#pembentukan_tim').datagrid('reload');
						});
					}
				});
			}else{
				$.messager.alert('Warning','Pilih Data Yang Akan Diedit.','warning');
			}
			
		break;
		case "tambah_rencana_perumusan":
			$("#div_"+urlnya).html("").addClass("loading");
			$.post(hostir+'form-rencana-perumusan', { 'editstatus':'add' }, function(respo){
				$("#div_"+urlnya).html(respo).removeClass("loading");
			 });
		break;
		case "edit_rencana_perumusan":
			var rows = $('#rencana_perumusan').datagrid('getSelected');
			if(rows){
				$("#div_"+urlnya).html("").addClass("loading");
				$.post(hostir+'form-rencana-perumusan', { 'editstatus':'edit', 'id':rows.id }, function(respo){
					$("#div_"+urlnya).html(respo).removeClass("loading");
				});
			}else{
				$.messager.alert('Warning','Pilih Data Yang Akan Diedit.','warning');
			}		
		break;
		case "hapus_rencana_perumusan":
			var rows = $('#rencana_perumusan').datagrid('getSelected');
			if(rows){
				$.messager.confirm('Confirm','Anda Yakin Akan Menghapus Data Ini?',function(r){
					if(r){
						$.post(hostir+'hapus-rencana-perumusan', { 'editstatus':'delete', 'id':rows.id }, function(respo){
							if(respo == 1){
								$.messager.alert('Sukses','Data Sudah Terhapus','info');
							}else{
								$.messager.alert('Warning','Gagal, Ada Kesalahan Sistem.','warning');
							}
							$('#rencana_perumusan').datagrid('reload');
						});
					}
				});
			}else{
				$.messager.alert('Warning','Pilih Data Yang Akan Diedit.','warning');
			}
			
		break;
		case "det-petjab":
			$("#"+domnya).html("").addClass("loading");
			$.post(urlnya, { 'tipgi':p1, 'jns_bkl':p2, 'idx_kbl':p3, 'lbl':p4 }, function(respo){
				$("#"+domnya).html(respo).removeClass("loading");
			});
		break;
		case "tambah_detail_peta_jabatan":
			$("#div_"+urlnya).html("").addClass("loading");
			$.post(hostir+'form-detail-peta-jabatan', { 'editstatus':'add', 'tipgi':tipologi, 'jns_bkl':jenis_bkl, 'idx_kbl':kubil, 'lbl':label }, function(respo){
				$("#div_"+urlnya).html(respo).removeClass("loading");
			 });
		break;
		case "edit_detail_peta_jabatan":			
			$("#div_detail_peta_jabatan").html("").addClass("loading");
			$.post(hostir+'form-detail-peta-jabatan', { 'editstatus':'edit', 'idxny':p1, 'tipgi':tipologi, 'jns_bkl':jenis_bkl, 'idx_kbl':kubil, 'lbl':label }, function(respo){
				$("#div_detail_peta_jabatan").html(respo).removeClass("loading");
			 });
		break;
		case "hapus_detail_peta_jabatan":
			$.messager.confirm('Confirm','Anda Yakin Akan Menghapus Data Ini?',function(r){
				if(r){
					$.post(hostir+'hapus-detail-peta-jabatan', { 'editstatus':'delete', 'id':urlnya }, function(respo){
						if(respo == 1){
							$.messager.alert('Sukses','Data Sudah Terhapus','info');
						}else{
							$.messager.alert('Warning','Gagal, Ada Kesalahan Sistem.','warning');
						}
						$('#detail_peta_jabatan').datagrid('reload');
					});
				}
			});
		break;
		case "kembali_detail_peta_jabatan":
			loadUrl(hostir+'peta-jabatan');
		break;
		
	/*Levi*/
        case "kementrian_grid":  
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, function(resp){
                $("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "list-eselon":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_kementrian' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "sub-bidang":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_bidang' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "sub-subbidang":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_subbidang' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case 'detil-komp-manaj':
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_komp_man' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "level-komp-kunci":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_komp_kunci' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "fishbone_view":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_bidang' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "fishbone_new":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_bidang' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });            
        break;
        case "fungsi-dasar":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_bidang' : p1+'-'+p2,}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "unit-kompetensi":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_bidang' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "form-kompetensi":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_unit_kompetensi' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "skema_sertifikasi":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, {}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;   
        case "select_sub_bkl":
            var id_bkl = $('#bkl').val().split('_');
            var html_unit = "";
            html_unit = "<a href='#' onclick=\"addrowtableinput_lv('add_skema_unit','unit_row','btn_add', '0', '"+id_bkl[0]+"');\"><i class='mdi-content-add-box tiny right'></i></a>";            
            $.post(urlnya, {'id_bkl':$('#bkl').val()}, function(resp){
		$("#"+domnya).html(resp);
                $("#btn_add").html(html_unit);
            });            
        break;
        case "edit-skema-kompetensi":
            $("#"+domnya).html("").addClass("loading");
            $.post(urlnya, { 'id_bkl' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;  
        case "select_level_kk":
            var id_kom_kunci = $('#komp_kunci_'+p1).val();
            
            $.post(urlnya, {'id_kom_kunci':id_kom_kunci}, function(resp){
		$("#"+domnya).html(resp);
            });            
        break;
        case "select_jabatan":
            var id_skema= $('#id_skema').val();
            
            $.post(urlnya, {'id_skema':id_skema}, function(resp){
		$("#"+domnya).html(resp);
            });            
        break;
        case "dasar_hukum":            
            $.post(urlnya, {'id_dasar_hukum':p1}, function(resp){
                $("#"+domnya).html(resp);
            });
        break;
        
    }
    return false;
	}


function kumpulPost($type, domnya, p1, p2, p3, p4){
    switch($type){
        case "delete_fd":
            if (confirm('Apakah Anda Akan Menghapus Fungsi Dasar Ini?')) {
                $.post(hostir+"delete-fd",{'id_fd':p1},function(rspp){
                   if (rspp == 1){
                       alert('Data berhasil Dihapus');
                        loadUrl_adds('fungsi-dasar', hostir+'fungsi-dasar','tMain',p2 );
                   } else{
                       alert(rspp);
                   }
                });
            }
        break;
        case "add_fd":	 		
            $.post(hostir+"submit-fungsi-dasar", $('form').serialize(),function (rspp){
                if (rspp == 1){
                    alert('Data berhasil Disimpan');
                    loadUrl_adds('fungsi-dasar', hostir+'fungsi-dasar','tMain',p1, p2 );
                }else{
                    alert('Penyimpanan gagal! :'+rspp);
                }		
            });
        break;
        case "sv-unit-kompetensi":
            $.post(hostir+"submit-unit-kompetensi", $('form').serialize(), function(rspp){
                if (rspp == 1){
                    alert('Data berhasil Disimpan');
                    //$("#"+domnya).html(rspp);
                    loadUrl_adds("form-kompetensi",hostir+"form-kompetensi","tMain",p1);
                }else{
                    alert("Data Gagal Disimpan");
                }
            });
        break;
        case "save_skema_sert":		
            $.post(hostir+"submit-skema-sertifikasi", $('form').serialize(),function (rspp){
                if (rspp == 1){
                    alert('Data berhasil Disimpan');
                    loadUrl('skema-sertifikasi');
                }else{
                    alert("Data Gagal Disimpan : "+rspp);
                }		
            });            
        break;
        case "update_skema_sert":
            $.post(hostir+"update-skema-sertifikasi", $('form').serialize(),function (rspp){
                if (rspp == 1){
                    alert('Data berhasil Diperbaharui');
                    loadUrl('skema-sertifikasi');
                }else{
                    alert("Data Gagal Disimpan : "+rspp);
                }		
            });
        break;
        case "delete_skema":
            if (confirm('Apakah Anda Akan Menghapus Skema Ini?')) {
                $.post(hostir+"delete-skema", {'id_skema':p1}, function(rspp){
                    loadUrl('skema-sertifikasi');
                });
             }else{
                 loadUrl('skema-sertifikasi');
             }
        break;
        case "add-dasar-hukum":	 
            switch(p1){
                case "add":
                    $.post(hostir+"submit-dasar-hukum", $('form').serialize(),function (rspp){
                        if (rspp == 1){
                            alert('Data berhasil Disimpan');
                            loadUrl('dasar-hukum');
                        }else{
                            alert('Penyimpanan gagal! :'+rspp);
                        }		
                    });
                break;
                case "update":
                    $.post(hostir+"up-dasar-hukum", $('form').serialize(),function (rspp){
                        if (rspp == 1){
                            alert('Data berhasil Diperbaharui');
                            loadUrl('dasar-hukum');
                        }else{
                            alert('Penyimpanan gagal! :'+rspp);
                        }		
                    });
                break;
                case "delete":
                    if (confirm('Apakah Anda Akan Menghapus Data ini?')){
                        $.post(hostir+"del-dasar-hukum", {'id_dasar_hukum':p2},function (rspp){
                            if (rspp == 1){
//                                alert('Data berhasil Dihapus');
                                loadUrl('dasar-hukum');
                            }else{
                                alert('Gagal Dihapus! :'+rspp);
                            }		
                        });
                    }
                break
            }
            
        break;
    }
	
}

function addrowtableinput_lv(type, dom, dom_link, p1, p2, p3, p4){
	switch(type){
            case "unjuk-kerja":
                var counter = parseInt(p1)+1;
                var htmlnya = "";
                htmlnya += "<li class='collection-item' id='li_id_"+counter+"'>";
                htmlnya += "    <div>";
                htmlnya += "        <input name=unjuk_"+p2+"[] id='unjuk_"+p2+"_"+counter+"' type='text' style='width:98%;' value='' >";
                htmlnya += "		<a href=\"javascript:void(0);\" title='Cancel' onClick=\"deleterowtableinput_lv('unjuk_kerja', 'oye', 'btn_unjuk', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";
                htmlnya += "	</div>";	                
                htmlnya += "</li>";
                
                var html_link = "";
                html_link +="Kriteria Unjuk Kerja  "; 
                html_link +="<a href='#' onClick=\"addrowtableinput_lv('unjuk-kerja','unjuk_row_"+counter+"','btn_unjuk',  '"+counter+"');\" ><i class=\"mdi-content-add-box tiny\"></i></a>"
                
                $('#'+dom).before(htmlnya);
                //$('#'+dom_link).html(html_link);
            break
            case "add-element":
                var counter = parseInt(p1)+1;
                var htmlnya = "";
                htmlnya += "<div class='row' id='row_"+counter+"'>";
                htmlnya += "	<div class='input-field col s12'>";			
                htmlnya += "        <input name='elemen[]' id='element_"+counter+"' type='text' style='width:90%;' value='' >";			
                htmlnya += "        <a href=\"javascript:void(0);\" title='Cancel' onClick=\"deleterowtableinput_lv('add_elemen', 'oye', 'btn_elemen', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
                htmlnya += "        <label for='element_"+counter+"' class='active'>Elemen Kompetensi</label>";
                htmlnya += "	</div>";                
                htmlnya += "</div>";
                
                var html_link = "";
                html_link +="Elemen Kompetensi "; 
                html_link +="<a class=\"btn-floating btn-small waves-effect waves-light green\" href='#' onClick=\"addrowtableinput_lv('add-element','element_row','btn_elemen',  '"+counter+"');\" >"
                html_link +="<i class=\"mdi-content-add\"></i>"
                html_link +="</a>"

                $('#'+dom).before(htmlnya);
//                $('#'+dom_link).html(html_link);
            break
            case "add_skema_unit":
                var counter = parseInt(p1)+1;
                var htmlnya = "";                
                
                var html_link = "";
                html_link +="<a href='javascript:void(0);' onclick=\"addrowtableinput_lv('add_skema_unit','unit_row','btn_add', '"+counter+"', '"+p2+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
                                
                $.post(hostir+"select-unit-skema", {'id_bidang':p2, 'counter':counter},function (rspp){  
                    htmlnya = rspp;
                    $('#'+dom).before(htmlnya);
                    $('#'+dom_link).html(html_link);		
                });
            break;
            case "add_skema_dasar":
                var counter = parseInt(p1)+1;
                var htmlnya = "";                
                
                var html_link = "";
                html_link +="<a href='javascript:void(0);' onclick=\"addrowtableinput_lv('add_skema_dasar','dasar_row','btn_add_dasar', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
                    
                htmlnya += "<tr id='dasar_row_"+counter+"'>";                
                htmlnya += "	<td> <input name='dasar[]' id='dasar_"+counter+"' type='text' style='width:90%;' value='' ></td>";
                htmlnya += "	<td> <input name='bukti[]' id='bukti_"+counter+"' type='text' style='width:90%;' value='' ></td>";
                htmlnya += "	<td style='text-align:center !important;'>";			
                htmlnya += "		<a href=\"javascript:void(0);\" title='Cancel' onClick=\"deleterowtableinput_lv('dasar_skema', 'oye', 'btn_dasar', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
//                htmlnya += "		<a href=\"javascript:void(0);\" title='Simpan' onClick=\"kumpulPost('add_fd','row_"+counter+"') \"><i class=\"mdi-action-done tiny\"></i></a>";			
                htmlnya += "	</td>";	
                htmlnya += "</tr>";
                
                $('#'+dom).before(htmlnya);
                $('#'+dom_link).html(html_link);	            
            break;
        case "edit_kuk":
            var htmlnya = "";
            var text_con = $('#txt_'+p2).text();
            
            htmlnya += "<div>";
            htmlnya += "    <input name='editkuk_"+p2+"[]' id='editkuk"+p2+"' type='text' style='width:98%;' value='"+text_con+"' >";
            htmlnya += "    <a href=\"javascript:void(0);\" title='Cancel' onClick=\"deleterowtableinput_lv('edit_kuk', 'li_kuk_"+p2+"', '', '"+p2+"', '"+text_con+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";
            htmlnya += "</div>";
            
            $('#'+dom).html(htmlnya);
            
        break;
        case "edit_elemen":
            var htmlnya = "";
            var text_con = $('#txtel_'+p2).text();
            
            htmlnya += "<div>";
            htmlnya += "    <input class='white' name='editelemen_"+p2+"[]' id='editelemen_"+p2+"' type='text' style='width:98%;' value='"+text_con+"' >";
            htmlnya += "    <a href=\"javascript:void(0);\" title='Cancel' onClick=\"deleterowtableinput_lv('edit_elemen', 'ele_id_"+p2+"', '', '"+p2+"', '"+text_con+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";
            htmlnya += "</div>";
            
            $('#'+dom).html(htmlnya);
            
        break;
        case "del_kuk":
            var html = "";
            var dominput = p1;
            
            html += "<input name='del_kuk[]' id='del_kuk_"+p2+"' value='"+p2+"' type='hidden'>";
            
            $('#'+dom).remove();
            $('#'+dominput).after(html);
        break;   
        case "del_elemen":
            var html = "";
            var dominput = p1;
            
            html += "<input name='del_elemen[]' id='del_elemen_"+p2+"' value='"+p2+"' type='hidden'>";
            
            $('#'+dom).remove();
            $('#'+dominput).after(html);
        break;  
        case "add_komp_kunci":
            var counter = parseInt(p1)+1;
            var htmlnya = "";                

            var html_link = "";
            html_link +="<a href='javascript:void(0);' onclick=\"addrowtableinput_lv('add_skema_unit','unit_row','btn_add', '"+counter+"', '"+p2+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 

            $.post(hostir+"select-kompt-kunci", {'counter':counter},function (rspp){  
                htmlnya = rspp;
                $('#'+dom).before(htmlnya);
                //$('#'+dom_link).html(html_link);		
            });
        break;
        case "del_lev_kk":
            var html = "";
            var dominput = p1;
            
            html += "<input name='del_lev_kk[]' id='del_lev_kk_"+p2+"' value='"+p2+"' type='hidden'>";
            
            $('#'+dom).remove();
            $('#'+dominput).after(html);
        break;
        case "add_dasar_hukum":
            var counter = parseInt(p1)+1;
            var htmlnya = "";                

            $.post(hostir+"select-dasar-hukum", {'counter':counter, 'id_bidang':p2},function (rspp){  
                htmlnya = rspp;
                $('#'+dom).before(htmlnya);
                //$('#'+dom_link).html(html_link);		
            });
        break;
        case "del_dasar_hukum":
            var html = "";
            var dominput = p1;
            
            html += "<input name='del_dasar_hukum[]' id='del_dasar_hukum_"+p2+"' value='"+p2+"' type='hidden'>";
            
            $('#'+dom).remove();
            $('#'+dominput).after(html);
        break;
        
    }
}

function deleterowtableinput_lv(type, dom, dom_link, p1, p2, p3){
	switch(type){
		case "add_elemen":
                    /*
                    var html_link = "";
                    html_link +="Elemen Kompetensi "; 
                    html_link +="<a class=\"btn-floating btn-small waves-effect waves-light green\" href='#' onClick=\"addrowtableinput_lv('add-element','element_row','btn_elemen',  '0');\" >"
                    html_link +="<i class=\"mdi-content-add\"></i>"
                    html_link +="</a>"
                    */
                    $('#row_'+p1).remove();
                    //$('#'+dom_link).html(html_link);
                break;
                case "unjuk_kerja":
                    /*var html_link = "";
                    html_link +="Kriteria Unjuk Kerja  "; 
                    html_link +="<a href='#' onClick=\"addrowtableinput_lv('unjuk-kerja','unjuk_row','btn_unjuk',  '0');\" ><i class=\"mdi-content-add-box tiny\"></i></a>"
                    */
                    $('#li_id_'+p1).remove();
                    //$('#'+dom_link).html(html_link);
                break;
		case "rencana_perumusan":
			$('#row_'+p1).remove();
		break;
                case "unit_skema":
                    $('#row_'+p1).remove();
                break;
                case "dasar_skema":
                    $('#dasar_row_'+p1).remove();
                break;
                case "del_unit_skesert":
                    var htmldel = "";
                    htmldel += "<input name='del_unit_id[]' value='"+p1+"' type='hidden'>";
                    
                    $('#unitrow_'+p1).remove();
                    $('#unit_row').after(htmldel);
                break;
                case "del_syarat_skesert":
                    var htmldel = "";
                    htmldel += "<input name='del_dasar_id[]' value='"+p1+"' type='hidden'>";
                    
                    $('#dasarrow_'+p1).remove();
                    $('#dasar_row').after(htmldel);
                break;
                case "edit_kuk":
                    var htmlnya = "";

                    htmlnya += "<div>";
                    htmlnya += "     <font id='txt_"+p1+"'>"+p2+"</font> ";
                    htmlnya += "    <a href='javascript:void(0)' class='secondary-content' onclick=\"addrowtableinput_lv('edit_kuk','li_kuk_"+p1+"','','','"+p1+"')\">";
                    htmlnya += "        <i class='mdi-content-create tiny'></i></a>";
                    htmlnya += "    <a href='javascript:void(0)' class='secondary-content' onclick=\"addrowtableinput_lv('del_kuk','li_kuk_"+p1+"','','id_fung_das','"+p1+"')\">";
                    htmlnya += "        <i class='mdi-content-clear tiny'></i></a>";
                    htmlnya += "</div>";
                    
                    $('#'+dom).html(htmlnya);
                break;
                case "edit_elemen":
                    var htmlnya = "";

                    htmlnya += "<div>";
                    htmlnya += "     <font style=\"font-size:1.3rem\" id='txtel_"+p1+"' id='txt_"+p1+"'>"+p2+"</font> ";
                    htmlnya += "    <a href='javascript:void(0)' class='secondary-content' onclick=\"addrowtableinput_lv('edit_elemen','ele_id_"+p1+"','','','"+p1+"')\">";
                    htmlnya += "        <i class='mdi-content-create tiny'></i></a>";
                    htmlnya += "    <a href='javascript:void(0)' class='secondary-content' onclick=\"addrowtableinput_lv('del_elemen','li_elemen_"+p1+"','id_fung_das','"+p1+"')\">";
                    htmlnya += "        <i class='mdi-content-clear tiny'></i></a>";
                    htmlnya += "</div>";
                    
                    $('#'+dom).html(htmlnya);
                break;
                case "dasar_hukum":
                    $('#hukum_'+p1).remove();
                break;
	}
}

function addrowtableinput(type, dom, dom_linked, p1, p2, p3, p4){
        //p1 counter, p2 sub_bidang, p3 sub2bidang
	switch(type){
            case "fungsi_dasar":
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                var text = '';
                for( var i=0; i < 5; i++ ){
                    text += possible.charAt(Math.floor(Math.random() * possible.length));
                }
                var counter = parseInt(p1)+text;
                var htmlnya = "";
                htmlnya += "<tr id='row_"+counter+"_"+p1+"_"+p2+"_"+p3+"'>";
                htmlnya += "	<td></td>";
                htmlnya += "	<td> </td>";
                htmlnya += "	<td> <input name='fd_"+p2+"_"+p3+"[]' id='fungsi_dasar' type='text' style='width:90%;' value=''></td>";
                htmlnya += "	<td> <select class='browser-default' name='kel_"+p2+"_"+p3+"[]' id='kel_kom' style='width:90%;'>\n\
                                        <option value='1'>UMUM</option>\n\
                                        <option value='2'>INTI</option>\n\
                                        <option value='3'>PILIHAN</option>\n\
                                    </select> \n\
                                </td>";
                htmlnya += "	<td style='text-align:center !important;'>";			
                htmlnya += "		<a href=\"javascript:void(0);\" title='Cancel Fungsi Dasar' onClick=\"deleterowtableinput('fungsi_dasar', 'row_', '"+counter+"_"+p1+"_"+p2+"_"+p3+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
//                htmlnya += "		<a href=\"javascript:void(0);\" title='Simpan Fungsi Dasar' onClick=\"kumpulPost('add_fd','row_"+counter+"') \"><i class=\"mdi-action-done tiny\"></i></a>";			
                htmlnya += "	</td>";	
                htmlnya += "</tr>";	

                $('#'+dom).before(htmlnya);
		
            break;
		case "pembentukan_tim":
			var counter = parseInt(p1)+1;
			var html_link = "";
			var htmlnya = "";
			
			htmlnya += "<tr id='oye_"+counter+"'>";
			htmlnya += "	<input type='hidden' name='idx_tim[]' value='' />";
			htmlnya += "	<td> <input name='nama[]' type='text' style='width:90%;'>  </td>";
			htmlnya += "	<td> <input name='jabatan[]' type='text' style='width:90%;'>  </td>";
			htmlnya += "	<td> <select class='browser-default' name='jabatan_tim_kerja[]' id='jbtankerja_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td> <select class='browser-default' name='isuser[]' id='isuser_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td> <input name='email[]' type='text' style='width:90%;'>  </td>";
			htmlnya += "	<td style='text-align:center !important;'>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Anggota' onClick=\"deleterowtableinput('pembentukan_tim', 'oye_"+counter+"', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
			htmlnya += "	</td>";			
			htmlnya += "</tr>";
			
            html_link +="<a href='#' onclick=\"addrowtableinput('pembentukan_tim', 'oye', 'btn_dsr', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
			
			$('#'+dom).before(htmlnya);
			$('#'+dom_linked).html(html_link);
			fillCmb(hostir+'why/modul_admin/getcombo/idx_jabatan_tim_kerja', "jbtankerja_"+counter );
			fillCmb(hostir+'why/modul_admin/getcombo/ya_tidak', "isuser_"+counter );
		break;
		case "rencana_perumusan":
			var counter = parseInt(p1)+1;
			
			var htmlnya = "";
			var html_link = "";
			
			htmlnya += "<tr class='renper' id='uye_"+counter+"'>";
			htmlnya += "	<td>";
			htmlnya += "		<select name='subbidang[]' id='subbidang_"+counter+"' class=\"browser-default\" style='width:90%;'></select>";
			htmlnya += "	</td>";
			htmlnya += "	<td style='text-align:center !important;'>";
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Sub Bidang' onClick=\"deleterowtableinput('rencana_perumusan', 'uye_"+counter+"', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";						
			htmlnya += "	</td>";
			htmlnya += "</tr>";
			
			html_link +="<a href='#' onclick=\"addrowtableinput('rencana_perumusan', 'uye', 'btn_dsr', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
			
			$('#'+dom).before(htmlnya);
			$('#'+dom_linked).html(html_link);
			
			fillCmb(hostir+'why/modul_admin/getcombo/idx_sub_bidang', "subbidang_"+counter, "", $('#bidang_fungsi').val() );
		break;
		case "kompetensi_manajerial":
			var counter = parseInt(p1)+1;
			var html_link = "";
			var htmlnya = "";
			
			htmlnya += "<tr id='ahaide_"+counter+"'>";
			htmlnya += "	<td> <select class='browser-default' id='kompetensi_manajerial_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td> <select class='browser-default' name='levelkompetensimanajerial[]' id='levelkompetensimanajerial_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td style='text-align:center !important;'>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Anggota' onClick=\"deleterowtableinput('kompetensi_manajerial', 'ahaide_"+counter+"', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
			htmlnya += "	</td>";			
			htmlnya += "</tr>";
			
			html_link +="<a href='#' onclick=\"addrowtableinput('kompetensi_manajerial', 'ahaide', 'btn_ahaide', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
			$('#'+dom).before(htmlnya);
			$('#'+dom_linked).html(html_link);
			
			fillCmb(hostir+'why/modul_admin/getcombo/idx_kompetensi_manajerial', "kompetensi_manajerial_"+counter );
			$('#kompetensi_manajerial_'+counter).bind('change', function(){
				fillCmb(hostir+'why/modul_admin/getcombo/idx_level_kompetensi_manajerial', "levelkompetensimanajerial_"+counter, '', $(this).val() );
			});
			//fillCmb(hostir+'why/modul_admin/getcombo/ya_tidak', "isuser_"+counter );
		break;
		case "kompetensi_teknis":
			var counter = parseInt(p1)+1;
			var html_link = "";
			var htmlnya = "";
			
			htmlnya += "<tr id='ohoi_"+counter+"'>";
			htmlnya += "	<td> <select class='browser-default' name='unit_kompetensi[]' id='unit_kompetensi_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td> <span id='kode_unit_kompetensi_"+counter+"'></span> </td>";
			htmlnya += "	<td style='text-align:center !important;'>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Anggota' onClick=\"deleterowtableinput('kompetensi_teknis', 'ohoi_"+counter+"', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
			htmlnya += "	</td>";			
			htmlnya += "</tr>";
			
			html_link +="<a href='#' onclick=\"addrowtableinput('kompetensi_teknis', 'ohoi', 'btn_ohoi', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
			
			$('#'+dom).before(htmlnya);
			$('#'+dom_linked).html(html_link);
			
			fillCmb(hostir+'why/modul_admin/getcombo/tbl_unit_kompetensi', "unit_kompetensi_"+counter );
			$('#unit_kompetensi_'+counter).bind('change', function(){
				$.post(hostir+'get-kode-unit-kompetensi', { 'idxn':$(this).val() } , function(crespo){
					if(crespo == null){
						$('#kode_unit_kompetensi_'+counter).html('-');
					}else{
						$('#kode_unit_kompetensi_'+counter).html(crespo);
					}
				});
			});
		break;
		case "bakat":
			var counter = parseInt(p1)+1;
			var html_link = "";
			var htmlnya = "";
			
			htmlnya += "<tr id='ihii_"+counter+"'>";
			htmlnya += "	<td> <select class='browser-default' name='bakat[]' id='bakat_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td style='text-align:center !important;'>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Anggota' onClick=\"deleterowtableinput('bakat', 'ihii_"+counter+"', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
			htmlnya += "	</td>";			
			htmlnya += "</tr>";
			
			html_link +="<a href='#' onclick=\"addrowtableinput('bakat', 'ihii', 'btn_ihii', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
			
			$('#'+dom).before(htmlnya);
			$('#'+dom_linked).html(html_link);
			fillCmb(hostir+'why/modul_admin/getcombo/idx_bakat', "bakat_"+counter );
		break;
		case "prasyarat_dasar":
			var counter = parseInt(p1)+1;
			var html_link = "";
			var htmlnya = "";
			
			htmlnya += "<tr id='ocii_"+counter+"'>";
			htmlnya += "	<td> <input name='prasyarat_dasar[]' type='text' style='width:90%;'> </td>";
			htmlnya += "	<td> <input name='bukti[]' type='text' style='width:90%;'> </td>";
			htmlnya += "	<td style='text-align:center !important;'>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Anggota' onClick=\"deleterowtableinput('prasyarat_dasar', 'ocii_"+counter+"', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
			htmlnya += "	</td>";			
			htmlnya += "</tr>";
			
			html_link +="<a href='#' onclick=\"addrowtableinput('prasyarat_dasar', 'ocii', 'btn_ocii', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 
			
			$('#'+dom).before(htmlnya);
			$('#'+dom_linked).html(html_link);
		break;
		case "dasar_hukum":
			var counter = parseInt(p1)+1;
			var html_link = "";
			var htmlnya = "";
			
			htmlnya += "<tr id='acuy_"+counter+"'>";
			htmlnya += "	<td> <select class='browser-default' name='dasar_hukum[]' id='dasar_hukum_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td style='text-align:center !important;'>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Dasar Hukum' onClick=\"deleterowtableinput('dasar_hukum', 'acuy_"+counter+"', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
			htmlnya += "	</td>";
			htmlnya += "</tr>";
			
			html_link +="<a href='#' onclick=\"addrowtableinput('dasar_hukum', 'acuy', 'btn_acuy', '"+counter+"');\"><i class='mdi-content-add-box tiny right'></i></a>"; 			
			
			$('#'+dom).before(htmlnya);
			$('#'+dom_linked).html(html_link);
			fillCmb(hostir+'why/modul_admin/getcombo/idx_dasar_hukum', "dasar_hukum_"+counter );
		break;
		
	}
}

function deleterowtableinput(type, dom, p1, p2, p3, p4, p5){
	switch(type){
		case "pembentukan_tim":
		case "rencana_perumusan":
		case "kompetensi_manajerial":
		case "kompetensi_teknis":
		case "bakat":
		case "prasyarat_dasar":
		case "dasar_hukum":
			
			if(p2 == 'edit'){
				var r = confirm("Yakin Untuk Menghapus Data Anggota Tim Dari Tim Kerja Ini?");
				if (r == true) {
					$.post(hostir+'why/modul_admin/simpansavedbx/hpsanggotatim', { 'idxn':p3 } , function(crespo){
						console.log(crespo);
					});
					$('#'+dom).remove();
				}
			}else{
				$('#'+dom).remove();
			}
			
		break;
		case "fungsi_dasar":
			$('#'+dom+p1).remove();
		break;
	}
}