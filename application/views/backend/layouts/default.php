<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo $this->template->print_meta(); ?>
        <title><?php echo $this->template->print_title(); ?></title>
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url('favicon.ico'); ?>" />
        <!--basic styles-->
        <link href='http://fonts.googleapis.com/css?family=Hanuman:400,700|Open+Sans:400,600,600italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
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
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <!-- Header page -->
                <?php echo $header; ?>
                <!-- Sidebar Page -->
                <?php echo $sidebar; ?>
            </nav>
            <!-- Content -->
            <div id="page-wrapper">
                <?php echo $content;?>
            </div>
        </div>

        <?php echo $this->template->print_js(); ?>
        
        <?php echo $this->template->print_jquery(); ?>
        
        <?php echo $this->template->print_script(); ?> 
    </body>
</html>