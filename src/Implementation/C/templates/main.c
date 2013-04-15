#include <stdlib.h>
#include <stdio.h>
#include "<?php echo $prefix; ?>.h"

int main()
{
    struct <?php echo $structName; ?> data;

    // Initializing the structure
    <?php echo $prefix; ?>Init(&data);

    while (1) {
        // Ticking the structure
        <?php echo $prefix; ?>Tick(&data);

        // You can do some display or code here
        <?php echo $outputs; ?>

        usleep(1000000/<?php echo $frequency; ?>);
    }
}
