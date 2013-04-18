<?php foreach ($headers as $header) { ?>
#include <<?php echo $header; ?>>
<?php } ?>

typedef int integer;
typedef float scalar;

<?php echo $structCode; ?>

void <?php echo $prefix; ?>Init(struct <?php echo $structName; ?> *data)
{
int i,j,k;

<?php echo $initCode; ?>

}

void <?php echo $prefix; ?>Tick(struct <?php echo $structName; ?> *data)
{
<?php echo $transitionInitCode; ?>

<?php echo $transitionCode; ?>

}

<?php if ($generateMain) { ?>
struct <?php echo $structName; ?> data;

void setup()
{
    <?php echo $prefix; ?>Init(&data);
}

void loop()
{
    unsigned long int tick;

    while (1) {
        tick = millis();
        <?php echo $prefix; ?>Tick(&data);

        while ((millis()-tick) < <?php echo $period; ?>);
    }
}

<?php } ?>
