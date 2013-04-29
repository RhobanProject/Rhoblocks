void PulseBlock::initialize(Block *old)
{
    counter = 0;
}

void PulseBlock::tick()
{
    if (counter >= (scene->getFrequency()/frequency)) {
        counter = 0;
    }

    pulse = (counter == 0);
    counter++;
}
