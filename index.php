<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель керування IoT</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            margin-top: 20px;
        }
        .devices {
            font-size: 0.9em;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
				<h1>Панель моніторингу та керування IoT приватного будинку</h1>
			</div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-header">
                        Розхід Електроенергії
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Поточний Розхід</h5>
                        <p class="card-text" id="power-usage">...</p>
                        <p class="devices" id="active-devices">...</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
			<div class="card text-center">
				<div class="card-header">
					Середня Температура
				</div>
				<div class="card-body">
					<h5 class="card-title">Температура</h5>
					<p class="card-text" id="average-temperature">...</p>
				</div>
			</div>
		</div>

		<script>
			function updateTemperature() {
				const temperature = (20 + Math.random() * 5).toFixed(2); // Випадкова температура від 20 до 25

				document.getElementById('average-temperature').textContent = temperature + ' °C';
			}

			setInterval(updateTemperature, 5000); // Оновлювати кожні 5 секунд
			updateTemperature(); // Початкове оновлення
		</script>
		
		<div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Керування Воріт</h5>
                    <p id="gate-icon" style="font-size: 2rem;">▼</p> <!-- Стартова іконка (закриті ворота) -->
                    <button id="gate-toggle" class="btn btn-primary">Відкрити Ворота</button>
                </div>
            </div>
        </div>
		
		<script>
			document.getElementById('gate-toggle').addEventListener('click', function() {
			var gateIcon = document.getElementById('gate-icon');
			var buttonText = this.textContent;

			if (buttonText === "Відкрити Ворота") {
				gateIcon.textContent = "▲"; // Іконка для відкритих воріт
				this.textContent = "Закрити Ворота";
			} else {
				gateIcon.textContent = "▼"; // Іконка для закритих воріт
				this.textContent = "Відкрити Ворота";
			}

			// Тут має бути код для відправлення команди на сервер
		});

		</script>
		
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Моніторинг Вологості</h5>
					<canvas id="humidityChart"></canvas>
				</div>
			</div>
		</div>
		
		<script>
		function updateHumidityChart(chart, label, data) {
			if (chart.data.labels.length > 20) { // Обмеження кількості точок даних
				chart.data.labels.shift();
				chart.data.datasets.forEach(dataset => dataset.data.shift());
			}

			chart.data.labels.push(label);
			chart.data.datasets.forEach(dataset => dataset.data.push(data));
			chart.update();
		}

		// Ініціалізація графіка вологості
		var ctx = document.getElementById('humidityChart').getContext('2d');
		var humidityChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: [],
				datasets: [{
					label: 'Вологість (%)',
					data: [],
					fill: false,
					borderColor: 'rgb(75, 192, 192)',
					tension: 0.1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});

		var currentHumidity = 50; // Початкове значення вологості

		// Функція для оновлення графіка з більш реалістичними даними
		setInterval(function() {
			var time = new Date().toLocaleTimeString();

			// Імітація зміни вологості
			var change = Math.random() * 10 - 5; // Вологість змінюється на -5 до +5
			currentHumidity = Math.max(0, Math.min(currentHumidity + change, 100)); // Гарантуємо, що вологість залишається в діапазоні 0-100

			updateHumidityChart(humidityChart, time, currentHumidity);
		}, 5000);
		</script>
		
		<div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Індикатор Рівня CO2</h5>
                    <p id="co2-indicator" style="font-size: 2rem; color: green;">▲ Низький</p>
                </div>
            </div>
        </div>
		
		<script>
			function updateCO2Indicator() {
				const co2Level = Math.random(); // Випадкове число від 0 до 1
				const co2Indicator = document.getElementById('co2-indicator');

				// Задаємо відсотки
				if (co2Level < 0.7) { // 70% ймовірність
					co2Indicator.textContent = '▲ Низький';
					co2Indicator.style.color = 'green';
				} else if (co2Level < 0.9) { // 20% ймовірність (70% + 20% = 90%)
					co2Indicator.textContent = '▲ Середній';
					co2Indicator.style.color = 'yellow';
				} else { // 10% ймовірність (решта)
					co2Indicator.textContent = '▲ Високий';
					co2Indicator.style.color = 'red';
				}
			}

			setInterval(updateCO2Indicator, 5000); // Оновлюємо індикатор кожні 5 секунд
			updateCO2Indicator(); // Початкове оновлення

		</script>
		
		<div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Керування Світлом</h5>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="kitchen-light">
                        <label class="custom-control-label" for="kitchen-light">Світло на Кухні</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="bathroom-light">
                        <label class="custom-control-label" for="bathroom-light">Світло у Ванній Кімнаті</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="livingroom-light">
                        <label class="custom-control-label" for="livingroom-light">Світло у Залі</label>
                    </div>
                </div>
            </div>
        </div>
		
		<script>
		document.querySelectorAll('.custom-control-input').forEach(lightSwitch => {
			lightSwitch.addEventListener('change', function() {
				// Тут код для синхронізації з сервером
				console.log(`Світло ${this.id}: ${this.checked ? 'ввімкнено' : 'вимкнено'}`);
			});
		});
		</script>
		
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Звукове Сповіщення</h5>
					<button id="sound-alert" class="btn btn-warning">Активувати Сповіщення</button>
					 <button id="stop-sound" class="btn btn-danger">Зупинити Звук</button>
				</div>
			</div>
		</div>
		
		<script>
		// Створення аудіооб'єкта
		var audio = new Audio('zvuk.mp3'); // Вкажіть шлях до вашого аудіофайлу

		// Функція для активації звукового сповіщення
		document.getElementById('sound-alert').addEventListener('click', function() {
			audio.play();
		});

		// Функція для зупинки звуку
		document.getElementById('stop-sound').addEventListener('click', function() {
			audio.pause();
			audio.currentTime = 0; // Скидування часу відтворення на початок
		});
		</script>
		
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function updatePowerUsage() {
            // Генерація випадкового значення розходу
            const powerUsage = 2 + Math.random() * 8;
            const devices = [];

            // Додавання приладів у залежності від розходу
            if (powerUsage > 2) devices.push('освітлення');
            if (powerUsage > 4) devices.push('духова шафа');
            if (powerUsage > 6) devices.push('бойлер');
            if (powerUsage > 8) devices.push('скважина', 'електрочайник');

            document.getElementById('power-usage').textContent = powerUsage.toFixed(2) + ' кВт/год';
            document.getElementById('active-devices').textContent = 'Активні прилади: ' + (devices.length ? devices.join(', ') : 'жоден');
        }

        setInterval(updatePowerUsage, 5000); // Оновлювати кожні 5 секунд
        updatePowerUsage(); // Початкове оновлення
    </script>
</body>
</html>
