<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <!-- table row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card-body">
                <!-- alert error edit data -->
                <?= $this->session->flashdata('message_error_editmenu'); ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $menu->id ?>" />
                    <!-- edit title -->
                	<div class="form-group">
                		<label for="menu">Name menu</label>
                		<input class="form-control <?php echo form_error('menu') ? 'is-invalid':'' ?>"
                		 type="text" name="menu" placeholder="Name menu" value="<?php echo $menu->menu ?>" />
                		<div class="invalid-feedback">
                			<?php echo form_error('menu') ?>
                		</div>
                	</div>
                    <!-- btn -->
                	<input class="btn btn-success" type="submit" name="btn" value="Update" />
                </form>
			</div>
        </div>
    </div>
    
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->