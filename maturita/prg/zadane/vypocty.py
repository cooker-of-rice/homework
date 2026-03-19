import math


def distance(x1, y1, x2, y2):
    #vzdálenost dvou bodů v rovině
    return math.sqrt((x2 - x1) ** 2 + (y2 - y1) ** 2)


def circle_circumference(x1, y1, x2, y2):
    #obvod kružnice
    r = distance(x1, y1, x2, y2)
    return 2 * math.pi * r


def rectangle_perimeter(x1, y1, x2, y2):
    #obvod obdélníku
    a = abs(x2 - x1)  
    b = abs(y2 - y1)  
    return 2 * (a + b)


def main():
    print("Zadejte souřadnice prvního bodu (x1, y1):")
    x1 = float(input("  x1 = "))
    y1 = float(input("  y1 = "))

    print("Zadejte souřadnice druhého bodu (x2, y2):")
    x2 = float(input("  x2 = "))
    y2 = float(input("  y2 = "))

    dist = distance(x1, y1, x2, y2)
    circ = circle_circumference(x1, y1, x2, y2)
    rect = rectangle_perimeter(x1, y1, x2, y2)

    print(f"\nVzdálenost bodů:  {dist:.4f}")
    print(f"Obvod kružnice:  {circ:.4f}")
    print(f"Obvod obdélníku:  {rect:.4f}")


if __name__ == "__main__":
    main()