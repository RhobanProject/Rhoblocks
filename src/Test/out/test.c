#include <math.h>
#include "test.h"

void testInit(struct test_data *data)
{
data->variable_7_T = 0.0;
data->output_0 = 0.0;
}

void testTick(struct test_data *data)
{
    scalar state_7_output_0;
    scalar state_8_output_0;
    scalar state_2_output_0;

data->variable_7_T += 0.033333333333333;
state_7_output_0 = data->variable_7_T;
state_8_output_0 = 0.3;
state_2_output_0 = sin(state_7_output_0*2.0*M_PI*state_8_output_0+0)*1;
data->output_0 = state_2_output_0;
}
