<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Rhoban Blocks</title>
        <script type="text/javascript" src="js/jquery.js"></script>

<?php if (isset($_GET['dev'])) { ?>
        <script type="text/javascript" src="blocks/js/jquery.json.js"></script>
        <script type="text/javascript" src="blocks/js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="blocks/js/jquery.svg.min.js"></script>
        <script type="text/javascript" src="blocks/js/jquery.formserialize.js"></script>
        <script type="text/javascript" src="blocks/js/utils.js"></script> 
        <script type="text/javascript" src="blocks/js/parameterfield.js"></script> 
        <script type="text/javascript" src="blocks/js/parametersmanager.js"></script> 
        <script type="text/javascript" src="blocks/js/segment.js"></script> 
        <script type="text/javascript" src="blocks/js/edge.js"></script> 
        <script type="text/javascript" src="blocks/js/blocksmessages.js"></script> 
        <script type="text/javascript" src="blocks/js/blocksmenu.js"></script> 
        <script type="text/javascript" src="blocks/js/blocktype.js"></script> 
        <script type="text/javascript" src="blocks/js/block.js"></script> 
        <script type="text/javascript" src="blocks/js/blocks.js"></script> 
<?php } else { ?>
        <script type="text/javascript" src="blocks/lib/blocks.js"></script> 
<?php } ?>

        <script type="text/javascript" src="js/rhoblocks.js"></script>
        <link rel="stylesheet" type="text/css" href="blocks/lib/blocks.css" />
        <link rel="stylesheet" type="text/css" href="css/rhoblocks.css" />
        <link rel="stylesheet" type="text/css" href="css/highlight.css" />
    </head>
    <body>
        <h1>Rhoban Blocks</h1>
        <div id="blocks"></div>
    </body>
</html>
