#ifndef <?php echo $prefixUpper; ?>_H
#define <?php echo $prefixUpper; ?>_H

typedef int integer;
typedef float scalar;

<?php echo $structCode; ?>

void <?php echo $prefix; ?>Init(struct <?php echo $structName; ?> *);
void <?php echo $prefix; ?>Tick(struct <?php echo $structName; ?> *);

#endif
