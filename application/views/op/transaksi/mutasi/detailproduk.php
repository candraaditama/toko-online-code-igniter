<table class="table table-bordered">
<thead>	
	<th>Tersedia</th>
	<th>Qty</th>
</thead>
<?php
$d=produk_stok_data($tokoid,$produkid);
if(!empty($d))
{
	$i=0;
	foreach($d as $r)
	{
		$i+=1;
		
		$mutasi=$r->stok_mutasi;
		$jual=$r->stok_jual;
		$stok=$r->stok-($mutasi+$jual);
		if($stok > 0)
		{
					
	?>
	<tr>		
		<td><?=$stok;?></td>
		<td>
			<input type="hidden" name="info[produkid][]" value="<?=$r->produk_id;?>"/>
			<input type="hidden" id="tersedia<?=$i;?>" value="<?=$stok;?>"/>
			<input type="number" name="info[qty][]" class="form-control qty" data-id="<?=$i;?>" required="" value="1"/>
		</td>
	</tr>
	<?php
		}
	}
}
?>
</table>

<script>
$(document).ready(function(){

$(".qty").each(function(o_index,o_val){
	$(this).on("blur",function(){
		var did=$(this).attr('data-id');
		var v=$(this).val();
		var t=$("#tersedia"+did).val();
		if(parseInt(v) > parseInt(t))
		{
			$(this).val(1);			
		}
	});
});

});
</script>