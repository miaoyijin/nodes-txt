__version__ = '0.1.15'

from pkg1.pkg2.test import echo
VERSION = tuple(map(int, __version__.split('.')))

__all__ = ['echo']
