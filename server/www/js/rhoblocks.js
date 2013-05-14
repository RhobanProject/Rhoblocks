$(document).ready(function() {
    var blocks = new Blocks;
    
    $.getJSON('/blocks.json', function(response) {
        for (k in response) {
            var block = response[k];
            blocks.register(block);
        }
        blocks.run('#blocks');
    });
    
    blocks.ready(function() {
	blocks.menu.addAction('Clear', function(blocks) {
            blocks.clear();
        }, 'clear');
    });
});
