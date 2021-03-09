# This is a sample Python script.

# Press Shift+F10 to execute it or replace it with your code.
# Press Double Shift to search everywhere for classes, files, tool windows, actions, and settings.
#import sys
#import modulet
#import sys
import sys

from modulet.test2.parser3 import HelloWorld3#模块导入，非包导入方式


sys.path.append("../")
from modulet.parser2 import HelloWorld2


def print_hi(name):
    # Use a breakpoint in the code line below to debug your script.
    print(f'Hi, {name}')  # Press Ctrl+F8 to toggle the breakpoint.


# Press the green button in the gutter to run the script.
if __name__ == '__main__':
    print_hi('PyCharm')
    x = HelloWorld2()
    y = HelloWorld3()
    x.echo2()
# See PyCharm help at https://www.jetbrains.com/help/pycharm/
