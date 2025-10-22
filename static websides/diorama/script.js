const canvas = document.getElementById('myCanvas');
const ctx = canvas.getContext('2d');
const numLines = 10;
const lines = [];
let isPulsing = true; 

function Line(radius, speed, color) {
    this.radius = radius;
    this.speed = speed;
    this.angle = 0;
    this.color = color;
    this.originalRadius = radius;
}

Line.prototype.draw = function() {
    ctx.strokeStyle = this.color;
    ctx.setLineDash([5, 3]);
    ctx.beginPath();
    ctx.arc(canvas.width / 2, canvas.height / 2, this.radius, this.angle, this.angle + Math.PI);
    ctx.stroke();
};

Line.prototype.update = function() {
    this.angle += this.speed;
    if (this.angle >= Math.PI * 2) {
        this.angle -= Math.PI * 2;
    }
};

function init() {
    let radiusIncrement = 20;
    let speedIncrement = 0.01;
    let colors = ['#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf', '#1f77b4'];

    for (let i = 0; i < numLines; i++) {
        let radius = 100 + i * radiusIncrement;
        let speed = 0.01 + i * speedIncrement;
        let color = colors[i % colors.length];
        lines.push(new Line(radius, speed, color));
    }
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    lines.forEach(function(line) {
        line.draw();
    });
}

function update() {
    lines.forEach(function(line) {
        line.update();
    });
}

function animate() {
    draw();
    update();
    if (isPulsing) {
        pulseLines();
    }
    requestAnimationFrame(animate);
}

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

function pulseLines() {
    lines.forEach(function(line) {
        line.radius = line.originalRadius + Math.sin(Date.now() / 200) * 10;
    });
}

window.addEventListener('resize', resizeCanvas);

init();
resizeCanvas();
animate();
