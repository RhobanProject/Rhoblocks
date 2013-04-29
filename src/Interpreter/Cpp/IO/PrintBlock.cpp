void PrintBlock::initialize(Block *old)
{
}

void PrintBlock::tick()
{
    if (trigger) {
        int pos = 0;
        for (int i=0; i<format.size(); i++) {
            if (format[i] == '%' && i+1<format.size()) {
                if (format[i+1] == 'd') {
                    cout << (int)value[pos++];
                    i++;
                } else if (format[i+1] == 'f') {
                    cout << (double)value[pos++];
                    i++;
                } else {
                    cout << format[i];
                }
            } else {
                cout << format[i];
            }
        }
        cout << endl;
    }
}
