<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo $this->template->print_meta(); ?>
        
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url('favicon.ico'); ?>" />
        <!--basic styles-->
        <?php echo $this->template->print_css(); ?>
        
        <!-- Optional Javascript -->
        <?php echo $this->template->print_js_optional(); ?>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>

    <body>
        <?php echo $content;?>

        <?php echo $this->template->print_js(); ?>
        
        <?php echo $this->template->print_jquery(); ?>
        
    </body>
</html>