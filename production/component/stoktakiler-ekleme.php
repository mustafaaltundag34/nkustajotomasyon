<div class="modal fade" id="stoktakiler-ekleme" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">STOKTAKİ ÜRÜNLER</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Barkod No</th>
							<th>Stok Adı</th>
							<th>Fiyatı</th>
							<th>Miktar(adet,kg)</th>
							<th>Birimi</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($sonuc as $key)
						{ 
							?>
							<tr>
								<td><?php echo $key["STOKTANIMBARKODU"]; ?></td>
								<td><?php echo $key["stoktanim_adi"]; ?></td>
								<td><?php echo $key["stoktanim_fiyat"]; ?></td>
								<form method="post" action="../netting/fatura.php">
									<td><input type="number" name="adet" min="1" value="1" style="width: 50px;"></td>
									<td><?php echo $key["stoktanim_birimi"]; ?></td>

									<td>
										<input type="hidden" name="id" value="<?php echo $key['stoktanim_id']; ?>">
										<input type="hidden" name="fatura_id" value="<?php echo $id; ?>">
										<input type="hidden" name="fatura_durum" value="<?php echo $fatura_durum; ?>">
										<input type="hidden" name="fatura_sontutar" value="<?php echo $fatura_sontutar; ?>">
										<button type="submit" class="btn btn-primary btn-sm" name="fatura-urunEkle">Faturaya Ekle</button> 
									</td> </form>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>