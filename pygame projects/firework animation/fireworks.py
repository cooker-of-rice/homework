import pygame
import random
import math

pygame.init()

width, height = 800, 600
screen = pygame.display.set_mode((width, height))
pygame.display.set_caption("Firework Animation")
#raketa
firework_img = pygame.image.load("firework.png").convert_alpha()
firework_img = pygame.transform.scale(firework_img, (30, 30))  # Resize the image

# barvy
BLACK = (0, 0, 0)
FIREWORK_COLORS = [(255, 0, 0), (255, 165, 0), (255, 255, 0), (0, 128, 0), (0, 0, 255), (128, 0, 128)]

# částice
class Particle:
    def __init__(self, x, y, color, size, speed, angle):
        self.x = x
        self.y = y
        self.color = color
        self.size = size
        self.speed = speed
        self.angle = angle
        self.gravity = 0.05
        self.alpha = 255

    def move(self):
        self.x += math.cos(self.angle) * self.speed
        self.y += math.sin(self.angle) * self.speed + self.gravity
        self.speed -= 0.02
        self.size -= 0.02  # zmenšování
        self.alpha -= 3  # Fade out
        if self.alpha < 0:
            self.alpha = 0

    def draw(self):
        color_with_alpha = (self.color[0], self.color[1], self.color[2], self.alpha)
        pygame.draw.circle(screen, color_with_alpha, (int(self.x), int(self.y)), max(1, int(self.size)))

# Firework class
class Firework:
    def __init__(self):
        self.x = random.randint(0, width)
        self.y = height
        self.color = random.choice(FIREWORK_COLORS)
        self.exploded = False
        self.trail = []
        self.trail_length = 10
        self.particles = []
        self.explosion_delay = random.randint(20, 50)  # náhodný výbuch
        self.explode_y = random.randint(100, height - 200)  # náhodná y souřadnice

    def move(self):
        if not self.exploded:
            if len(self.trail) >= self.trail_length:
                self.trail.pop(0)
            self.trail.append((self.x, self.y))
            if self.y > self.explode_y:
                self.y -= random.randint(6, 10)  # rychlost výbuchu
            else:
                self.explode()
                self.y -= random.randint(2, 4)  # zpomalení před výbuchem

    def explode(self):
        self.exploded = True
        num_particles = random.randint(100, 200)
        for _ in range(num_particles):
            size = random.uniform(1, 3)
            speed = random.uniform(1, 3)
            angle = random.uniform(0, math.pi * 2)
            particle = Particle(self.x, self.y, self.color, size, speed, angle)
            self.particles.append(particle)

    def draw(self):
        if not self.exploded:
            screen.blit(firework_img, (self.x - firework_img.get_width() / 2, self.y - firework_img.get_height() / 2))
            for i, (x, y) in enumerate(reversed(self.trail)):
                alpha = int(255 * (i / self.trail_length))
                pygame.draw.circle(screen, (self.color[0], self.color[1], self.color[2], alpha), (int(x), int(y)), 3)
        else:
            for particle in self.particles:
                particle.move()
                particle.draw()
                if particle.size <= 0 or particle.alpha <= 0:  # smazat částice
                    self.particles.remove(particle)

# hlavní funkce
def main():
    fireworks = []

    # Game loop
    running = True
    while running:
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                running = False

        screen.fill(BLACK)

        # spawn
        if random.randint(0, 100) < 3:
            fireworks.append(Firework())

        # trail
        for firework in fireworks:
            firework.move()
            firework.draw()

            # smazat
            if firework.y < -firework_img.get_height() or (firework.exploded and not firework.particles):
                fireworks.remove(firework)

        pygame.display.flip()
        pygame.time.Clock().tick(60)

    pygame.quit()

if __name__ == "__main__":
    main()
