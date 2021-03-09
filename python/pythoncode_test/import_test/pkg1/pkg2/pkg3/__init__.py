__version__ = '0.1.15'

from pkg1.pkg2.pkg3.test2 import echo2
VERSION = tuple(map(int, __version__.split('.')))

__all__ = ['echo2']