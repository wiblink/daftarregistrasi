<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
			helper ('html');
			echo btn_link(['attr' => ['class' => 'btn btn-success btn-xs'],
				'url' => $config->baseURL . $current_module['nama_module'] . '/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Data'
			]);
			
			echo btn_link(['attr' => ['class' => 'btn btn-light btn-xs'],
				'url' => $config->baseURL . $current_module['nama_module'],
				'icon' => 'fa fa-arrow-circle-left',
				'label' => $current_module['judul_module']
			]);
		?>
		<hr/>
		<?php
		if (@$tgl_lahir) {
			$exp = explode('-', $tgl_lahir);
			$tgl_lahir = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
		}
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		?>
		<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
			<div class="tab-content" id="myTabContent">
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Salutation</label>
					<div class="col-sm-5">
						<?php 
						echo options(['name' => 'salute'], ['Bapak' => 'Bapak', 'Ibu' => 'Ibu', 'Miss' => 'Miss', 'Mr' => 'Mr', 'Mrs' => 'Mrs', 'Ms' => 'Ms']);
						?>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">First Name</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="f_name" value="" required="required"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Middle Name</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="m_name" value="tes2" required="required"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Last Name</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="l_name" value="grerg tes3" required="required"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Email</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<input class="form-control" type="text" name="email" value="ok@rf.com" placeholder="" required="required"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Home Address</label>
					<div class="col-sm-5">
						<textarea class="form-control" name="address">cimanggu bogor barat</textarea>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Mobile Phone</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="m_phone" value="6456356" required="required"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Company</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="company" value="oke.inc" required="required"/>
					</div>
				</div>
				<!--<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Tgl. Lahir</label>
					<div class="col-sm-5">
						<input class="form-control date-picker" type="text" name="tgl_lahir" value="<?=set_value('tgl_lahir', @$tgl_lahir)?>"/>
					</div>
				</div>-->				
			</div>
				<!--<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Foto (Image Upload)</label>
					<div class="col-sm-5">
						<?php
				
						if (!empty($foto) ) 
						{
							$note = '';
							if (file_exists(ROOTPATH . 'public/images/foto/' . $foto)) {
								$image = $config->baseURL . 'public/images/foto/' . $foto;
							} else {
								$image = $config->baseURL . 'public/images/foto/noimage.png';
								$note = '<small><b>Note</strong>: File <strong>public/images/foto/' . $foto . '</strong> tidak ditemukan</small>';
							}
							echo '<div class="img-choose" style="margin:inherit;margin-bottom:10px">
									<div class="img-choose-container">
										<img src="'. $image . '?r=' . time() . '"/>
										<a href="javascript:void(0)" class="remove-img"><i class="fas fa-times"></i></a>
									</div>
								</div>
								' . $note .'
								';
						}
						?>
						<input type="hidden" class="foto-delete-img" name="foto_delete_img" value="0">
						<input type="hidden" class="foto-max-size" name="foto_max_size" value="300000"/>
						<input type="file" class="file form-control" name="foto">
							<?php if (!empty($form_errors['foto'])) echo '<small class="alert alert-danger">' . $form_errors['foto'] . '</small>'?>
							<small class="small" style="display:block">Maksimal 300Kb, Minimal 100px x 100px, Tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-file-thumb"><span class="file-prop"></span></div>
					</div>
				</div>-->
				<div class="row">
					<div class="col-sm-5">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
						<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>