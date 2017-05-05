<div id="theContainer2" class="homePage">
    <div class="theContainer2">
        <div class="theContent">
            <div class="darkBox">
                <h3><a href="{$basedomain}home" class="fl" style="margin:20px 0 0 20px;"><< BACK</a></h3>
                <div class="short">
						<div class="date-range fl">
						<label>Date Range</label>
						<input type="text" class="half-width" name="startdate" id="datepicker" value="">
						<span>to</span>
						<input type="text" class="half-width" name="enddate" id="datepicker2" value="">
                        <input id="dateFilter" type="submit" value="GO"/>
						</div>
							
                    
                </div><!-- /.short -->
                <div class="darkBox-title">
                  <h2 class="fl">Player ID: {$username}</h2>
                  <h4><a class="downloadExcel" style="float:right;margin-top:18px;" href="{$basedomain}home/downloadExcel/{$username}">[Download List]</a></h4>
                </div><!-- /.darkBox-title -->
                <div class="darkBox-content">
					<table id="playerList" border="1" width="100%">
                        <thead style="background:#BF1323;color:#FFFFFF;">
                            <tr>
                                <td>No.</td>
                                <td><a href="#" class="sortable" data-sort="play_date" style="color:FFFFFF;">Play Date</a></td>
                                <td><a href="#" class="sortable" data-sort="win" style="color:FFFFFF;">Win</a></td>
                                <td><a href="#" class="sortable" data-sort="lose" style="color:FFFFFF;">Lose</a></td>
                                <td><a href="#" class="sortable" data-sort="date" style="color:FFFFFF;">Submit Date</a></td>
                            </tr>
                        </thead>
                        <tbody style="background:#fff;">
                            
                        </tbody>
                    </table>
                    <div id="playerListPaging" class="paging">
                       
                    </div>
				</div> <!-- /.darkBox-content -->
            </div> <!-- /.darkBox -->
           
        </div> <!-- /.theContent2 -->
    </div> <!-- /#theContainer -->
</div> <!-- /.theContainer -->

<script>
var start=0;
var fromDate="";
var toDate="";
var orderBy="date";
var orderType=0;
var dataCollection;
var detail=true;
var username = '{$username}';
{literal}

$(document).ready(function(){
    getPlayerLogs({},0);

    $('a.sortable').click(function(e){
        e.preventDefault();
        orderBy=$(this).data('sort');
        orderType=((orderType==0)?1:0);
        getPlayerLogs({},0);
    });
});

$('#dateFilter').click(function(event){
    event.preventDefault();
    if($('#datepicker').val()!=""&&$('#datepicker2').val()!=""){
        fromDate = $('#datepicker').val();
        toDate = $('#datepicker2').val();

        $('a.downloadExcel').attr('href',basedomain+'home/downloadExcel/'+username+'/'+fromDate+'/'+toDate);

        getPlayerLogs({},0);
    }else{
       fromDate=null; 
       toDate=null; 

       $('a.downloadExcel').attr('href',basedomain+'home/downloadExcel/'+username);

        getPlayerLogs({},0);
    }
});

function getPlayerLogs(data,start){
    data={};
    data.start=start;
    data.fromDate=fromDate;
    data.toDate=toDate;
    data.orderBy=orderBy;
    data.orderType=orderType;
    data.username=username;
    data.detail=detail;
    
    $('#playerList tbody').html('<tr><td style="text-align:center" colspan="9"><img width="30px" src="'+basedomain+'assets/images/loader.gif" /></td></tr>');
    $('#playerListPaging').html('');
    $.post(basedomain+'../service/player/lists',data,function(response){
        var str="";
        var index = start+1;
        try{
            $.each(response.data,function(k,v){
                str+='<tr>';
                str+='<td>'+index+'</td>';
                str+='<td>'+v.playing_date+'</td>';
                str+='<td>'+v.win+'</td>';
                str+='<td>'+v.lose+'</td>';              
                str+='<td>'+v.submit_date+'</td>';
                str+='</tr>';
                index++;
            });

            $('#playerList tbody').html(str);

            if(start==0){
                start=1;
                kiPagination(response.total, start, 'playerListPaging', data, 'getPlayerLogs', 10);
            }
        }catch(e){
             $('#playerList tbody').html('<tr><td style="text-align:center" colspan="8">No data available.</td></tr>');
        }
    },'json');
} 
{/literal}
</script>
