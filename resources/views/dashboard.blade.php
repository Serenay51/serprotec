@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Mensaje de bienvenida -->
    <div class="alert alert-info" role="alert"
        style="text-align: center; font-size: 1.2em; margin-top: 20px;">
        <i class="fa fa-info-circle"></i>
        Bienvenido al panel de control. Aquí puedes ver un resumen de las ventas, clientes y productos.
    </div>
    <!-- Resumen de ventas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm text-center p-3 zoom-card">
                <h5 class="text-muted"><i class="fa fa-chart-line"></i> Ventas del mes</h5>
                <h2 class="text-success">{{ number_format($monthSalesCount) }}</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div id="balanceCard" class="card shadow-sm text-center p-3" style="cursor:pointer;">
                <h5 class="text-muted"><i class="fa fa-balance-scale"></i> Balance del mes</h5>
                <h2 class="text-success">${{ number_format($monthSales - $monthCosts, 2) }}</h2>
            </div>
        </div>

<script>
  const balanceCard = document.getElementById('balanceCard');

  balanceCard.addEventListener('click', () => {
    confetti({
      particleCount: 1000,
      spread: 1000,
      origin: { y: 0.3, x: 0.75 },
      gravity: 0.9,
      shapes: ['rectangle'],
      particleText: '💰',
      scalar: 1.2,
      ticks: 400,
      colors: ['#4caf50', '#388e3c', '#2e7d32'], // verdes para dar ambiente billetes
    });
  });
</script>

        <div class="mt-5 col-md-4">
            <canvas id="salesChart" width="200" height="200"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('salesChart').getContext('2d');
                var salesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Mes anterior', 'Mes actual'],
                        datasets: [
                            {
                                label: 'Ventas',
                                data: [{{ $lastMonthSalesCount }}, {{ $monthSalesCount }}],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(75, 192, 192, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)'
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'Clientes',
                                data: [{{ $lastMonthClients }}, {{ $monthClients }}],
                                backgroundColor: [
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    }
                });
            </script>
        </div>

    <!-- Total Clientes -->
    <div class="mt-5 col-md-2">
        <div class="card shadow-sm text-center p-3 zoom-card">
            <h5 class="text-muted"><i class="fa fa-users"></i> Clientes</h5>
            <h2>{{ $totalClients }}</h2>
        </div>
    </div>

    <!-- Total Ventas 
    <div class="mt-5 col-md-2">
        <div class="card shadow-sm text-center p-3 zoom-card">
            <h5 class="text-muted">Total Ventas</h5>
            <h2>${{ number_format($totalSales) }}</h2>
        </div>
    </div>-->

    <!-- Total Productos -->
    <div class="mt-5 col-md-2">
        <div class="card shadow-sm text-center p-3 zoom-card">
            <h5 class="text-muted"><i class="fa fa-box"></i> Productos</h5>
            <h2>{{ $totalProducts }}</h2>
        </div>
    </div>

    <!-- Total Proveedores -->
    <div class="mt-5 col-md-2">
        <div class="card shadow-sm text-center p-3 zoom-card">
            <h5 class="text-muted"><i class="fa fa-truck"></i> Proveedores</h5>
            <h2>{{ $totalProviders }}</h2>
        </div>
    </div>
</div>

<style>
  /* Zoom suave para las tarjetas de resumen */
  .card.shadow-sm.text-center.p-3 {
    transition: transform 0.3s ease;
    cursor: pointer;
  }

  .card.shadow-sm.text-center.p-3:hover {
    transform: scale(1.05);
    z-index: 10;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }
</style>

<!-- Ranking de productos -->
<div class="card shadow-sm mt-4 mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">🏆 Top productos vendidos</h5>
    </div>
    <div class="card-body text-center">
        @if($topProducts->isEmpty())
            <p class="text-muted">Aún no hay datos suficientes.</p>
        @else
            <div class="d-flex justify-content-center align-items-end" style="gap: 20px;">
                @foreach($topProducts as $index => $product)
                    <div class="text-center" style="flex:1;">
                        <div style="
                            background: {{ $index==0 ? '#FFD700' : ($index==1 ? '#C0C0C0' : ($index==2 ? '#CD7F32' : '#e9ecef')) }};
                            height: {{ 120 - ($index * 20) }}px;
                            width: 80px;
                            margin: 0 auto;
                            border-radius: 8px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:#000;
                            font-weight:bold;"
                            class="{{ $index == 0 ? 'aura-brillo-oro' : ($index == 1 ? 'aura-brillo-plata' : ($index == 2 ? 'aura-brillo-bronce' : '')) }}">
                            {{ $product->total_sold }}
                        </div>
                        <small class="d-block mt-2">{{ $product->name }}</small>
                        @if($index == 0) 🥇 @elseif($index == 1) 🥈 @elseif($index == 2) 🥉 @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
@keyframes brilloOro {
  0%, 100% {
    box-shadow:
      0 0 8px 2px #FFD700,
      0 0 15px 5px #FFD700cc,
      0 0 25px 10px #FFD70099;
  }
  50% {
    box-shadow:
      0 0 12px 4px #FFD700ff,
      0 0 25px 12px #FFD700dd,
      0 0 35px 15px #FFD700cc;
  }
}

@keyframes brilloPlata {
  0%, 100% {
    box-shadow:
      0 0 8px 2px #C0C0C0,
      0 0 15px 5px #C0C0C0cc,
      0 0 25px 10px #C0C0C099;
  }
  50% {
    box-shadow:
      0 0 12px 4px #C0C0C0ff,
      0 0 25px 12px #C0C0C0dd,
      0 0 35px 15px #C0C0C0cc;
  }
}

@keyframes brilloBronce {
  0%, 100% {
    box-shadow:
      0 0 8px 2px #CD7F32,
      0 0 15px 5px #CD7F32cc,
      0 0 25px 10px #CD7F3299;
  }
  50% {
    box-shadow:
      0 0 12px 4px #CD7F32ff,
      0 0 25px 12px #CD7F32dd,
      0 0 35px 15px #CD7F32cc;
  }
}

.aura-brillo-oro {
  animation: brilloOro 2.5s ease-in-out infinite;
  border-radius: 8px;
}

.aura-brillo-plata {
  animation: brilloPlata 2.5s ease-in-out infinite;
  border-radius: 8px;
}

.aura-brillo-bronce {
  animation: brilloBronce 2.5s ease-in-out infinite;
  border-radius: 8px;
}
</style>


<!-- Logros desbloqueables -->
@if(empty($achievements))
    <div class="alert alert-info text-center">
        <i class="fa fa-trophy"></i> ¡Desbloquea logros al usar el sistema!
    </div>
@endif
<div class="card shadow-sm mt-4 mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">🏅 Logros desbloqueables</h5>
    </div>
    <div class="card-body d-flex flex-wrap gap-3">
        @foreach($achievements as $index => $ach)
            <div class="achievement-card p-3 text-center rounded"
                data-unlocked="{{ $ach['unlocked'] ? '1' : '0' }}"
                style="flex:1; min-width:150px;
                       background: {{ $ach['unlocked'] ? '#d4edda' : '#f8f9fa' }};
                       border: 2px dashed {{ $ach['unlocked'] ? '#28a745' : '#ccc' }};
                       transition: transform 0.3s ease, box-shadow 0.3s ease; cursor:pointer;">
                <div style="font-size:22px;">{{ $ach['title'] }}</div>
                <small class="d-block mt-1 text-muted">{{ $ach['desc'] }}</small>
                @if($ach['unlocked'])
                    <span class="badge bg-success mt-2">Desbloqueado ✅</span>
                @else
                    <span class="badge bg-secondary mt-2">Bloqueado 🔒</span>
                @endif
            </div>
        @endforeach
    </div>
</div>

<style>
    .achievement-card:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
</style>

<script>
document.querySelectorAll('.achievement-card').forEach(card => {
    card.addEventListener('click', () => {
        if (card.dataset.unlocked === '1') {
            // 🎉 Dispara confeti
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });

            // Opción extra: mostrar un mensaje divertido
            Swal.fire({
                title: '¡Felicidades! 🎉',
                text: 'Logro desbloqueado: ' + card.querySelector('div').innerText,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
});
</script>




<!-- Ventas recientes -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Ventas recientes</h5>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th>N° Venta</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($recentSales as $sale)
                <tr>
                    <td>{{ $sale->number }}</td>
                    <td>{{ $sale->client->name }}</td>
                    <td>{{ $sale->date->format('d/m/Y') }}</td>
                    <td>${{ number_format($sale->total, 2) }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center p-3">No hay ventas recientes.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Vencimientos del mes -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Vencimientos del mes</h5>
    </div>
    <div class="card-body">
        @if($vencimientosPaginated->isEmpty())
            <p class="text-muted mb-0">No hay vencimientos este mes.</p>
        @else
            <ul class="list-group">
                @foreach($vencimientosPaginated as $prod)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">{{ $prod->name }}</span>
                            <br>
                            <small class="text-muted">Venta: {{ $prod->sale_number }}</small>
                            <br>
                            <small class="text-muted">Cliente: {{ $prod->client_name }}</small>
                            <br>
                            <small class="text-muted">Teléfono: {{ $prod->client_phone }}</small>
                            <br>
                            <small class="text-muted">Vencimiento:</small>
                            @if($prod->days_left == 0)
                                <span class="badge bg-danger">Hoy</span>
                            @elseif($prod->days_left == 1)
                                <span class="badge bg-warning">Mañana</span>
                            @else
                                <span class="badge bg-success">{{ $prod->vencimiento->format('d/m/Y') }}</span>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('sales.show', $prod->sale_id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-success"
                            onclick="openWhatsAppModal('{{ $prod->client_name }}', '{{ $prod->client_phone }}')">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Links de paginación -->
            <div class="mt-3">
                {{ $vencimientosPaginated->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Botón oculto para activar el juego -->
<button id="toggleGameBtn" style="position:fixed; bottom:20px; right:20px; z-index:1000; opacity:0.3; padding:10px 20px; border-radius:8px; background:#333; color:#fff; border:none; cursor:pointer;">
    🚀
</button>

<!-- Modal para el juego -->
<div id="gameModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.9); z-index:1050; justify-content:center; align-items:center;">
    <canvas id="galagaCanvas" width="600" height="400" style="background:#000; border: 2px solid white;"></canvas>
    <button id="closeGameBtn" style="position:absolute; top:20px; right:20px; padding:5px 10px;">Cerrar</button>
</div>


<script>
const toggleBtn = document.getElementById('toggleGameBtn');
const gameModal = document.getElementById('gameModal');
const closeBtn = document.getElementById('closeGameBtn');
const gameCanvas = document.getElementById('galagaCanvas');
const gameCtx = gameCanvas.getContext('2d');

let gameInterval;
let keys = {};
let player = { x: 280, y: 350, width: 40, height: 20, speed: 5, color: 'lime', bullets: [] };
let enemies = [];
let enemyRows = 3;
let enemyCols = 8;
let enemyWidth = 40;
let enemyHeight = 20;
let enemyPadding = 10;
let enemyOffsetTop = 30;
let enemyOffsetLeft = 30;
let enemyDirection = 1;
let enemySpeed = 1;
let score = 0;
let gameOver = false;

function createEnemies() {
    enemies = [];
    for(let r=0; r<enemyRows; r++) {
        for(let c=0; c<enemyCols; c++) {
            enemies.push({
                x: enemyOffsetLeft + c * (enemyWidth + enemyPadding),
                y: enemyOffsetTop + r * (enemyHeight + enemyPadding),
                width: enemyWidth,
                height: enemyHeight,
                alive: true,
                color: `hsl(${r*40}, 70%, 60%)`
            });
        }
    }
}

function drawPlayer() {
    gameCtx.fillStyle = player.color;
    gameCtx.fillRect(player.x, player.y, player.width, player.height);
}

function drawEnemies() {
    enemies.forEach(enemy => {
        if(enemy.alive){
            gameCtx.fillStyle = enemy.color;
            gameCtx.fillRect(enemy.x, enemy.y, enemy.width, enemy.height);
        }
    });
}

function moveEnemies() {
    let edgeReached = false;
    enemies.forEach(enemy => {
        if(enemy.alive) {
            enemy.x += enemyDirection * enemySpeed;
            if(enemy.x + enemy.width > gameCanvas.width || enemy.x < 0) {
                edgeReached = true;
            }
        }
    });
    if(edgeReached) {
        enemyDirection *= -1;
        enemies.forEach(enemy => {
            enemy.y += enemyHeight / 2;
        });
    }
}

function drawBullets() {
    gameCtx.fillStyle = 'yellow';
    player.bullets.forEach(bullet => {
        gameCtx.fillRect(bullet.x, bullet.y, bullet.width, bullet.height);
    });
}

function moveBullets() {
    player.bullets.forEach((bullet, i) => {
        bullet.y -= bullet.speed;
        if(bullet.y < 0) {
            player.bullets.splice(i, 1);
        }
    });
}

function checkCollisions() {
    player.bullets.forEach((bullet, bIndex) => {
        enemies.forEach(enemy => {
            if(enemy.alive && bullet.x < enemy.x + enemy.width && bullet.x + bullet.width > enemy.x &&
                bullet.y < enemy.y + enemy.height && bullet.y + bullet.height > enemy.y) {
                    enemy.alive = false;
                    player.bullets.splice(bIndex, 1);
                    score += 10;
            }
        });
    });
}

function drawScore() {
    gameCtx.fillStyle = 'white';
    gameCtx.font = '18px Arial';
    gameCtx.fillText('Puntaje: ' + score, 10, 20);
}

function update() {
    if(gameOver) return;
    gameCtx.clearRect(0, 0, gameCanvas.width, gameCanvas.height);

    if(keys['ArrowLeft'] && player.x > 0) {
        player.x -= player.speed;
    }
    if(keys['ArrowRight'] && player.x + player.width < gameCanvas.width) {
        player.x += player.speed;
    }

    moveEnemies();
    moveBullets();
    checkCollisions();

    drawPlayer();
    drawEnemies();
    drawBullets();
    drawScore();

    enemies.forEach(enemy => {
        if(enemy.alive && enemy.y + enemy.height > player.y) {
            gameOver = true;
            alert('Game Over! Tu puntaje fue: ' + score);
            closeGame();
        }
    });

    if(enemies.every(e => !e.alive)) {
        alert('¡Ganaste! Puntaje final: ' + score);
        closeGame();
    }
}

function shoot() {
    if(player.bullets.length < 3) {
        player.bullets.push({
            x: player.x + player.width/2 - 2,
            y: player.y,
            width: 4,
            height: 10,
            speed: 7
        });
    }
}

function startGame() {
    createEnemies();
    score = 0;
    gameOver = false;
    player.x = 280;
    player.bullets = [];
    enemyDirection = 1;

    gameInterval = setInterval(update, 30);
}

function closeGame() {
    clearInterval(gameInterval);
    gameModal.style.display = 'none';
}

window.addEventListener('keydown', e => {
    keys[e.key] = true;
    if(e.key === ' ' || e.key === 'Spacebar') {
        shoot();
        e.preventDefault();
    }
});
window.addEventListener('keyup', e => {
    keys[e.key] = false;
});

toggleBtn.addEventListener('click', () => {
    gameModal.style.display = 'flex';
    startGame();
});
closeBtn.addEventListener('click', closeGame);

</script>

<!-- Modal WhatsApp -->
<div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="whatsappModalLabel"><i class="fa-brands fa-whatsapp"></i> Enviar mensaje</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-2">Vas a enviar un mensaje a:</p>
        <h5 id="clientName" class="fw-bold"></h5>
        <p><i class="fa fa-phone"></i> <span id="clientPhone"></span></p>
        <textarea id="whatsappMessage" class="form-control mt-3" rows="2" placeholder="Escribe un mensaje..."></textarea>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="whatsappLink" href="#" target="_blank" class="btn btn-success">
            <i class="fa-brands fa-whatsapp"></i> Abrir en WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>

<script>
    function openWhatsAppModal(name, phone) {
        document.getElementById('clientName').innerText = name;
        document.getElementById('clientPhone').innerText = phone;
        document.getElementById('whatsappMessage').value = ''; // Limpia el mensaje anterior
        document.getElementById('whatsappLink').href = `https://api.whatsapp.com/send?phone=${phone}`;

        new bootstrap.Modal(document.getElementById('whatsappModal')).show();
    }

    // Actualiza el enlace con el mensaje escrito
    document.getElementById('whatsappMessage').addEventListener('input', function() {
        const phone = document.getElementById('clientPhone').innerText;
        const message = encodeURIComponent(this.value);
        document.getElementById('whatsappLink').href = `https://api.whatsapp.com/send?phone=${phone}&text=${message}`;
    });
</script>


@endsection


