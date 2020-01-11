<?php
$o='';
if(!empty($data))
{
	$i=0;
	foreach($data as $row)
	{
		$i+=1;
		$tarif=$row['cost'][0]['value'];
		$service=$row['service'];
		$deskripsi=$row['description'];
		$waktu=$row['cost'][0]['etd']?$row['cost'][0]['etd']:"-";
		?>
		<div class="col-md-4">
			<div class="radio">
				<label>
					<input type="radio" name="service" class="service" data-id="<?=$i;?>" value="<?=$service;?>"/><?=$service;?>
				</label>
			</div>
			<input type="hidden" name="tarif" id="tarif<?=$i;?>" value="<?=$tarif;?>"/>
			<p>
				<?=$deskripsi;?><br/>
				Tarif <b>Rp <?=number_format($tarif,0);?></b><br/>
				Estimasi waktu sampai <b><?=$waktu;?> hari</b>
			</p>
		</div>
		<?php			
	}
?>
<script>
$(document).ready(function(){

$(".service").each(function(o_index,o_val){
	$(this).on("change",function(){
		var did=$(this).attr('data-id');
		var tarif=$("#tarif"+did).val();
		$("#ongkir").val(tarif);
		hitung();
	});
});

});
</script>
<?php
}
echo $o;
?>