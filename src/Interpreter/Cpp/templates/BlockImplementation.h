#ifndef _BLOCKS_<?php echo $upname; ?>_IMPL_H
#define _BLOCKS_<?php echo $upname; ?>_IMPL_H

#include "<?php echo $name; ?>BlockBase.h"

<?php if ($header) { ?>
<?php echo $header; ?>
<?php } else { ?>
namespace Blocks
{
    class <?php echo $name; ?>Block : public <?php echo $name; ?>BlockBase
    {
        public:
            void initialize(Block *old);
            void tick();

    };
};
<?php } ?>

#endif
