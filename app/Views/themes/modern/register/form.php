<?= $this->extend('themes/modern/register/layout') ?>
<?= $this->section('content') ?>
<div class="card-header pb-3">
	<div class="logo">
		
	</div>
</div>

<script>
$(document).ready(function () {
                        $(".find_wil").select2({
                            placeholder: "Sekda",
							allowClear: true
                        });
						
						$(".find_bap").select2({
                            placeholder: "BAPENDA",
							allowClear: true
                        });
						
						$(".find_kpw").select2({
                            placeholder: "KPwDN",
							allowClear: true
                        });

						$(".find_bpd").select2({
                            placeholder: "BPD",
							allowClear: true
                        });
                    });
</script>

	<div>
		<img src="<?php echo $config->baseURL . 'public/images/banner.jpg' ?>" width="500">
	</div>

<div class="card-body">
	<?php
	if (!empty($message)) {
		show_message($message);
	}

	
	helper('form');
	?>
	<form action="<?=current_url()?>" method="post" accept-charset="utf-8" name="formreg">
	
		
		<div class="mb-3">
			<label class="mb-2">INSTANSI</label>
			<div class="row">
				<div class="col-auto">
				  	<input type="radio" id="ins1" name="instansi" value="ins1" checked>
					<label for="ins1">SEKRETARIS DAERAH</label><br>

					<input type="radio" id="ins2" name="instansi" value="ins2">
					<label for="ins2">BAPENDA - Badan Pendapatan Daerah</label><br>

					<input type="radio" id="ins3" name="instansi" value="ins3">
					<label for="ins3">KPwDN - Kantor Perwakilan Bank Indonesia Dalam Negeri</label><br>

					<input type="radio" id="ins4" name="instansi" value="ins4">
					<label for="ins4">BPD - Bank Pembangunan Daerah</label>
				</div>
			</div>
		</div>


		<div class="mb-3"  id="show-sekda">
			<label class="mb-2">DAERAH</label>
				
			<select class="find_wil" name="id_wilayah1" id="id_wilayah1" style="width: 100%">
				    	<option value="">No Selected</option>
				    	<?php 						
						foreach($wilayah as $row):?>
				    	<option value="<?php echo $row['id_wilayah'];?>"><?php echo $row['tempat'];?></option>
				    	<?php endforeach;?>
				    </select>
				
		</div>

		<div class="mb-3"  id="show-bapenda" style="display:none;">
			<label class="mb-2">DAERAH</label>
				
					<select class="find_bap" name="id_wilayah2" id="id_wilayah2" style="width: 100%">
				    	<option value="">No Selected</option>
				    	<?php 						
						foreach($wilayahbpd as $row):?>
				    	<option value="<?php echo $row['id_wilayah'];?>"><?php echo $row['tempat'];?></option>
				    	<?php endforeach;?>
				    </select>
				
		</div>

		<div class="mb-3"  id="show-kpw" style="display:none;">
			<label class="mb-2">DAERAH</label>
				
					<select class="find_kpw" name="id_wilayah3" id="id_wilayah3" style="width: 100%">
				    	<option value="">No Selected</option>
				    	<?php 						
						foreach($wilayahkpwdn as $row):?>
				    	<option value="<?php echo $row['id_wilayah'];?>"><?php echo $row['tempat'];?></option>
				    	<?php endforeach;?>
				    </select>
				
		</div>

		<div class="mb-3"  id="show-bpd" style="display:none;">
			<label class="mb-2">DAERAH</label>
				
					<select class="find_bpd" name="id_wilayah4" id="id_wilayah4" style="width: 100%">
				    	<option value="">No Selected</option>
				    	<?php 						
						foreach($wilayahbpd as $row):?>
				    	<option value="<?php echo $row['id_wilayah'];?>"><?php echo $row['tempat'];?></option>
				    	<?php endforeach;?>
				    </select>
				
		</div>

		<div class="mb-3">
			<label class="mb-2">HADIR / MEWAKILI</label>
			<div class="row">
				<div class="col-auto">
				  	<input type="radio" id="hadir" name="hw" value="hadir">
					<label for="hadir">HADIR</label><br>

					<input type="radio" id="wakil" name="hw" value="wakil">
					<label for="wakil">MEWAKILI</label>					
				</div>
			</div>
		</div>

		<div class="mb-3">
			<label class="mb-2">NAMA PESERTA</label>
			<input type="text"  name="nama" value="" class="form-control register-input" placeholder="Nama Peserta" aria-label="nama" required>
		</div>

		<div class="mb-3" id="vJabat" style="display: none">
			<label class="mb-2">JABATAN</label>
			<input type="text"  name="jabatan" value="" class="form-control register-input" placeholder="Jabatan" aria-label="jabatan">
		</div>

		<div class="mb-3">
			<label class="mb-2">NO HP</label>
			<input type="text"  name="no_hp" value="" class="form-control register-input" placeholder="No Hp" aria-label="no_hp" required>
		</div>

		<div class="mb-3">
			<label class="mb-2">ALAMAT EMAIL</label>
			<input type="text"  name="email" value="" class="form-control register-input" placeholder="Email" aria-label="email" required>
		</div>
		
		<div class="mb-3" style="margin-bottom:0">
			<button type="submit" name="submit" value="submit" class="btn btn-success" style="display:block;width:100%">Register</button>
			<?=csrf_formfield()?>
		</div>
	</form>
	<p style="text-align:center">Komitmen kami: kami akan menyimpan data Anda dengan aman dan tidak akan membagi data Anda ke siapapun</p>
</div>


<script>




		$('input[type="radio"]').click(function() {
			//alert('cdsdccd');
       if($(this).attr('id') == 'ins1') {
            $('#show-sekda').show();
			$('#show-bapenda').hide();	
			$('#show-kpw').hide();
			$('#show-bpd').hide();
       }
       else if ($(this).attr('id') == 'ins2') {
			$('#show-sekda').hide();
			$('#show-bapenda').show();
			$('#show-kpw').hide();
			$('#show-bpd').hide();
       } 
	   else if ($(this).attr('id') == 'ins3') {
			$('#show-sekda').hide();
			$('#show-bapenda').hide();
			$('#show-kpw').show();
			$('#show-bpd').hide();
       } 
	   else if ($(this).attr('id') == 'ins4') {
			$('#show-sekda').hide();
			$('#show-bapenda').hide();
			$('#show-kpw').hide();
			$('#show-bpd').show();
       } 
   });

   $(function () {
        $("input[name='hw']").click(function () {
            if ($("#hadir").is(":checked")) {
                $("#vJabat").hide();
            } else {
                $("#vJabat").show();
            }


			
        });



		if ($("#wakil").is(":checked"))
         {

			var jabatan = $('#jabatan').val()
				if(jabatan==null || jabatan=="") {alert("Please enter"); return false;}          
          document.getElementById("formreg").submit();
            
          
           }
    });

	
	
   
</script>

<?= $this->endSection() ?>
