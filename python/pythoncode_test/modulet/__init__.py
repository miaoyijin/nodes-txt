__version__ = '0.1.15'

from modulet.parser import HelloWorld
from modulet.parser2 import HelloWorld2

VERSION = tuple(map(int, __version__.split('.')))

__all__ = ['HelloWorld', 'HelloWorld2']
