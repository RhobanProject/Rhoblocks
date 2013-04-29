void ChronoBlock::initialize(Block *old)
{
    value = defaultValue-scene->getPeriod();;
}

void ChronoBlock::tick()
{
    if (reset) {
        value = 0;
    } else {
        if (!pause) {
            value += factor*scene->getPeriod();
        }
    }
}
