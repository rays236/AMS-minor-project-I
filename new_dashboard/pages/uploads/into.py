#intro.py
"""intro to python exercises"""

a = int(input('enter five digit integer: '))


def sparate(p):
    x=len(str(p))
    val = gh = ''
    while x !=0:
        z = str(p // 10**(len(str(p))-1))
        p %= 10**(len(str(p))-1)
        val = '   '+z
        gh +=val
        x -=1
    return gh

x = sparate(a)
print(x)