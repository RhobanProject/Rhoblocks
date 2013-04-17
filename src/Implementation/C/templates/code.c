<?php foreach ($headers as $header) { ?>
#include <<?php echo $header; ?>>
<?php } ?>
#include "<?php echo $prefix; ?>.h"

void <?php echo $prefix; ?>Init(struct <?php echo $structName; ?> *data)
{
    int i, j, k;
<?php echo $initCode; ?>

}

void <?php echo $prefix; ?>Tick(struct <?php echo $structName; ?> *data)
{
<?php echo $transitionInitCode; ?>

<?php echo $transitionCode; ?>

}
