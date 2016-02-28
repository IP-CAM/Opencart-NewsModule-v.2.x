<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-add-news" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_add; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $add; ?>" method="post" enctype="multipart/form-data" id="form-add-news" class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-meta-title"><?php echo $text_title; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="add-news-title" value="" placeholder="<?php echo $text_please_title; ?>" id="input-meta-title" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-meta-description"><?php echo $text_description; ?></label>
                        <div class="col-sm-10">
                            <textarea name="add-news-description" rows="10" placeholder="<?php echo $text_please_description; ?>" id="input-meta-description" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>