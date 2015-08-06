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
                                return '<a class="btn-floating btn-small waves-effect waves-light light-blue darken-4" href="#" onclick=\'\loadUrl_adds("list-eselon","'+hostir+'list-eselon","tMain","'+value+'")\'\><i class="mdi-content-send"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
                        }
                    },
                ];
            break;
            case"bidang_urusan":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_bidang',title:'<b>Bidang & Fungsi Kerja</b>',width:700, halign:'left',align:'left'},
                    {field:'inisial',title:'<b>Inisial</b>', halign:'left',width:150, align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light light-blue darken-4" href="#" onclick=\'\loadUrl_adds("sub-bidang","'+hostir+'sub-bidang","tMain","'+value+'")\'\><i class="mdi-content-send"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
                        }
                    },
                ];                
            break;
            case"kel_kompetensi":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_kelompok_kompetensi',title:'<b>Kelompok Kompetensi</b>',width:700, halign:'left',align:'left'},
                    {field:'inisial',title:'<b>Inisial</b>', halign:'left',width:150, align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
                        }
                    },
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
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
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
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
                        }
                    },
                ];                
            break;
            case"bakat":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_bakat',title:'<b>Bakat</b>',width:850, halign:'left',align:'left'},
                    {field:'id', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
                        }
                    },
                ];                
            break;
            case"list_eselon":
                judulnya = "";
                fitnya = true;
                pagesizeboy = 50;
                kolom[modnya] = [
                    {field:'nama_dirjen',title:'<b>ES-1</b>',width:700, halign:'left',align:'left'},
                    {field:'inisial',title:'<b>Inisial</b>',width:150, halign:'left',align:'left'},
                    {field:'id_eselon', title:'<b>Action</b>', halign:'center', width:150,align:'center',
                        formatter: function(value,row,index){
                                return '<a class="btn-floating btn-small waves-effect waves-light orange" href="kldirjen.shtml"><i class="mdi-content-create"></i></a>\n\
                                <a class="btn-floating btn-small waves-effect waves-light "><i class="mdi-content-clear"></i></a>';
                        }
                    },
                ];                
            break;
            
		case "pembentukan_tim":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_lengkap',title:'Nama Tim',width:250, halign:'center',align:'left'},
				{field:'nama_lengkap',title:'Kementerian / Lembaga',width:250, halign:'center',align:'left'},
				{field:'nama_lengkap',title:'Kelompok',width:200, halign:'center',align:'left'},
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
		case "pemetaan_fungsi":
			judulnya = "";
			fitnya = true;
			pagesizeboy = 50;
			kolom[modnya] = [	
				{field:'nama_lengkap',title:'Bidang & Fungsi Kerja',width:300, halign:'center',align:'left'},
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

<<<<<<< .mine
function loadUrl_adds(type, urlnya, domnya, p1, p2, p3, p4, p5, p6, p7){    
    $("#"+domnya).html("").addClass("loading");
    switch(type){
		/*Wahyu*/		
		case "tambah_pembentukan_tim":
			$("#div_"+urlnya).html("").addClass("loading");
			$.post(hostir+'form-pembentukan-tim', { 'editstatus':'add' }, function(respo){
				$("#div_"+urlnya).html(respo).removeClass("loading");
			 });
		break;
		case "tambah_rencana_perumusan":
			$("#div_"+urlnya).html("").addClass("loading");
			$.post(hostir+'form-rencana-perumusan', { 'editstatus':'add' }, function(respo){
				$("#div_"+urlnya).html(respo).removeClass("loading");
			 });
		break;
		/*Levi*/
        case "kementrian_grid":
            $.post(urlnya, function(resp){
                $("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "list-eselon":
            $.post(urlnya, { 'id_kementrian' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        case "sub-bidang":
            $.post(urlnya, { 'id_bidang' : p1}, function(resp){
		$("#"+domnya).html(resp).removeClass("loading");
            });
        break;
        
    }
    return false;


function kumpulPost($type, p1, p2, p3, p4){
	
}

function addrowtableinput(type, dom, p1, p2, p3){
	switch(type){
		case "pembentukan_tim":
			var counter = parseInt(p1)+1;
			
			var htmlnya = "";
			htmlnya += "<tr id='row_"+counter+"'>";
			htmlnya += "	<td>"+counter+"</td>";
			htmlnya += "	<td> <input name='nama[]' type='text' style='width:90%;'>  </td>";
			htmlnya += "	<td> <input name='jabatan[]' type='text' style='width:90%;'>  </td>";
			htmlnya += "	<td> <select class='browser-default' name='jabatan_tim_kerja[]' id='jbtankerja_"+counter+"' style='width:90%;'></select> </td>";
			htmlnya += "	<td style='text-align:center !important;'>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Tambah Anggota' onClick=\"addrowtableinput('pembentukan_tim', 'oye', '"+counter+"');\" ><i class=\"mdi-content-add-box tiny\"></i></a>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Anggota' onClick=\"deleterowtableinput('pembentukan_tim', 'oye', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";			
			htmlnya += "	</td>";			
			htmlnya += "</tr>";
			
			$('#'+dom).append(htmlnya);
			fillCmb(hostir+'why/modul_admin/getcombo/idx_jabatan_tim_kerja', "jbtankerja_"+counter );
		break;
		case "rencana_perumusan":
			var counter = parseInt(p1)+1;
			
			var htmlnya = "";
			htmlnya += "<tr id='row_"+counter+"'>";
			htmlnya += "	<td>";
			htmlnya += "		<select name='subbidang[]' id='subbidang_"+counter+"' class=\"browser-default\" style='width:90%;'></select>";
			htmlnya += "	</td>";
			htmlnya += "	<td>";
			htmlnya += "		<a href=\"javascript:void(0);\" title='Tambah Sub Bidang' onClick=\"addrowtableinput('rencana_perumusan', 'uye', '"+counter+"');\" ><i class=\"mdi-content-add-box tiny\"></i></a>";			
			htmlnya += "		<a href=\"javascript:void(0);\" title='Hapus Sub Bidang' onClick=\"deleterowtableinput('rencana_perumusan', 'uye', '"+counter+"');\"><i class=\"mdi-content-clear tiny\"></i></a>";						
			htmlnya += "	</td>";
			htmlnya += "</tr>";
			
			$('#'+dom).append(htmlnya);
			fillCmb(hostir+'why/modul_admin/getcombo/idx_sub_bidang', "subbidang_"+counter, "", $('#bidang_fungsi').val() );
		break;
	}
}

function deleterowtableinput(type, dom, p1, p2, p3){
	switch(type){
		case "pembentukan_tim":
		case "rencana_perumusan":
			$('#row_'+p1).remove();
		break;
	}
}