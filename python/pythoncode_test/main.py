# This is a sample Python script.

# Press Shift+F10 to execute it or replace it with your code.
# Press Double Shift to search everywhere for classes, files, tool windows, actions, and settings.
#import sys
#import modulet
from modulet import HelloWorld2## 为什么能这样导入，是因为__INIT__.py 文件的作用
import modulet.parser2 as t
#from modulet.parser2 import cc
from modulet.test2.parser3 import HelloWorld3


def print_hi(name):
    # Use a breakpoint in the code line below to debug your script.
    print(f'Hi, {name}')  # Press Ctrl+F8 to toggle the breakpoint.


# Press the green button in the gutter to run the script.
if __name__ == '__main__':
    print_hi('PyCharm')
    x = t.HelloWorld2()
    HelloWorld2()
    HelloWorld3()
    print(t.cc)
    x.echo2()
# See PyCharm help at https://www.jetbrains.com/help/pycharm/
