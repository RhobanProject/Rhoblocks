<?php foreach ($headers as $header) { ?>
#include <<?php echo $header; ?>>
<?php } ?>

typedef int integer;
typedef float scalar;

<?php if ($printf) { ?>
static FILE uartout = {0} ;
static int uart_putchar (char c, FILE *stream)
{
    Serial.write(c) ;
    return 0 ;
}
<?php } ?>

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

<?php if ($printf) { ?>
    Serial.begin(<?php echo $baudrate; ?>);
    fdev_setup_stream (&uartout, uart_putchar, NULL, _FDEV_SETUP_WRITE);
    stdout = &uartout ;
<?php } ?>
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
