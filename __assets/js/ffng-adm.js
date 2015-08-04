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

function genGrid(modnya, lebarnya, tingginya){
	if(lebarnya == undefined){
		lebarnya = getClientWidth-230;
	}
	if(tingginya == undefined){
		tingginya = getClientHeight-300
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
		case "data_peserta":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_lengkap',title:'Nama Peserta',width:250, halign:'center',align:'left'},
				{field:'step_registrasi',title:'Registrasi',width:150, halign:'center',align:'center',
					formatter: function(value,row,index){
						if(row.step_registrasi == 1){
							return "<button href='#' onClick='previewData(\"registrasi\", \""+row.tbl_data_peserta_id+"\", \""+row.idx_sertifikasi_id+"\", \""+row.kdreg_diklat+"\");' ><img src='"+hostir+"assets/images/ok.png' width='16px' height='16px' /></button>";
						}else if(row.step_registrasi == 2){
							return "<button href='#' onClick='previewData(\"registrasi\", \""+row.tbl_data_peserta_id+"\", \""+row.idx_sertifikasi_id+"\", \""+row.kdreg_diklat+"\");' >Lihat Data</button>";
						}
					}
				},
				{field:'step_asesmen_mandiri',title:'Asesmen Mandiri',width:150, halign:'center',align:'center',
					formatter: function(value,row,index){
						if(row.step_asesmen_mandiri == 1){
							return "<button href='#' onClick='previewData(\"assmandiri\", \""+row.tbl_data_peserta_id+"\", \""+row.nama_lengkap+"\", \""+row.nama_aparatur+"\", \""+row.no_registrasi+"\", \""+row.idx_sertifikasi_id+"\", \""+row.kdreg_diklat+"\");' ><img src='"+hostir+"assets/images/ok.png' width='16px' height='16px' /></button>";
						}else if(row.step_asesmen_mandiri == 2){
							return "<button href='#' onClick='previewData(\"assmandiri\", \""+row.tbl_data_peserta_id+"\", \""+row.nama_lengkap+"\", \""+row.nama_aparatur+"\", \""+row.no_registrasi+"\", \""+row.idx_sertifikasi_id+"\", \""+row.kdreg_diklat+"\");' >Lihat Data</button>";
						}else if(row.step_asesmen_mandiri == 3){
							return "Dalam Proses";
						}else if(row.step_asesmen_mandiri == 0){
							return "<img src='"+hostir+"assets/images/cancel.png' width='16px' height='16px' />";
						}
					}
				},
				{field:'step_uji_test',title:'Uji Test',width:150, halign:'center',align:'center',
					formatter: function(value,row,index){
						if(row.step_uji_test == 1){
							return "<button href='#' ><img src='"+hostir+"assets/images/ok.png' width='16px' height='16px' /></button>";
						}else if(row.step_uji_test == 2){
							return "<button href='#'>Lihat Data</button>";
						}else if(row.step_uji_test == 3){
							return "Dalam Proses";
						}else if(row.step_uji_test == 4){
							return "<button href='#' onClick='kumpulPost(\"ijin_tpa\", \""+row.tbl_data_peserta_id+"\", \""+row.idx_sertifikasi_id+"\", \""+row.kdreg_diklat+"\", \""+row.step_uji_simulasi+"\" );'>Ijinkan Ujian</button>";
						}else if(row.step_uji_test == 0){
							return "<img src='"+hostir+"assets/images/cancel.png' width='16px' height='16px' />";
						}
					}
				},
				{field:'step_uji_simulasi',title:'Uji Simulasi',width:150, halign:'center',align:'center',
					formatter: function(value,row,index){
						if(row.step_uji_simulasi == 1){
							return "<button href='#' ><img src='"+hostir+"assets/images/ok.png' width='16px' height='16px' /></button>";
						}else if(row.step_uji_simulasi == 2){
							return "<button href='#'>Lihat Data</button>";
						}else if(row.step_uji_simulasi == 3){
							return "Dalam Proses";
						}else if(row.step_uji_simulasi == 4){
							return "<button href='#' onClick='kumpulPost(\"ijin_sim\", \""+row.tbl_data_peserta_id+"\", \""+row.idx_sertifikasi_id+"\", \""+row.kdreg_diklat+"\", \""+row.step_uji_test+"\");'>Ijinkan Ujian</button>";
						}else if(row.step_uji_simulasi == 0){
							return "<img src='"+hostir+"assets/images/cancel.png' width='16px' height='16px' />";
						}
					}
				},
				{field:'step_wawancara',title:'Wawancara',width:150, halign:'center',align:'center',
					formatter: function(value,row,index){
						if(row.step_wawancara == 1){
							return "<button href='#' ><img src='"+hostir+"assets/images/ok.png' width='16px' height='16px' /></button>";
						}else if(row.step_wawancara == 2){
							return "<button href='#'>Lihat Data</button>";
						}else if(row.step_wawancara == 0){
							return "<img src='"+hostir+"assets/images/cancel.png' width='16px' height='16px' />";
						}
					}
				},
				{field:'nama_asesor',title:'Petugas Asesor',width:200, halign:'center',align:'left'},
			];
		break;
		case "file_registrasi":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_lengkap',title:'Nama Peserta',width:250, halign:'center',align:'left'},
				{field:'tbl_data_peserta_id',title:'Cek File',width:150, halign:'center',align:'center',
					formatter: function(value,row,index){
						return "<button href='#'>Preview Data</button>";
					}
				},
			];
		break;
		case "akun_peserta":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_lengkap',title:'Nama Peserta',width:300, halign:'center',align:'left'},
				{field:'kdreg_diklat',title:'Status Sertifikasi',width:250, halign:'center',align:'left',
					formatter: function(value,row,index){
						if(row.kdreg_diklat != null){
							return "<font color='green'>Sedang Dalam Sertifikasi</font>";
						}else{
							return "<font color='red'>Tidak Dalam Sertifikasi</font>";
						}
					}
				},
				{field:'idnya_data_peserta',title:'Akun',width:150, halign:'center',align:'center',
					formatter: function(value,row,index){
						return "<button href='#' onClick='previewData(\"lhkps\", \""+row.idnya_data_peserta+"\");' >Lihat Akun</button>";
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
		iconCls:'database',
        fit:fitnya,
        striped:true,
        pagination:true,
        remoteSort: false,
        url: hostir+'datagrid/'+modnya,
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

}

function loadUrl(urls,func){	
    $("#tMain").html("").addClass("loading");
	$.get(urls,function (html){
	    $("#tMain").html(html).removeClass("loading");
    }).done(function(){
       // func;
    });
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

function loadUrl_adds(type, urlnya, domnya, p1, p2, p3, p4, p5, p6, p7){
	
}

function kumpulPost($type, p1, p2, p3, p4){
	
}

