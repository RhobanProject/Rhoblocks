$(document).ready(function() {
    var blocks = new Blocks;
    
    $.getJSON('blocks.php?action=getBlocks', function(blocksData) {
        for (k in blocksData) {
            blocks.register(blocksData[k]);
        }
    
        blocks.run('#blocks');
    });
    
    blocks.ready(function() {
	blocks.menu.addAction('Compile', function(blocks) {
            data = $.toJSON(blocks.exportData());
            $.post('blocks.php?action=compile', {'data':data}, function(response) {
                alert($.toJSON(response));
            }, 'json');
	});
    });
});
