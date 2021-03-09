import sys

from pkg1.pkg2 import echo
from pkg1.pkg2.pkg3.test2 import echo2
from pkg1.pkg2.pkg3 import echo2
from pkg1.pkg2.pkg3 import echo2##这是绝对路径导入包

if __name__ == '__main__':
    print(sys.path)
    echo()
    echo2()
# See PyCharm help at https://www.jetbrains.com/help/pycharm/
