<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-6">

      <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>

      <?= $this->session->flashdata('message'); ?>

      <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $submenu['id']; ?>">
        <div class="form-group">
          <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title" value="<?= $submenu['title']; ?>">
          <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-group">
          <select class="form-control" id="menu_id" name="menu_id">
            <?php foreach ($menu as $m) : ?>
              <?php if ($m['id'] == $submenu['menu_id']) : ?>
                <option value="<?= $m['id']; ?>" selected><?= $m['menu']; ?></option>
              <?php else : ?>
                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
              <?php endif; ?>

            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url" value="<?= $submenu['url']; ?>">
          <?= form_error('url', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon" value="<?= $submenu['icon']; ?>">
          <?= form_error('icon', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-group">
          <div class="form-check">
            <input class="" id="check-submenu" type="checkbox" data-submenu='<?= $submenu['id'] ?>' <?= ($submenu['is_active'] == 1) ? 'checked' : ''  ?>>
            <label class="form-check-label" for="check-submenu">
              Active?
            </label>
          </div>
        </div>
        <a type="button" href="<?= base_url('menu/submenu'); ?>" class="btn btn-secondary">Close</a>
        <button type="submit" class="btn btn-primary">Edit</button>
      </form>

    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->