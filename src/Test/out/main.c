#include <stdlib.h>
        #include <stdio.h>
        #include "test.h"

        int main()
        {
            struct test_data data;

            // Initializing the structure
            testInit(&data);

            while(1) {
                // Ticking the structure
                testTick(&data);
                usleep(1000000/30);

                // You can do some display or code here
            }
        }
