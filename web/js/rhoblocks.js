$(document).ready(function() {
    var blocks = new Blocks;
    
    $.getJSON('blocks.php?action=getBlocks', function(response) {
        if (response.status == 'ok') {
            for (k in response.blocks) {
                blocks.register(response.blocks[k]);
            }
        
            blocks.run('#blocks');
            $.getJSON('blocks.php?action=getScene', function(scene) {
                if (scene) {
                    blocks.load(scene);
                }
            });
        } else {
            blocks.run('#blocks');
            blocks.messages.show(response.message, {'class': 'error'});
        }
    });
    
    blocks.ready(function() {
	blocks.menu.addAction('Clear', function(blocks) {
            blocks.clear();
        }, 'clear');

	blocks.menu.addAction('Export', function(blocks) {
            data = $.toJSON(blocks.exportData());
            $('#output').html('<pre>'+data+'</pre>');
        }, 'export');

        function runCompile(blocks) {
            data = $.toJSON(blocks.exportData());
            $.post('blocks.php?action=compile', {'data':data}, function(response) {
                if (response.status == 'error') {
                    blocks.messages.show(response.message, {'class': 'error'});
                } else {
                    var contentId = 0;
                    var html = '';

                    for (name in response.files) {
                        var contents = response.files[name];
                        html += '<h2>'+name+' <a href="javascript:void(0)" class="clipboard" rel="'+contentId+'">(Clipboard)</a></h2><span class="content'+contentId+'">'+contents+'</span>';
                        contentId++;
                    }

                    $('#output').html(html);

                    $('a.clipboard').each(function() {
                        var div = $('.content'+$(this).attr('rel'));

                        $(this).zclip({
                            path: 'js/ZeroClipboard.swf',
                            copy: div.text(),
                            afterCopy: function(){}
                        });
                    });

                    blocks.messages.show('The code was generated successfully', {'class': 'valid'});
                }
            }, 'json').fail(function(jh, error) {
                $('#output').html(jh.responseText);
            });
        };

        $('.compileButton').click(function() {
            runCompile(blocks);
        });

	blocks.menu.addAction('Compile', runCompile, 'compile');
    });

    $('.optionsForm form').on('change', function(evt) {
        evt.preventDefault();
        $('.optionsForm .optionsStatus').text('(saving...)');
        $.post('blocks.php?action=saveOptions', $(this).serializeArray(), function(response) {
            if (response) {
                $('.optionsForm .optionsStatus').text('(saved)');
            } else {
                $('.optionsForm .optionsStatus').text('(saving failed)');
            }
        }, 'json').fail(function() {
            $('.optionsForm .optionsStatus').text('(saving failed)');
        });
        return false;
    });
});
