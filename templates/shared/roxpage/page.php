<!DOCTYPE html>
<html lang="<?=PVars::get()->lang; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo PVars::getObj("env")->baseuri ?>favicon.ico" />
    <link rel="stylesheet" href="/build/bewelcome.css" />

    <!-- this page is generated by "class <?=get_class($this) ?>" -->
    <!-- the controller was an instance of <?=(is_string($this->controller_classname) ? ('"class '.$this->controller_classname.'"') : '[unknown class]') ?> -->
    <?=(is_object($this->layoutkit) && is_object($this->layoutkit->mem_from_redirect) ? '
        <!--
        '.$this->layoutkit->mem_from_redirect->buffered_text.'
        -->' : '') ?>
    <?php
    $this->head();
    $this->includeJsConfig();
    $this->includeScriptfiles();
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/build/backwards.js"></script>
    <![endif]-->
</head>
<body>
<?= (is_object($this->layoutkit) && (is_object($this->layoutkit->mem_from_redirect))) ? $this->layoutkit->mem_from_redirect->buffered_text : '' ?>
<?= $this->body() ?>
<?= $this->includeLateScriptfiles() ?>
</body>
</html>