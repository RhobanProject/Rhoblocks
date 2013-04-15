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
                if (response.status == 'error') {
                    blocks.messages.show(response.message, {'class': 'error'});
                } else {
                    var html = '';

                    for (name in response.files) {
                        var contents = response.files[name];
                        html += '<h2>'+name+'</h2>'+contents;
                    }

                    $('#output').html(html);
                    blocks.messages.show('The code was generated successfully', {'class': 'valid'});
                }
            }, 'json').fail(function(jh, error) {
                $('#output').html(jh.responseText);
            });
	});
    });
});
