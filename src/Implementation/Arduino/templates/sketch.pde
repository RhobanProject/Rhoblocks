<?php foreach ($headers as $header) { ?>
#include <<?php echo $header; ?>>
<?php } ?>

typedef int integer;
typedef float scalar;

<?php echo $structCode; ?>

void <?php echo $prefix; ?>Init(struct <?php echo $structName; ?> *data)
{
<?php echo $initCode; ?>

}

void <?php echo $prefix; ?>Tick(struct <?php echo $structName; ?> *data)
{
<?php echo $transitionInitCode; ?>

<?php echo $transitionCode; ?>

}

<?php if ($generateMain) { ?>

int main()
{
    int last;
    struct <?php echo $structName; ?> data;

    <?php echo $prefix; ?>Init(&data);

    while (1) {
        <?php echo $prefix; ?>Tick(&data);

        last = millis();
        while ((millis()-last) < <?php echo $period; ?>);
    }

    return 0;
}

<?php } ?>
