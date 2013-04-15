#ifndef <?php echo $prefixUpper; ?>_H
#define <?php echo $prefixUpper; ?>_H

typedef int integer;
typedef float scalar;

<?php echo $structCode; ?>

void <?php echo $prefix; ?>Init();
void <?php echo $prefix; ?>Tick();

#endif
